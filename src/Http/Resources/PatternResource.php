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
                'name' => $this->name,
                'type' => $this->getType(),
                'description' => trim($this->metadata->body()),
                'status' => $this->metadata->status,
                'usage' => $this->getUsage(),
                'template' => $this->template,
                'html' => $this->html,
                'sass' => $this->sass
            ]
        ];
    }

    /**
     * Get the Pattern's type.
     *
     * @return bool|string
     */
    private function getType()
    {
        $explode = explode('.', $this->name);
        return $type = substr(array_first($explode), 0, -1);
    }

    private function getUsage()
    {
        $explode = explode('.', $this->name);
        array_shift($explode);
        return implode('.', $explode);
    }


}
