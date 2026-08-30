<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $primaryKey = 'url';
    protected $keyType = 'string';
    public $incrementing = false;
}
