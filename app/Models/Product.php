<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'sku',
        'type',
        'cost_price',
        'status',
        'created_at',
        'updated_at'
    ];
}
