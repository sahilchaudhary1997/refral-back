<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\foodmanager;
use App\Http\Requests\Admin\AddAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use Config;

class FoodManagerController extends SystemAdminController
{
    var $breadcum = ['icon'=>'mdi mdi-account-multiple','breadcum'=>['Manage Food Manager']];

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $foodmanager = foodmanager::where(function($q)use($filter){
                    if(!empty($filter['search'])){
                        $q->where('name','LIKE','%'.$filter['search'].'%')
                        ->orwhere('email','LIKE',$filter['search']);
                    }
                })
                ->orderBy('created_at','desc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_foodmanager.list',compact('breadcum','foodmanager','filter'));
    }

    public function create()
    {
        $breadcum = $this->breadcum;
        $roles = roles::getList();
        return view('admin.manage_foodmanager.create',compact('breadcum','roles'));
    }

    public function store(AddAdminUserRequest $request)
    {
        $all = $request->all();
        $all['role_id'] = base64_decode($all['role_id']);
        $all['password'] = bcrypt($all['password']);
        $all['is_active'] = 1;
        $role = foodmanager::create($all);
        return redirect()->route('adminUserManager')->with('success','New admin user added successfully.');
    }

    public function edit($id)
    {
        $user = foodmanager::find($id);
        $roles = roles::getList();
        $breadcum = $this->breadcum;
        return view('admin.manage_foodmanager.update',compact('breadcum','roles','user'));
    }

    public function update(UpdateAdminUserRequest $request)
    {
        $all = $request->all();
        $all['role_id'] = base64_decode($all['role_id']);
        if(!empty($all['password'])){
            $all['password'] = bcrypt($all['password']);
        }else{
            unset($all['password']);
        }
        foodmanager::find($all['uid'])->update($all);
        return redirect()->route('adminUserManager')->with('success','User updated successfully.');
    }

    public function publish(Request $request)
    {
        try{
            $record = foodmanager::find($request->id);
            if(!empty($record)){
                if($record->is_active == 1){
                    foodmanager::find($record->id)->update(['is_active'=>0]);
                }else{
                    foodmanager::find($record->id)->update(['is_active'=>1]);
                }
                return 'success';
            }
            return 'Record not found';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        if($id == 1 || $id == 2){
            return redirect()->back()->with('error','You can not delete admin user');
        }
        foodmanager::destroy($id);
        return redirect()->back()->with('success','Admin user deleted successfully.');
    }
}
