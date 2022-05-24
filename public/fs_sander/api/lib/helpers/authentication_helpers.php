<?php

    use models\User;
    use services\requests\Request;

    function createJwtCookie(User $user): string {

        $minutes = 5;

        $token = generateJWT($user, $minutes);

        $expireAt = time() + 60 * $minutes;
        $options = ["expires"=>$expireAt, "secure"=>true, "httponly"=>true, "SameSite"=>"None"];

        //set HTTP_cookie for token
        setcookie("jwt", $token, $options);

        return $token;
    }

    function generateJWT(User $user, int $minutes=5): string {

        // Eerste deel van de JWT bevat info over algoritme & vervaltijd (om steeds nieuwe token te creëren)
        $header = base64_encode(json_encode(["token"=>"jwt", "alg"=>"sha256", "expire"=>time()+60*$minutes]));

        // Tweede deel van de JWT bevat info over de user
        if( $user ) {
            $user_data = ["usr_id"=>$user->getUsrId(), "usr_email"=>$user->getUsrEmail(), "usr_password"=>$user->getUsrPassword()];
            $payload = base64_encode(json_encode($user_data));
        }
        else $payload = explode(".", $_SESSION["__refresh_token__"])[1];

        // Derde en laatste deel van de JWT is een signature.
        // De signature is de gehashte waarde van "$header.$payload" volgens het algoritme bepaald in de $header
        $signature = hash_hmac("sha256", "BOO", "$header.$payload");

        return "$header.$payload.$signature";
    }

    /**
     * ProtectedRoute
     *
     * @param  Request $container
     * @return array
     */
    function ProtectedRoute(Request $request): array {

        [$header, $payload, $signature] = validateJWT($request);

        $user = getUserFromToken("$header.$payload.$signature", $request);

        $user_is_admin = $request->getUserHandler()
                                 ->getUserById($user->getUsrId(), $request->getDbManager())
                                 ->IsAdmin();

        // verleng session 60 min voor admin, 15 voor user.
        extendSession(boolval($user_is_admin) ? 60 : 15 );

        return validateJWT($request);
    }
    /**
     * AdminRoute
     *
     * @param  Request $request
     * @return void
     */
    function AdminRoute(Request $request): void {

        [$header, $payload, $signature] = validateJWT($request);
        $user = getUserFromToken("$header.$payload.$signature", $request);

        // check if user is admin
        $user_is_admin = $request->getUserHandler()
                                 ->getUserById($user->getUsrId(), $request->getDbManager())
                                 ->IsAdmin();

        if ( !boolval($user_is_admin) )
            $request->getResponseHandler()->unauthorized($request->getDbManager());

        // verleng sessie met 60 min.
        extendSession(60);
    }