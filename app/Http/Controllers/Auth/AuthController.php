<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
// use App\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // public function register(RegistrationRequest $request)
    // {
    //     return $this->userService->createUser($request);
    // }

    public function login(LoginRequest $request)
    {
        return $this->userService->login($request);
    }

    // public function forgetPassword(Request $request) {
    //     return $this->userService->forgetPassword($request);
    // }

    public function logout(Request $request)
    {
        return $this->userService->logout($request);
    }

    // public function userProfile(){
    //     return $this->userService->getUserProfile();
    // }

    // public function resetPassword(ResetPasswordRequest $request){
    //     return $this->userService->resetPassword($request);
    // }
}
