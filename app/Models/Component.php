<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'order',
    ];

    public function Columns()
    {
        return $this->hasMany('App\Models\Column');
    }

    public function Page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}
