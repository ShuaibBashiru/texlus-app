<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePages extends Model
{
    use HasFactory;
    protected $table = 'landing_page';
    protected $protected = ['id'];
}
