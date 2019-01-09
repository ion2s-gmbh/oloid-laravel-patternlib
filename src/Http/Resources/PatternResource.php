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
                'sass' => $this->sass,
                'values' => $this->values
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
        return $type = array_first($explode);
    }

    private function getUsage()
    {
        $explode = explode('.', $this->name);
        array_shift($explode);
        $name = implode('.', $explode);
        $type = $this->getType();

        $valuesString = $this->getValuesAsString($this->metadata->values);

        return "@{$type}('{$name}', {$valuesString})";
    }

    /**
     * Convert the metadata values to an array string representation.
     * @return string
     */
    private function getValuesAsString($values): string
    {
        $argsString = '[';
        $args = [];

        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (is_array($value)) {
                    $value = $this->getValuesAsString($value);
                    $args[] = "'{$key}' => {$value}";
                } else {
                    $args[] = "'{$key}' => '{$value}'";
                }
            }
        }

        $argsString .= implode(', ', $args);
        $argsString .= ']';
        return $argsString;
    }
}
