<?php

namespace Laratomics\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = [
        'name',
        'state',
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
}
