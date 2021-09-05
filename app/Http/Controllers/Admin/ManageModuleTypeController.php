<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\Models\ModuleType;
use App\Http\Requests\Admin\AddModuleTypeRequest;
use App\Http\Requests\Admin\UpdateModuleTypeRequest;
use Config;

class ManageModuleTypeController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Module Type']];

    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = ModuleType::where(function($q)use($filter) {
                            if (!empty($filter['search'])) {
                                $q->where('name', 'LIKE', '%' . $filter['search'] . '%');
                            }
                        })
                        ->orderBy('created_at', 'desc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_moduletype.list', compact('breadcum', 'users', 'filter'));
    }

    public function create() {
        $breadcum = $this->breadcum;
        return view('admin.manage_moduletype.create', compact('breadcum'));
    }

    public function store(AddModuleTypeRequest $request) {
        $all = $request->all();
        $all['is_active'] = 1;
        $role = ModuleType::create($all);
        return redirect()->route('adminModuleType')->with('success', 'New admin module type added successfully.');
    }

    public function edit($id) {
        $user = ModuleType::find($id);
        $breadcum = $this->breadcum;
        return view('admin.manage_moduletype.update', compact('breadcum', 'user'));
    }

    public function update(UpdateModuleTypeRequest $request) {
        $all = $request->all();
        ModuleType::find($all['uid'])->update($all);
        return redirect()->route('adminModuleType')->with('success', 'Module type updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = ModuleType::find($request->id);
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    ModuleType::find($record->id)->update(['is_active' => 0]);
                } else {
                    ModuleType::find($record->id)->update(['is_active' => 1]);
                }
                return 'success';
            }
            return 'Record not found';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
//        if($id == 1 || $id == 2){
//            return redirect()->back()->with('error','You can not delete admin location city');
//        }
        ModuleType::destroy($id);
        return redirect()->back()->with('success', 'Admin module type deleted successfully.');
    }

}
