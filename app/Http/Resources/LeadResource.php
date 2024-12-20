<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string , mixed>
     */

    public function toArray(Request $request): array
    {

        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'phone'                 => $this->phone,
            'city'                  => $this->city,
            'state'                 => $this->state,
            'source'                => $this->source,
            'lead_tag'              => $this->lead_tag,
            'qualification_status'  => $this->qualification_status,
            'rating'                => $this->rating,
            'note'                  => $this->note,
            'note_strike_first'     => $this->note_strike_first,
            'action'                => $this->action,
            'status'                => $this->status,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            'start_time'            => $this->start_time,
            'lead_id'               => $this->lead_id
        ];
    }
}
