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
        'markdown'
    ];
}
