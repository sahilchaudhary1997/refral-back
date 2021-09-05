<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Courses extends Model
{
    protected $fillable = [
        'varTitle',
		'txtDescription',
        'intOrder',	
        'chrIndiaFees',
        'chrWorldFees',
        'chrFeatured',
        'is_active',
        'is_delete',
		'chrActive',
        'chrDelete',
        'chrFree',
        'chrFeatured',
        'level',
        'moduleTypes',
        'categories',
        'features',
        'market',
        'coursePhoto',
        'courseDuration',
        'offlineCourseFee',
        'offlineRegisterLink',
    ];
	
	public static function getCourseByModuleId($id)
    { 
	    // return Courses::find($id);
		// DB::raw("CONCAT('http://marketmantra99.shreejasales.com/uploads/',courses.CoursePhoto) AS imageUrl")
		$data = DB::table("courses")
        ->select('courses.varTitle as title','courses.id as id','levels.name as levelName','markets.name as marketName','courses.coursePhoto as imageName',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw("GROUP_CONCAT(categories.name) as categoriesName"))
		->join('levels', 'levels.id', '=', 'courses.level')
		->join('markets', 'markets.id', '=', 'courses.market')
        ->leftjoin("categories",DB::raw("FIND_IN_SET(categories.id,courses.categories)"),">",DB::raw("'0'"))
        ->groupBy("courses.id")
		->where('moduleTypes', $id)
		->where('courses.is_active', '1')
		->where('courses.is_delete', '0')
        ->get();
		
		return $data;
		//return Courses::select('varTitle as title', 'id')
		
		//->where('moduleTypes', $id)->where('is_active', '1')->where('is_delete', '0')->orderBy('intOrder','asc')->get();
    }
    
    public static function getAllCourseList(){

        $data = DB::table("courses")
        ->select('*')
		->where('is_active', '1')
		->where('is_delete', '0')
        ->get();
		
        return $data;
    }
    
}
