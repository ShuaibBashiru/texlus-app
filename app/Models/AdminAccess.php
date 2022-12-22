<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccess extends Model
{
    use HasFactory;
    protected $table = 'admins_access';
    protected $hidden = ['id'];
}
