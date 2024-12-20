<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class LeadColor extends Model
{

    protected $guarded = ['id'];

    protected $table = "leads_colors";
    public $timestamps = false;


    public function setRoleAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['role'] = implode(',', $value);
        } else {
            $this->attributes['role'] = $value;
        }
    }

    public function getRoleAttribute($value)
    {
        if(!$value) {
            return [];
        }
        return explode(',', $value);
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'id', 'role');
    }

}
