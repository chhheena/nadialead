<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadColor extends Model
{
    protected $guarded = ['id'];

    protected $table = "leads_colors";
    public $timestamps = false;

}
