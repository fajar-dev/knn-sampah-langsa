<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Data extends Model
{
    use HasFactory;

    protected $table = 'data';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'year',
        'organic',
        'unorganic',
    ];
}
