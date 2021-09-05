<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CmsPages extends Model
{	
	protected $table = 'cms_pages';
	
    protected $fillable = [
        'varTitle',
		'txtDescription',
        'is_active',
        'is_delete',
		'pagePhoto',
        'pagePhotoName',
    ];
	
	
    public static function getAllPagesList(){

        $data = DB::table("cms_pages")
        ->select('*')
		->where('is_active', '1')
		->where('is_delete', '0')
        ->get();
		
        return $data;
    }
}
