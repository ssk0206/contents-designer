<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $fillable = [
        'component_id',
        'content',
        'order',
    ];


    public function Component()
    {
        return $this->belongsTo('App\Models\Component');
    }
}
