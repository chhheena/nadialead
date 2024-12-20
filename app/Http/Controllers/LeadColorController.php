<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadColorPostRequest;
use App\Http\Requests\StoreLeadColorRequest;
use App\Http\Requests\UpdateLeadColorRequest;
use App\Models\Lead;
use App\Models\LeadColor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class LeadColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $id = 0)
    {
        $roles = Role::select('id','name')->get();
        $columns = Schema::getColumnListing((new Lead())->getTable());

        $row = LeadColor::find($id);
        $colors = LeadColor::get();

        return Inertia::render('Lead/LeadColor', compact('columns','roles', 'colors','row'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadColorPostRequest $request, int $id = 0)
    {
        $data = $request->validated();

        if(!$id) {
            $res = LeadColor::create($data);
            $action = "added";
        } else {
            $res = LeadColor::where('id', $id)->update($data);
            $action = "updated";
        }

        return response()->route('lead_color')->with('success', "Color to lead {$action} successfully.");
    }

    public function delete(LeadColor $id)
    {
        $row = LeadColor::find($id);
        if(!$row) {
            return response()->route('lead_color')->with('error', "Something went wrong.");
        }
        $row->delete();
        return response()->route('lead_color')->with('success', "Color of lead is deleted successfully.");
    }

}
