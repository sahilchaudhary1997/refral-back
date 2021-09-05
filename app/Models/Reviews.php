<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [        
		'txtComment',
        'intUserId',
        'intCourseId',
        'intNumberofRating',
		'is_active',
        'is_delete',        
    ];
}
