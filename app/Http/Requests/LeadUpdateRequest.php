<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LeadUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add authorization logic here if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userRole = Auth::user()->roles->first()?->name;



        return [];
    }

    /**
     * Filter the input data based on the user's role.
     *
     * @return array
     */
    public function filteredData(): array
    {
        $inputs = $this->all();
        $userRole = Auth::user()->roles->first()?->name;
        if ($userRole === 'client') {
            return $this->only('action', 'status', 'note_strike_first');
        } elseif ($userRole === 'team') {
            return $this->only('lead_tag', 'qualification_status', 'rating', 'note');
        }
        return $inputs;
    }
}
