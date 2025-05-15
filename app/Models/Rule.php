<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    
    protected $table = 'rule';

    protected $fillable = [
        'r1',
        'r2',
        'r3',
        'r4',
    ];
}
