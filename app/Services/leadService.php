<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

class leadService
{
    public function getList($inputs)
    {
        try {
            $perPage = !empty($inputs["params"]) ? $inputs["params"] : 10;
            $leads = Lead::latest();
            if (isset($inputs["search"])) {
                $search = trim($inputs["search"]);
                $leads = $leads->where(function ($q) use ($search) {
                    $q->where('email', 'LIKE', '%' . $search . '%');
                });
            }
            $perPage = !empty($inputs["perPage"]) ? $inputs["perPage"] : $perPage;
            return $perPage != 'all' ? $leads->paginate($perPage) : $leads->get();
        } catch (\Exception | RequestException $e) {
            Log::error('lead fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function store($inputs)
    {
        try {
            DB::beginTransaction();
            $model = Lead::create($inputs);
            DB::commit();
            return $model;
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('lead store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $model = Lead::find($id);
            return $model;
        } catch (\Exception | RequestException $e) {
            Log::error('lead fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update($inputs, $id)
    {
        try {
            DB::beginTransaction();
            $lead = Lead::find($id);
            $model = $lead->update($inputs);
            DB::commit();
            return $model;
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('lead update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
