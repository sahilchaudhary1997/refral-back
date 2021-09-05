<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AddAdminPagesRequest;
use App\Http\Requests\Admin\UpdateAdminPagesRequest;
use Config;
use App\Models\CmsPages;


class ManageAdminPagesController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage CMS Pages']];

    public function __construct() {
        parent::__construct(); 
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = CmsPages::where(function($q)use($filter) {
			if (!empty($filter['search'])) {
				$q->where('varTitle', 'LIKE', '%' . $filter['search'] . '%');
			}
		})->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.cms_pages.list', compact('breadcum', 'users', 'filter'));
    }

    public function create() {
        $breadcum = $this->breadcum;		
        // $categorydata = category::getList();
        return view('admin.cms_pages.create', compact('breadcum'));
    }

    public function store(AddAdminPagesRequest $request) {
        $all = $request->all();
		
		$inserarr = array();
		$inserarr['varTitle'] = $request->title;		
		$inserarr['txtDescription'] = $request->description;
		if ( $request->hasFile('pagePhoto')){
			if ($request->file('pagePhoto')->isValid()){
				$FileFullName = $request->file('pagePhoto')->getClientOriginalName();
				$extension = $request->file('pagePhoto')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('pagePhoto')->getClientOriginalName();
				$request->file('pagePhoto')->move('uploads' , $FileInsertname);
				$inserarr['pagePhotoName'] = $FileName;
				$inserarr['pagePhoto'] = $FileInsertname;				
			}
		}		
        $inserarr['is_active'] = 1;
        $inserarr['is_delete'] = 0;
        $role = CmsPages::create($inserarr);
        return redirect()->route('adminPages')->with('success', 'New CMS pages added successfully.');
    }

    public function edit($id) {
        $user = CmsPages::find($id);		
        $breadcum = $this->breadcum;
        return view('admin.cms_pages.update', compact('breadcum', 'user'));
    }

    public function update(UpdateAdminPagesRequest $request) {
        $all = $request->all();
		
		$updatearr = array();
		$updatearr['varTitle'] = $request->title;		
		$updatearr['txtDescription'] = $request->description;
		if ($request->hasFile('pagePhoto')){
			if ($request->file('pagePhoto')->isValid()){
				$FileFullName = $request->file('pagePhoto')->getClientOriginalName();
				$extension = $request->file('pagePhoto')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('pagePhoto')->getClientOriginalName();
				$request->file('pagePhoto')->move('uploads' , $FileInsertname);
				$updatearr['pagePhotoName'] = $FileName;
				$updatearr['pagePhoto'] = $FileInsertname;				
			}
		}		
        $updatearr['is_active'] = 1;
        $updatearr['is_delete'] = 0;
		CmsPages::where('id',$request->uid)->update($updatearr);

        // Courses::find($all['uid'])->update($all);
        return redirect()->route('adminPages')->with('success', 'CMS pages updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = CmsPages::find($request->id);
			// echo $record->is_active;exit;
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    CmsPages::find($record->id)->update(['is_active' => 0]);
                } else {
                    CmsPages::find($record->id)->update(['is_active' => 1]);
                }
                return 'success';
            }
            return 'Record not found';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
        CmsPages::destroy($id);
        return redirect()->back()->with('success', 'CMS pages deleted successfully.');
    }

}
