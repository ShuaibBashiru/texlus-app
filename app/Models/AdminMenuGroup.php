<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenuGroup extends Model
{
    use HasFactory;
    protected $table = 'admin_app_menu_group';
    protected $protected = ['id'];
}
