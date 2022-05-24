<?php

    use models\User;

    function createJwtCookie(User $user): string {

        $minutes = boolval($user->IsAdmin()) ? 15 : 5;

        $token = generateJWT($user, $minutes);

        $expireAt = time() + 60 * $minutes;
        $options = ["expires"=>$expireAt, "secure"=>true, "httponly"=>true, "SameSite"=>"None"];

        //set HTTP_cookie for token
        setcookie("jwt", $token, $options);

        return $token;
    }

    function generateJWT(User $user, int $minutes=5): string {

        // Eerste deel van de JWT bevat info over algoritme & vervaltijd (om steeds nieuwe token te creëren)
        $header = base64_encode(json_encode(["token"=>"jwt", "alg"=>"sha256", "exp"=>time()+60*$minutes]));

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