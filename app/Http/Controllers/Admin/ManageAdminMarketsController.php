<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
// use App\color;
//use App\Markets;
use App\Models\Markets;
use App\category;
use App\Http\Requests\Admin\AddAdminMarketsRequest;
use App\Http\Requests\Admin\UpdateAdminMarketsRequest;
use Config;

class ManageAdminMarketsController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Markets']];

    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = Markets::where(function($q)use($filter) {
                            if (!empty($filter['search'])) {
                                $q->where('name', 'LIKE', '%' . $filter['search'] . '%');
                            }
                        })
                        ->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_markets.list', compact('breadcum', 'users', 'filter'));
    }

    public function create() {
        $breadcum = $this->breadcum;
         $categorydata = category::getList();
        return view('admin.manage_markets.create', compact('breadcum','categorydata'));
    }

    public function store(AddAdminMarketsRequest $request) {
        $all = $request->all();
        $all['is_active'] = 1;
        $role = Markets::create($all);
        return redirect()->route('adminMarkets')->with('success', 'New admin markets added successfully.');
    }

    public function edit($id) {
        $user = Markets::find($id);
        $breadcum = $this->breadcum;
         $categorydata = category::getList();
        return view('admin.manage_markets.update', compact('breadcum', 'user','categorydata'));
    }

    public function update(UpdateAdminMarketsRequest $request) {
        $all = $request->all();
        Markets::find($all['uid'])->update($all);
        return redirect()->route('adminMarkets')->with('success', 'Markets updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = Markets::find($request->id);
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    Markets::find($record->id)->update(['is_active' => 0]);
                } else {
                    Markets::find($record->id)->update(['is_active' => 1]);
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
        Markets::destroy($id);
        return redirect()->back()->with('success', 'Admin markets deleted successfully.');
    }

}
