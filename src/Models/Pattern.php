<?php

namespace Laratomics\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = [
        'name',
        'template',
        'html',
        'sass',
        'markdown',
        'preview',
        'metadata',
        'templateFile',
        'sassFile',
        'rootSassFile',
        'markdownFile',
        'values',
        'status',
        'counter'
    ];

    /**
     * Get the Pattern's type.
     *
     * @return bool|string
     */
    public function getType()
    {
        $explode = explode('.', $this->name);
        return $type = array_first($explode);
    }

    /**
     * Get the Pattern's name without the first part, that represents the Pattern's type.
     *
     * @return string
     */
    public function getNameWithoutType()
    {
        $explode = explode('.', $this->name);
        $type = array_shift($explode);
        return implode('.', $explode);
    }
}
