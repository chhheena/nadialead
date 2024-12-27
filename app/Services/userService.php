<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class userService
{
    public function getList($inputs)
    {
        try {
            $perPage = !empty($inputs["params"]) ? $inputs["params"] : 10;
            $sortOrder = !empty($inputs['sortOrder']) ? $inputs['sortOrder'] : 'DESC';
            $sortBy = !empty($inputs['sortBy']) ? $inputs['sortBy'] : 'id';
            $users = User::with(['roles', 'team'])->has('roles')->orderBy($sortBy, $sortOrder);
            if (!empty($inputs['filters'])) {
                if (!empty($inputs['filters']['role'])) {
                    $role = $inputs['filters']['role'];
                    $users->whereHas('roles', function ($query) use ($role) {
                        $query->where('name', $role);
                    });
                }
            }
            if (isset($inputs["search"])) {
                $search = trim($inputs["search"]);
                $users = $users->where(function ($q) use ($search) {
                    $q->where('email', 'LIKE', '%' . $search . '%');
                });
            }
            $perPage = !empty($inputs["perPage"]) ? $inputs["perPage"] : $perPage;
            return $perPage != 'all' ? $users->paginate($perPage) : $users->get();

        } catch (\Exception  | RequestException $e) {
            Log::error('user fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function store($inputs)
    {
        try {
            DB::beginTransaction();
            $model = User::create($inputs);
            $model->assignRole($inputs['role']);
            DB::commit();
            return $model;
        } catch (\Exception  | RequestException $e) {
            DB::rollback();
            Log::error('user store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($id)
    {
        $row = User::with(['roles', 'team'])->find($id);
        return $row;
    }

    public function update($inputs, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $model = $user->update($inputs);
            DB::commit();
            return $model;
        } catch (\Exception  | RequestException $e) {
            DB::rollback();
            Log::error('user update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function login($request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            info([
                'user-details' => $user->getRoleNames()->toarray()
            ]);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return ApiResponse::error('The provided credentials are incorrect.', 500);
            }
            $token = $user->createToken(env('APP_NAME'))->plainTextToken;
            $response = [
                'user_detail' => $user,
                'token' => $token,
            ];
            return ApiResponse::success($response);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success('User logout successfully');
    }

    public function forgetPassword($request)
    {
        $userDetail = User::where('email', $request->email)->first();
        if (!isset($userDetail)) {
            return ApiResponse::error('Email is not exist', 401);
        }
        // SendForgetPasswordJob::dispatch($userDetail);
        return ApiResponse::success('Please check you email, We have send you forget password link on you email');
    }

    public function resetPassword($request)
    {
        try {
            $userId = Crypt::decrypt($request->user_id);
            $user = User::find($userId);

            if (!isset($user)) {
                return ApiResponse::error('User is not exist.', 500);
            }
            $user->update([
                'password' => $request->password,
            ]);
            return ApiResponse::success('Password has been updated successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function socialHandler($userDetail)
    {
        try {
            if ($userDetail) {
                $user = User::updateOrCreate([
                    'email' => $userDetail['email'],
                ], [
                    'name' => $userDetail['name'],
                    'google_id' => $userDetail['google_id'],
                    'email_verified_at' => now(),
                    'password' => rand(100000, 999999),
                ]);

                $token = $user->createToken(env('APP_NAME'))->plainTextToken;
                $response = [
                    'user_detail' => $user,
                    'token' => $token,
                ];

                return ApiResponse::success($response);
            } else {
                return ApiResponse::error('Invalid Google token', 401);
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function createUser($request)
    {
        try {
            $userDetail = $request->all();
            // $user->assignRole($validatedData['role']);
            $createUser = User::create($userDetail);
            if ($createUser) {
                $message = 'User created successfully';
                return ApiResponse::success($message);
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function getUserProfile()
    {
        $userDetail = Auth::user();
        return ApiResponse::success($userDetail);
    }

    public function updateProfile($request)
    {
        $isUserExist = User::find($request->id);
        if(!isset($isUserExist)){
            return ApiResponse::error('User is not exist in our database', 500);
        }
        $isUserExist->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return ApiResponse::success($isUserExist->refresh());
    }

    public function updateProfilePassword($request)
    {
        $isUserExist = User::find($request->id);
        if(!isset($isUserExist)){
            return ApiResponse::error('User is not exist in our database', 500);
        }
        $isUserExist->update([
            'password' => $request->new_password,
        ]);
        return ApiResponse::success($isUserExist->refresh());
    }
}
