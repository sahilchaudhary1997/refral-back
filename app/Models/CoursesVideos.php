<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CoursesVideos extends Model
{
    protected $table = 'courses_videos';
    protected $fillable = [        
		'courseid',
        'title',
		'description',
		'videoorder',
		'videoname',
		'is_active',
		'is_delete',
		'created_at',		
		'updated_at'
    ];
	
	
}
