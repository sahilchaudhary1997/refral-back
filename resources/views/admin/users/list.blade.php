@extends('admin.layouts.app')
@section('content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
	<div class="card">
	  <div class="card-body"> 
	  @if(count($users) > 0)
		 <form class="form-inline float-right" action="{{route('usersManager')}}" method="GET">
		  <input type="text" value="{{isset($filter['search'])?$filter['search']:''}}" name="search" class="form-control mb-2 mr-sm-2" placeholder="Search" />
		  <button type="submit" title="Filter" class="btn-sm btn-gradient-primary mb-2 mr-2"><i class="mdi mdi-filter"></i></button>
		   <button type="reset" onclick="location.href='{{route('usersManager')}}'" title="Reset Filter" class="btn-sm btn-gradient-danger mb-2 mr-2"><i class="mdi mdi-refresh"></i></button>		   
		</form>
		<div class="clearfix"></div>
		<div class="table-horizontal-scroll">		
				<table class="table table-bordered">
				  <thead>
					<tr>					
					  <th> Name </th>
					  <th> Email </th>
					  <th> Phone </th>
					  <th> Account <br/>Verification </th>
					  <th> Payment Details </th>
					</tr>
				  </thead>
				  <tbody>					
					@foreach($users as $user)
					<tr> 
						<td> {{$user->name}} </td>
						<td> {{$user->email}} </td>
						<td> {{$user->phoneNumber}} </td>
						<td>
							@if($user->isVerified == 1)
								{{'Yes'}}
							@else
								{{'No'}}
							@endif
						</td>
						<td>
						
						<a href="{{route('usersPaymentHistory',$user->id)}}"><button type="button" title="View Payments History" class="btn-sm btn-gradient-success btn-fw"><i class="mdi mdi-view-headline"></i></button></a>
						
						
						{{--
						<a href="{{route('usersDelete',$user->id)}}" class="delete"><button type="button" title="Delete" class="btn-sm btn-gradient-danger btn-fw"><i class="mdi mdi-delete"></i></button></a>
					--}}
					
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
	$('body').on('click','.delete',function(e){
		e.preventDefault();
		var msg = "Once deleted, you will not be able to recover this user";
		deleteWarning(msg,$(this).attr('href'));
	});	
});
</script>
@endsection