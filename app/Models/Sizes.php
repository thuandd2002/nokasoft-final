<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sizes extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "sizes";
    protected $fillable = ['id', 'product_id', 'name'];
}
