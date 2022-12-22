<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteLink extends Model
{
    use HasFactory;
    protected $table = 'admin_record';
    protected $protected = ['id'];
}
