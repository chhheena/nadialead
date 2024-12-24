<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string , mixed>
     */

    public function toArray(Request $request) : array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'role'          => $this->roles->pluck('name'),
            'parent_id'     => $this->parent,
            'parent'        => $this->parent?$this->team->name:'',
        ];
    }

}
