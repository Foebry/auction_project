<?php


    use services\requests\Request;

    function startSession(int $usr_id, Request $request): void {
        
        session_start(["cookie_samesite"=>"None", "cookie_secure"=>true]);
        $_SESSION["csrf"] = generateCSRF();
        
        $user = $request->getUserHandler()->getUserById($usr_id, $request->getDbManager());
        // print(json_encode($user->asAssociativeArray()));
        // exit();
        
        // na 15 min geen activiteit zal de session vervallen voor user. 60 min voor admin.
        $_SESSION["__refresh_token__"] = generateJWT($user, $user->IsAdmin() ? 60 : 15);

        // JWT vervalt na 5 min voor user, 15 min voor admin.
        createJwtCookie($user, $user->IsAdmin() ? 15 : 5);
    }

    function destroySession(): void {
        unset($_SESSION["__refresh_token__"]);
        unset($_SESSION["csrf"]);
        setcookie("PHPSESSID", session_id(), ["expires"=>time(), "SameSite"=>"None", "secure"=>true]);
        session_destroy();
    }

    function extendSession(int $minutes):void {
        [$header, $user_info] = explode(".", $_SESSION["__refresh_token__"]);
        // reset header expire time
        $header = json_decode(base64_decode($header), true);
        $header["expire"] = time() + 60 * $minutes;
        $header = base64_encode(json_encode($header));
        //renew signature
        $signature = hash_hmac("sha256", "$header.$user_info", "BOO");
        //reset refresh token
        $_SESSION["__refresh_token__"] = "$header.$user_info.$signature";
    }

    function sessionExpired(): bool {

        $header = explode(".", $_SESSION["__refresh_token__"])[0];

        $header = json_decode(base64_decode($header), true);

        $expire = $header["expire"];

        return $expire < time();
    }