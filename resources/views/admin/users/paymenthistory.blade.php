@extends('admin.layouts.app')
@section('content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
	<div class="card">
	  <div class="card-body"> 
			<button type="reset" onclick="location.href='{{route('usersManager')}}'" title="Reset Filter" class="btn-sm btn-gradient-danger mb-2 mr-2">Back to Users</button>
			
			@if(!empty($paymentshistoryarr))			
			<div class="clearfix"></div>
			<div class="table-horizontal-scroll">		
				<table class="table table-bordered">
				  <thead>
					<tr>
					  <th> Order ID </th>	
					  <th> Total Amont</th>						  		 
					  <th> Paid Amount </th>
					  <th> Order Date</th>
					</tr>
				  </thead>
				  <tbody>	
				  	<!-- <tr>
					  <th> Order ID </th>	
					  <th> Purchase Course Name</th>					 
					  <th> Module </th>
					  <th> Level </th>
					  <th> Amount </th>
					  <th> Package Details </th>
					  <th> Order Date</th>
					</tr> -->
					@php $totalorderamout = 0; @endphp
					@foreach($paymentshistoryarr as $userpaymentdetail)
						@php // $totalorderamout += (int) $userpaymentdetail->amount; @endphp
						<tr class="parent" id="row_{{$userpaymentdetail['id']}}" title="Click to expand/collapse" style="cursor: pointer;" > 
							<td>{{$userpaymentdetail['orderId']}}</td>
							<td>{{number_format($userpaymentdetail['totalAmount'], 2)}}</td>							
							<td>{{number_format($userpaymentdetail['grandTotal'], 2)}}</td>
							<td>{{date('d F, Y',strtotime($userpaymentdetail['createAt']))}} </td>
						</tr>

						
					@endforeach					
				  </tbody>
				</table>
			</div>
			<div class="mt-2">
				<div class="float-right">
					
				</div>
				<div class="float-left">
					@include('admin.layouts.show_records_per_page')
				</div>
			</div>
			@else
				<div class="alert alert-danger" role="alert">
				  No payment data found.
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
$(document).ready(function () {  
        debugger;  
        $('.hideTr').slideUp(600);  
     $('[data-toggle="toggle"]').click(function () {  
        if ($(this).parents().next(".hideTr").is(':visible')) {  
            $(this).parents().next('.hideTr').slideUp(600);  
            $(".plusminus" + $(this).children().children().attr("id")).text('+');  
           $(this).css('background-color', 'white');  
            }  
        else {  
            $(this).parents().next('.hideTr').slideDown(600);  
            $(".plusminus" + $(this).children().children().attr("id")).text('- ');  
           $(this).css('background-color', '#c1eaff ');    
        }  
    });  
    });   
</script>
@endsection