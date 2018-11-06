<?php

namespace Laratomics\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatternResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'name' => $request->get('name')
        ];
    }
}
