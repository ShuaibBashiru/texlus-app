<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPassport extends Model
{
    use HasFactory;
    protected $table = 'admin_passport';
    protected $protected = ['id'];
}
