<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class userService
{
    public function getList($inputs)
    {
        try {

            $perPage = !empty($inputs["params"]) ? $inputs["params"] : 10;
            $users = User::with(['roles','team'])->latest();
            if (isset($inputs["search"])) {
                $search = trim($inputs["search"]);
                $users = $users->where(function ($q) use ($search) {
                    $q->where('email', 'LIKE', '%' . $search . '%');
                });
            }
            $perPage = !empty($inputs["perPage"]) ? $inputs["perPage"] : $perPage;
            return $perPage != 'all' ? $users->paginate($perPage) : $users->get();

        } catch (\Exception | RequestException $e) {
            Log::error('user fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function store($inputs)
    {
        try {
            DB::beginTransaction();
            $model = User::create($inputs);
            DB::commit();
            return $model;
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('user store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($id)
    {
        $row =  User::with(['roles','team'])->find($id);
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
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('user update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
