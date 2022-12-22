<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPages extends Model
{
    use HasFactory;
    protected $table = 'admin_pages';
    protected $hidden = ['id'];
}
