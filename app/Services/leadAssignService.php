<?php

namespace App\Services;

use App\Models\AssignLeadField;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

class  leadAssignService
{
    public function getFields()
    {
        try {
            $columns = Schema::getColumnListing('leads');
            $columnsFields = array_keys(Arr::except(array_flip($columns), ['created_at', 'updated_at', 'id']));
            if (is_array($columns)) {
                return ApiResponse::success($columnsFields);
            }
            return ApiResponse::error('Data not found', 204);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function getAssignFields($roleId){
        try {
            $getAssignColumn = AssignLeadField::where('role_id', $roleId)->pluck('lead_assign_fields')->toarray();
            if ($getAssignColumn) {
                return ApiResponse::success($getAssignColumn);
            }
            return ApiResponse::success('Data not found', 204);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function assignFields($request){
        
        try {
            AssignLeadField::where('role_id', $request->roleId)->delete();
            foreach($request->leadAssignFields as $fields){
                AssignLeadField::create(
                [
                    'role_id' => $request->roleId,
                    'lead_assign_fields' => $fields,
                ]);
            }
            return ApiResponse::success('Permission added successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}
