<?php

namespace Oloid\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Oloid\Services\PatternStatusService;

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
        /*
         * Get the PatternStatusService singleton from the IoC container.
         */
        $patternStatusService = app(PatternStatusService::class);

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
                'values' => $this->values,
                'subPatterns' => $patternStatusService->getPatterns()
            ]
        ];
    }

    /**
     * Generate the usage string.
     *
     * @return string
     */
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
     *
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
