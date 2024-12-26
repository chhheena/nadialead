<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Spatie\Permission\Models\Role;

class roleService
{
    public function getList($inputs)
    {
        try {

            $perPage = !empty($inputs["params"]) ? $inputs["params"] : 10;
            $roles = Role::latest();
            if (isset($inputs["search"])) {
                $search = trim($inputs["search"]);
                $roles = $roles->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            }
            $perPage = !empty($inputs["perPage"]) ? $inputs["perPage"] : $perPage;
            return $perPage != 'all' ? $roles->paginate($perPage) : $roles->get();

        } catch (\Exception | RequestException $e) {
            Log::error('user fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
