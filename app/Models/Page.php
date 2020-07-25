<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name'
    ];

    public function Components()
    {
        return $this->hasMany('App\Models\Component');
    }
}
