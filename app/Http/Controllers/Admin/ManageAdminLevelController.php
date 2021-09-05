<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
// use App\level;
use App\Models\Level;
use App\Http\Requests\Admin\AddAdminLevelRequest;
use App\Http\Requests\Admin\UpdateAdminLevelRequest;
use Config;

class ManageAdminLevelController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Level']];

    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = Level::where(function($q)use($filter) {
                            if (!empty($filter['search'])) {
                                $q->where('name', 'LIKE', '%' . $filter['search'] . '%');
                            }
                        })
                        ->orderBy('created_at', 'desc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_level.list', compact('breadcum', 'users', 'filter'));
    }

    public function create() {
        $breadcum = $this->breadcum;
        return view('admin.manage_level.create', compact('breadcum'));
    }

    public function store(AddAdminLevelRequest $request) {
        $all = $request->all();
        $all['is_active'] = 1;
        $role = Level::create($all);
        return redirect()->route('adminLevel')->with('success', 'New admin level added successfully.');
    }

    public function edit($id) {
        $user = Level::find($id);
        $breadcum = $this->breadcum;
        return view('admin.manage_level.update', compact('breadcum', 'user'));
    }

    public function update(UpdateAdminLevelRequest $request) {
        $all = $request->all();
        Level::find($all['uid'])->update($all);
        return redirect()->route('adminLevel')->with('success', 'Level updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = Level::find($request->id);
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    Level::find($record->id)->update(['is_active' => 0]);
                } else {
                    Level::find($record->id)->update(['is_active' => 1]);
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
        Level::destroy($id);
        return redirect()->back()->with('success', 'Admin level deleted successfully.');
    }

}
