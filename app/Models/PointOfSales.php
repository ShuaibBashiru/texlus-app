<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSales extends Model
{
    use HasFactory;
    protected $table = 'sales_records';
    protected $protected = ['id'];
}
