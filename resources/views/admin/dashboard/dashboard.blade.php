@extends('admin.layouts.app')
@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
.ui-widget.ui-widget-content{
	z-index: 9999;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
				<div class="clearfix"></div>			
                <div id="user_details"></div>
                <div class="clearfix"></div>
                <div id="user_model_details"></div>
				<div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function () {
	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
		}
	});
});
@if(!empty(Auth::guard('admin')->user()->id) && Auth::guard('admin')->user()->id == 1)
	setInterval(function(){
	  fetch_user();
	  update_chat_history_data();
	}, 15000);
@endif

 
$(document).ready(function(){
	
	fetch_user();
	update_chat_history_data();
	
	$(document).on('click', '.start_chat', function(){
	  var to_user_id = $(this).data('touserid');
	  var to_user_name = $(this).data('tousername');
	  make_chat_dialog_box(to_user_id, to_user_name);
	  $("#user_dialog_"+to_user_id).dialog({
		autoOpen:false,
		width:400
	  });
	  $('#user_dialog_'+to_user_id).dialog('open');
	  fetch_user_chat_history(to_user_id);
	});
	
	$(document).on('click', '.send_chat', function(){
		
	  var to_user_id = $(this).attr('id');
	  var chat_message = $('#chat_message_'+to_user_id).val();
	  $.ajax({	 
	   url:'{{url("systemadmin/insertchatusers")}}',
	   method:"POST",
	   data:{to_user_id:to_user_id, chat_message:chat_message},
	   success:function(data)
	   {
		$('#chat_message_'+to_user_id).val('');
		$('#chat_history_'+to_user_id).html(data);
	   }
	  })
	  
	});
	
});

function fetch_user(){
$.ajax({
   url:'{{url("systemadmin/fetchmobileusers")}}',
   method:"POST",
   data: {id:'dashboard'},
   success:function(data){
    $('#user_details').html(data);
   }
  })
}

function make_chat_dialog_box(to_user_id, to_user_name)
{
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
  modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
  modal_content += '</div><div class="form-group" align="right">';
  modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
  $('#user_model_details').html(modal_content);
}

function update_chat_history_data()
{
	$('.chat_history').each(function(){
		var to_user_id = $(this).data('touserid');		
		fetch_user_chat_history(to_user_id);
	});
}

function fetch_user_chat_history(to_user_id)
{
	$.ajax({		
		url:'{{url("systemadmin/fetchuserchathistory")}}',
		method:"POST",
		data:{to_user_id:to_user_id},
		success:function(data){
			$('#chat_history_'+to_user_id).html(data);
		}
	})
}
</script>
@endsection
