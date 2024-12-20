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

            if (!empty($inputs['filters'])) {
                if (!empty($inputs['filters']['leadTag'])) {
                    $lead_tags = $inputs['filters']['leadTag'];
                    $leads->where('lead_tag', $lead_tags);
                }
                if (!empty($inputs['filters']['rating'])) {
                    $lead_tags = $inputs['filters']['rating'];
                    $leads->where('rating', $lead_tags);
                }
                if (!empty($inputs['filters']['noteStrikeFirst'])) {
                    $lead_tags = $inputs['filters']['noteStrikeFirst'];
                    $leads->where('note_strike_first', $lead_tags);
                }
                if (!empty($inputs['filters']['status'])) {
                    $lead_tags = $inputs['filters']['status'];
                    $leads->where('status', $lead_tags);
                }
            }
            if (isset($inputs["search"])) {
                $search = trim($inputs["search"]);
                $leads = $leads->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone',$search)->orWhere('phone',$search);
                });
            }
            $perPage = !empty($inputs["perPage"]) ? $inputs["perPage"] : $perPage;
            return $perPage != 'all' ? $leads->paginate($perPage) : $leads->get();
        } catch (\Exception | RequestException $e) {
            Log::error('leads fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function store($inputs)
    {
        try {
            return Lead::create($inputs);
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('lead store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($lead)
    {
        try {
            return $lead;
        } catch (\Exception | RequestException $e) {
            Log::error('lead fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update($inputs, $lead)
    {
        try {
            return $lead->update($inputs);
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('lead update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
