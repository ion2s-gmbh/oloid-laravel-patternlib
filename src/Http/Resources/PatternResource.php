<?php

namespace Laratomics\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatternResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'patternName' => $this->name,
                'type' => $this->getType(),
                'description' => $this->metadata->body(),
                'status' => $this->metadata->status,
                'usage' => '',
                'markup' => $this->markup,
                'html' => $this->html,
                'sass' => $this->sass
            ]
        ];
    }

    private function getType()
    {
        $explode = explode('.', $this->name);
        return $type = substr(array_first($explode), 0, -1);
    }
}
