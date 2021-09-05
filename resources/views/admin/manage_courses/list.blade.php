@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!---->
                <form class="" action="{{route('adminCourses')}}" method="GET">
                
                <div class="row">
                    <div class="col-sm-2">                          
                        <div class="form-group">           
                            <select class="form-control blackcolor" name="modulelist" id="modulelist">
                                <option value="">Select Module</option>
                                @foreach($moduletypes as $moduletypeskey => $moduletypesval)                            
                                    <option value="{{$moduletypesval->id}}" @if(app('request')->input('modulelist') == $moduletypesval->id) selected @endif >{{$moduletypesval->name}}</option>
                                @endforeach
                            </select>
                        </div>                                              
                    </div>
                    <div class="col-sm-2">                          
                        <div class="form-group">           
                            <select class="form-control blackcolor" name="levellist" id="levellist">
                                <option value="">Select Level</option>
                                @foreach($leveltypes as $leveltypeskey => $leveltypesval)                            
                                    <option value="{{$leveltypesval->id}}" @if(app('request')->input('levellist') == $leveltypesval->id) selected @endif >{{$leveltypesval->name}}</option>
                                @endforeach
                            </select>
                        </div>                                              
                    </div>
                    <div class="col-sm-2">                          
                        <div class="form-group">           
                            <select class="form-control blackcolor" name="marketslist" id="marketslist">
                                <option value="">Select Market</option>
                                @foreach($markets as $marketkey => $marketval)                            
                                    <option value="{{$marketval->id}}" @if(app('request')->input('marketslist') == $marketval->id) selected @endif>{{$marketval->name}}</option>
                                @endforeach
                            </select>
                        </div>                                              
                    </div>
                    
                    <div class="col-sm-2">                        
                        <input type="text" value="{{isset($filter['search'])?$filter['search']:''}}" name="search" class="form-control mb-2 mr-sm-2" placeholder="Search" />
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" title="Filter" class="btn-sm btn-gradient-primary mb-2 mr-2"><i class="mdi mdi-magnify"></i></button>
                        <button type="reset" onclick="location.href ='{{route('adminCourses')}}'" title="Reset Filter" class="btn-sm btn-gradient-danger mb-2 mr-2"><i class="mdi mdi-refresh"></i></button>
                    
                        <button type="button" onclick="location.href ='{{route('adminCoursesCreate')}}'" title="Add Courses" class="btn-sm btn-gradient-primary mb-2">Add Courses</button>
                    </div>
                </div>              
                 
                    
                    
                   
                </form>
                <div class="clearfix"></div>
                <!---->

                <!-- <form class="form-inline float-right" action="{{route('adminCourses')}}" method="GET">
                    <input type="text" value="{{isset($filter['search'])?$filter['search']:''}}" name="search" class="form-control mb-2 mr-sm-2" placeholder="Search" />
                    <button type="submit" title="Filter" class="btn-sm btn-gradient-primary mb-2 mr-2"><i class="mdi mdi-filter"></i></button>
                    <button type="reset" onclick="location.href ='{{route('adminCourses')}}'" title="Reset Filter" class="btn-sm btn-gradient-danger mb-2 mr-2"><i class="mdi mdi-refresh"></i></button>
                    <button type="button" onclick="location.href ='{{route('adminCoursesCreate')}}'" title="Add Courses" class="btn-sm btn-gradient-primary mb-2">Add Courses</button>
                </form> -->
                <div class="clearfix"></div>
                @if(count($users) > 0)
                <div class="table-horizontal-scroll">		
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Date & Time </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>

                                <td> {{$user->varTitle}} </td>
                                <td> {{$user->created_at}} </td>

                                <td>
                                    @include('admin.layouts.publish_switch',['value'=>$user->id,'checked'=>$user->is_active])
                                </td>
                                <td>
                                    <a href="{{route('adminCoursesEdit',$user->id)}}"><button type="button" title="Update" class="btn-sm btn-gradient-success btn-fw"><i class="mdi mdi-border-color"></i></button></a>
                                    <a href="{{route('adminCoursesDelete',$user->id)}}" class="delete"><button type="button" title="Delete" class="btn-sm btn-gradient-danger btn-fw"><i class="mdi mdi-delete"></i></button></a>

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
$(document).ready(function(){
    $('body').on('click', '.delete', function(e){
        e.preventDefault();
        var msg = "Once deleted, you will not be able to recover this user";
        deleteWarning(msg, $(this).attr('href'));
    });
    $('body').on('click', '.switch_publish', function(e){
        var url = '{{route("adminCoursesPublish")}}';
        var value = $(this).val();
        publishStatus(value, url);
    });
});
// $("#marketslist").change(function(){
//     var marketid = $(this).val();        
//     $.ajax({
//         url: '{{route("getCoursesDetails")}}',
//         type: "post",           
//         data: {                
//             id : $(this).val(),          
//         },
//         success: function(data){
//             $("#courselist").show();
//             $("#courselist_select").html(data);                
//         }
//     });
// });

</script>
@endsection