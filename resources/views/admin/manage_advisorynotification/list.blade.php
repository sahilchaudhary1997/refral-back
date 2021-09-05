@extends('admin.layouts.app')
@section('content')
<div class="alert alert-success alert-dismissible fade show" id="statusupdatemsg" role="alert" style="display:none;">
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body"> 
                <form class="form-inline float-right" action="{{route('adminAdvisoryNotification')}}" method="GET">
                    <input type="text" value="{{isset($filter['search'])?$filter['search']:''}}" name="search" class="form-control mb-2 mr-sm-2" placeholder="Search" />
                    <button type="submit" title="Filter" class="btn-sm btn-gradient-primary mb-2 mr-2"><i class="mdi mdi-filter"></i></button>
                    <button type="reset" onclick="location.href ='{{route('adminAdvisoryNotification')}}'" title="Reset Filter" class="btn-sm btn-gradient-danger mb-2 mr-2"><i class="mdi mdi-refresh"></i></button>
                    <button type="button" onclick="location.href ='{{route('adminAdvisoryNotificationCreate')}}'" title="Send Advisory Notification" class="btn-sm btn-gradient-primary mb-2">Send Advisory Notification</button>
                    <button type="button" onclick="location.href ='{{route('advisorynotification/export')}}'" title="Send Advisory Notification" class="btn-sm btn-gradient-primary mb-2">Download Excel xlsx</button>

                    
                </form>
                <div class="clearfix"></div>
                @if(count($users) > 0)
                <div class="table-horizontal-scroll">		
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> Section </th>
                                <th> Script </th>
                                <th> Action </th>
                                <th> Date & Time </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>

                                <td> {{$user->advisorySection}} </td>
                                <td> {{$user->script}} </td>
                                <td> 
                                    @if($user->action_trade=="1")
                                        {{'BUY'}}
                                    @endif
                                    @if($user->action_trade=="2")
                                        {{'SELL'}}
                                    @endif                                 
                                </td>
                                <td> {{$user->created_at}} </td>

                                <td>
                                @if($user->action_trade=="1" && $user->isBuySale==0)
                                    <a href="{{route('adminAdvisoryNotificationChangeAction',$user->id)}}"><button type="button" title="Update" class="btn-sm btn-gradient-danger btn-fw">SELL</button></a>
                                @endif
                                @if($user->action_trade=="2" && $user->isBuySale==0)
                                    <a href="{{route('adminAdvisoryNotificationChangeAction',$user->id)}}"><button type="button" title="Update" class="btn-sm btn-gradient-success btn-fw">BUY</button></a>
                                @endif
                                
                                @if($user->status=="0")
                                <select name="statusudt" id="statusudt" onchange="advisorynotificationstatus({{$user->id}},this.value);" >
                                    <option value="0" @if($user->status=='0') selected @endif >Opened</option>
                                    <option value="1" @if($user->status=='1') selected @endif >Closed</option>
                                    <option value="2" @if($user->status=='2') selected @endif >Fail</option>
                                </select>
                                @endif    
                                  
                                   
                                @if($user->status=="1")
                                    <span class="btn-sm btn-gradient-success btn-fw">{{'Closed'}}</span>
                                @endif
                                @if($user->status=="2")
                                    <span class="btn-sm btn-gradient-success btn-fw">{{'Fail'}}</span>
                                @endif


                                    <!-- @include('admin.layouts.publish_switch',['value'=>$user->id,'checked'=>$user->is_active]) -->
                                </td>
                                <td>
                                    <!-- <a href="{{route('adminCoursesEdit',$user->id)}}"><button type="button" title="Update" class="btn-sm btn-gradient-success btn-fw"><i class="mdi mdi-border-color"></i></button></a>
                                    <a href="{{route('adminCoursesDelete',$user->id)}}" class="delete"><button type="button" title="Delete" class="btn-sm btn-gradient-danger btn-fw"><i class="mdi mdi-delete"></i></button></a> -->

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <div class="float-right">
                        {{$users->appends($_REQUEST)->links()}}
                    </div>
                    <div class="float-left">
                        @include('admin.layouts.show_records_per_page')
                    </div>
                </div>
                @else
                <div class="alert alert-danger" role="alert">
                    No data found.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function advisorynotificationstatus(rowid,changval){
        
        $.ajax({
            url: '{{url("systemadmin/advisorynotification/publish")}}',
            type: "post",           
            data: {                
                id: rowid,
                changeid: changval
            },
            success: function(data){
                if(data=="success"){
                    $('#statusupdatemsg').show();
                    $('#statusupdatemsg').html('Status updated successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
                    setTimeout(function(){ location.reload(); }, 2000);
                    
                }                             
            }
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection