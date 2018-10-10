<?php

namespace Intellect\Auth;

use ReallySimpleJWT\TokenValidator;
use App\Models\User;

class Authenticate
{
    public function authenticateWithToken($token)
    {
        $user = new User(1, 'kemalyen@gmail.com');
        return $user;   
    }

    protected function getPayload($token)
    {
        $validator = new TokenValidator;
        $validator->splitToken($token)
            ->validateExpiration()
            ->validateSignature($secret);
        $payload = $validator->getPayload();
        return json_decode($payload);        
    }
}