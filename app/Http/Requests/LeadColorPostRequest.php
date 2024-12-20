<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class LeadColorPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'column_key' => ['required',Rule::in($this->getLeadColumns())],
            'color' => ['required'],
            'role' => ['required', Rule::in($this->roles())],
        ];
    }

    private function getLeadColumns()
    {
        $columns = $columns = Schema::getColumnListing((new Lead())->getTable());
        return $columns;
    }

    public function roles()
    {
        $roles = Role::select('id')->get();

        if($roles->count()) {
            return $roles->map(fn ($item) => $item->id)->toArray();
        } else {
            return [];
        }
    }
}
