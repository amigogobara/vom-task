<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Merchant\Authentication;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public $authentication;


    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function register(RegisterRequest $request)
    {
        return $this->apiResponse($this->authentication->register($request));
    }

    public function login()
    {
        $login = $this->authentication->login();
        if(is_int($login)){
            return $this->apiResponse(new \stdClass(),'wrong email or password',401);
        }

        return  $this->apiResponse($login);
    }

    public function logout()
    {
        auth()->guard('api')->logout();

        return $this->apiResponse(new \stdClass(),'Logout successfully');
    }
}
