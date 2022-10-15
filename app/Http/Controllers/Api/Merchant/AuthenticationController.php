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

    }

    public function logout()
    {

    }
}
