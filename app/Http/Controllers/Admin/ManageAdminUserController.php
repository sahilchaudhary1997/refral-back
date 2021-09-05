<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\admins;
use App\Http\Requests\Admin\AddAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use Config;
use Auth;

class ManageAdminUserController extends SystemAdminController
{
    var $breadcum = ['icon'=>'mdi mdi-account-multiple','breadcum'=>['Manage Admin Users']];
    var $guard = 'admin';
    
    public function __construct()
    {
        parent::__construct();
    }
    public function index(Request $request)
    {
        // echo Auth::guard($this->guard)->user()->id;exit;
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = admins::where(function($q)use($filter){
                    if(!empty($filter['search'])){
                        $q->where('name','LIKE','%'.$filter['search'].'%')
                        ->orwhere('email','LIKE',$filter['search']);
                    }
                })
                ->orderBy('created_at','desc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_users.list',compact('breadcum','users','filter'));
    }
    public function create()
    {
        $breadcum = $this->breadcum;
        $roles = roles::getList();
        return view('admin.manage_users.create',compact('breadcum','roles'));
    }
    public function store(AddAdminUserRequest $request)
    {
        $all = $request->all();
        $all['role_id'] = base64_decode($all['role_id']);
        $all['password'] = bcrypt($all['password']);
        $all['is_active'] = 1;
        $role = admins::create($all);
        return redirect()->route('adminUserManager')->with('success','New admin user added successfully.');
    }
    public function edit($id)
    {
        $user = admins::find($id);
        $roles = roles::getList();
        $breadcum = $this->breadcum;
        return view('admin.manage_users.update',compact('breadcum','roles','user'));
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
        admins::find($all['uid'])->update($all);
        return redirect()->route('adminUserManager')->with('success','User updated successfully.');
    }
    public function publish(Request $request)
    {
        try{
            $record = admins::find($request->id);
            if(!empty($record)){
                if($record->is_active == 1){
                    admins::find($record->id)->update(['is_active'=>0]);
                }else{
                    admins::find($record->id)->update(['is_active'=>1]);
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
        admins::destroy($id);
        return redirect()->back()->with('success','Admin user deleted successfully.');
    }
     
    public function resetpassword($id){
        echo "asfdfdf_".$id;exit;
    }
}
