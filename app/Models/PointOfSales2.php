<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSales2 extends Model
{
    use HasFactory;
    protected $table = 'sales_records_2';
    protected $protected = ['id'];
}
