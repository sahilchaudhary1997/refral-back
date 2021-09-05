<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\admins;
use App\Models\User;
// use App\Http\Requests\Admin\AddAdminUserRequest;
// use App\Http\Requests\Admin\UpdateAdminUserRequest;
use Config;
use Auth;
use App\Models\Payments;
use App\Models\PaymentsHistory;

class ManageUserController extends SystemAdminController
{
    var $breadcum = ['icon'=>'mdi mdi-account-multiple','breadcum'=>['Manage Users']];
    // var $guard = 'admin';
    
    public function __construct()
    {
        parent::__construct();
    }
    public function index(Request $request)
    {
		$filter = $request->all();
        $breadcum = $this->breadcum;
        $users = User::where(function($q)use($filter){
                    if(!empty($filter['search'])){
                        $q->where('name','LIKE','%'.$filter['search'].'%')
                        ->orwhere('email','LIKE',$filter['search']);
                    }
                })
                ->orderBy('created_at','desc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.users.list',compact('breadcum','users','filter'));
    }
    /*
	public function create()
    {
        $breadcum = $this->breadcum;
        $roles = roles::getList();
        return view('admin.users.create',compact('breadcum','roles'));
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
        return view('admin.users.update',compact('breadcum','roles','user'));
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
     
   // public function resetpassword($id){
     //   echo "asfdfdf_".$id;exit;
    //}
	*/
	public function paymenthistory($userid)
    {
		// $userpayments = PaymentsHistory::where('userid',$userid)->orderBy('created_at','desc')->get();

        $payments = Payments::select('payments.id','payments.orderid as orderId','payments.receipt','payments.total_amount','payments.discount_total','payments.grand_total','payments.discount','payments.currency','payments.created_at as createAt')->where('payment_status','S')->where('userid',$userid)->orderBy('payments.created_at', 'desc')->get();

        $paymentshistoryarr = array();
			foreach($payments as $paymentskey => $paymentsval){
				// $paymentshistoryarr[$paymentskey] =  $paymentsval;
				$paymentshistoryarr[$paymentskey]['id'] = $paymentsval['id'];
				$paymentshistoryarr[$paymentskey]['orderId'] = $paymentsval['orderId'];
				$paymentshistoryarr[$paymentskey]['receipt'] = $paymentsval['receipt'];
				$paymentshistoryarr[$paymentskey]['totalAmount'] = $paymentsval['total_amount'];
				$paymentshistoryarr[$paymentskey]['discountTotal'] = $paymentsval['discount_total'];
				$paymentshistoryarr[$paymentskey]['grandTotal'] = $paymentsval['grand_total'];
				$paymentshistoryarr[$paymentskey]['discount'] = $paymentsval['discount']; 
				$paymentshistoryarr[$paymentskey]['currency'] = $paymentsval['currency'];
				$paymentshistoryarr[$paymentskey]['createAt'] = $paymentsval['createAt'];

				$paymentshistory = PaymentsHistory::select('payments_history.total_amount','payments_history.discount_total','payments_history.grand_total','payments_history.discount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName','payments_history.course_duration','payments_history.levelname')	
				->join('courses', 'courses.id', '=', 'payments_history.courseid')
				->where('payments_history.userid', $userid)
				->where('payments_history.paymentid', $paymentsval['id'])
				->where('payments_history.payment_status', 'S')
				->orderBy('payments_history.created_at', 'desc')
				->get();
				
				$coursesarr = array();
				foreach($paymentshistory as $paymentkey => $paymentval){		
					$coursesarr[$paymentkey]['totalAmount'] = $paymentval['total_amount'];
					$coursesarr[$paymentkey]['discountTotal'] = $paymentval['discount_total'];
					$coursesarr[$paymentkey]['grandTotal'] = $paymentval['grand_total'];
					$coursesarr[$paymentkey]['discount'] = $paymentval['discount'];
					$coursesarr[$paymentkey]['currency'] = $paymentval['currency'];
					$coursesarr[$paymentkey]['courseTitle'] = $paymentval['courseTitle'];
					$coursesarr[$paymentkey]['moduleName'] = $paymentval['moduleName'];
					$coursesarr[$paymentkey]['levelName'] = $paymentval['levelname'];
					$coursesarr[$paymentkey]['courseDuration'] = $paymentval['course_duration'];
					$coursesarr[$paymentkey]['packageStartDate'] = $paymentval['packageStartDate'];
					$coursesarr[$paymentkey]['packageEndDate'] = $paymentval['packageEndDate'];
					$coursesarr[$paymentkey]['createAt'] = $paymentval['createAt'];
					// $coursesarr['photoName'] = $paymentval['photoName'];
					// $coursesarr['imageName'] = $paymentval['imageName'];

					$fileurl = "";
					if ($paymentval['imageName']!="" && file_exists(public_path('uploads/'.$paymentval['imageName']))){
						$coursesarr[$paymentkey]['PhotoName'] = $paymentval['PhotoName'];
						
						$fileurl = ResizeImageUsingImageName($paymentval['imageName'],'course',300,200);
						
						$coursesarr[$paymentkey]['imageUrl'] = $fileurl;
					}
				}				
				$paymentshistoryarr[$paymentskey]['coursesPayments'] = $coursesarr;
			}
        // echo "<pre>";
        // print_r($paymentshistoryarr);
        // exit;
        $breadcum = $this->breadcum;
        return view('admin.users.paymenthistory',compact('breadcum','paymentshistoryarr'));
    }
}
