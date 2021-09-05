@extends('admin.layouts.app')
@section('content')
<div class="alert alert-success alert-dismissible fade show" id="statusupdatemsg" role="alert" style="display:none;">
</div>
<div class="container-fluid bg-3">  
    <form class="" action="{{route('advisorycoursesreportgenerate')}}" method="POST" id="userlist">   
    @csrf 
        <div class="row" style="background:white;padding:20px 0px 10px 0px;">
            
            <div class="col-sm-2">                
                <div class="form-group">           
                    <select class="form-control blackcolor" name="markets" id="markets">
                        <option value="">Select Market</option>
                        @foreach($markets as $marketkey => $marketval)                            
                        <option value="{{$marketval->id}}">{{$marketval->name}}</option>
                        @endforeach
                    </select>
                </div>                
            </div>
            <div class="col-sm-3">               
                <div class="form-group" style="display:none" id="advisorycourse">            
                    <span id="advisorycourse_select"></span>
                    @error('script')
                    <span class="invalid-feedback" role="alert" style="display:block;">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>                   
            </div>
            <div class="col-sm-2"> 
                <div class="row">
                    <div class="col-12">  
                        <div class="form-group" style="display:none" id="fromdateparent">
                            <!-- <label for="fromdate">From Date</label> -->
                            <input type="text" class="form-control" name="fromdate" id="fromdate" value="{{old('fromdate')}}" placeholder="From Date" readonly />
                            @error('fromdate')
                            <span class="invalid-feedback" role="alert" style="display:block;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">  
                        <div class="form-group"  style="display:none" id="todateparent">
                            <!-- <label for="todate">To Date</label> -->
                            <input type="text" class="form-control" name="todate" id="todate" value="{{old('todate')}}" placeholder="To Date" readonly />
                            @error('todate')
                            <span class="invalid-feedback" role="alert" style="display:block;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>               
            </div>
            <div class="col-sm-3"> 
                <div class="row" id="reporttypeparent" style="display:none">  
                    <div class="col-12">
                        <div class="form-group" >  
                            <input type="radio" name="reporttype" id="reporttype_1" value="1" >  Send Report to Users<br/><br/>
                        <!-- </div>
                    </div> -->
                <!-- </div>
                <div class="row">   -->
                    <!-- <div class="col-12"> 
                        <div class="form-group" >   -->
                            <input type="radio" name="reporttype" id="reporttype_2" value="2" checked="checked" > Download Reports
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"> 
                <button type="submit" title="Filter" class="btn-sm btn-gradient-primary">Report Generate</button>
            </div>
        </div>
        
    </form>
</div>
<div class="clearfix"></div>
<div class="row"><br/> </div>

<div class="row">    
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="" action="{{route('adminAdvisoryNotification')}}" method="GET">
                <div class="row form-inline float-right">
                    <div class="col-sm-12">
                        <button type="button" onclick="location.href ='{{route('adminAdvisoryNotificationCreate')}}'" title="Send Advisory Notification" class="btn-sm btn-gradient-primary mb-2">Send Advisory Notification</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-sm-2">                          
                        <div class="form-group">           
                            <select class="form-control blackcolor" name="marketslist" id="marketslist">
                                <option value="">Select Market</option>
                                @foreach($markets as $marketkey => $marketval)                            
                                <option value="{{$marketval->id}}">{{$marketval->name}}</option>
                                @endforeach
                            </select>
                        </div>                                              
                    </div>
                    <div class="col-sm-2">                        
                        <div class="form-group" style="display:none" id="advisorycourselist">            
                            <span id="advisorycourselist_select"></span>
                            @error('script')
                            <span class="invalid-feedback" role="alert" style="display:block;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4"> 
                        <div class="row">
                            <div class="col-6">  
                                <div class="form-group" >
                                    <!-- <label for="fromdate">From Date</label> -->
                                    <input type="text" class="form-control" name="fromdatelist" id="fromdatelist" value="{{old('fromdate')}}" placeholder="From Date" readonly />
                                    @error('fromdatelist')
                                    <span class="invalid-feedback" role="alert" style="display:block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">  
                                <div class="form-group" >
                                    <!-- <label for="todate">To Date</label> -->
                                    <input type="text" class="form-control" name="todatelist" id="todatelist" value="{{old('todate')}}" placeholder="To Date" readonly />
                                    @error('todatelist')
                                    <span class="invalid-feedback" role="alert" style="display:block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <div class="col-sm-2">
                        <input type="text" value="{{isset($filter['search'])?$filter['search']:''}}" name="search" class="form-control mb-2 mr-sm-2" placeholder="Search" />
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" title="Filter" class="btn-sm btn-gradient-primary mb-2 mr-2"><i class="mdi mdi-magnify"></i></button>
                        <button type="reset" onclick="location.href ='{{route('adminAdvisoryNotification')}}'" title="Reset Filter" class="btn-sm btn-gradient-danger mb-2 mr-2"><i class="mdi mdi-refresh"></i></button>
                    </div>
                </div>              
                 
                    
                    
                   
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
                                    <option value="2" @if($user->status=='3') selected @endif >Success</option>
                                </select>
                                @endif    
                                  
                                   
                                @if($user->status=="1")
                                    <span class="btn-sm btn-gradient-success btn-fw">{{'Closed'}}</span>
                                @endif
                                @if($user->status=="2")
                                    <span class="btn-sm btn-gradient-success btn-fw">{{'Fail'}}</span>
                                @endif
                                @if($user->status=="3")
                                    <span class="btn-sm btn-gradient-success btn-fw">{{'Success'}}</span>
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

@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\ListAdminAdvisoryNotificationRequest','#userlist') !!}

<script>
    $(document).ready(function () {
        $( "#fromdate,#fromdatelist").datepicker();
        $( "#todate,#todatelist").datepicker();
    });
   
    $("#markets").change(function(){
        var marketid = $(this).val();        
        $.ajax({
            url: '{{url("systemadmin/advisorynotification/advisorycourses")}}',
            type: "post",           
            data: {                
                id : $(this).val(),
                moduletype: '2'
            },
            success: function(data){
                $("#advisorycourse").show();
                $("#advisorycourse_select").html(data);                
            }
        });
    });

    $("#marketslist").change(function(){
        var marketid = $(this).val();        
        $.ajax({
            url: '{{url("systemadmin/advisorynotification/advisorycourses")}}',
            type: "post",           
            data: {                
                id : $(this).val(),
                moduletype: '2',
                hidefunction: '1'
            },
            success: function(data){
                $("#advisorycourselist").show();
                $("#advisorycourselist_select").html(data);                
            }
        });
    });

    function getreportsdates(courseid){
        var marketid =  $('#markets').find(":selected").val();
      
        $.ajax({
            url: '{{url("systemadmin/advisorynotification/getadvisoryreportdate")}}',
            type: "post",           
            data: {                     
                courseid : courseid,
                moduletype: '2',
                markets:marketid
            },
            success: function(data){
                if(data.todate!=""){
                    $("#fromdate").val(data.todate);
                    $('#fromdate').datepicker({
                            "setDate": new Date(data.todate),
                            "autoclose": true
                    });
                }
                $("#fromdateparent").show();
                $("#todateparent").show();
                $("#reporttypeparent").show();        
            }
        });
    }

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