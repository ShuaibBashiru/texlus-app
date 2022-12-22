<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnverifiedUsers extends Model
{
    use HasFactory;
    protected $table = 'unverify_users';
}
