<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPassport extends Model
{
    use HasFactory;
    protected $table = 'user_passport';
    protected $protected = ['id'];
}
