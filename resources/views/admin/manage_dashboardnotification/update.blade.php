@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{route('adminDashboardNotificationUpdate')}}" id="userUpdate">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{$user->title}}" placeholder="title" required />
                        @error('title')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="notifytype">Notification Type</label>                    
						<input type="radio" class="" id="notifytype_1" @if(old('title',$user->notifytype) == 'T' ) checked  @endif name="notifytype" value="T"> Text					
						<input type="radio" class="" id="notifytype_2" name="notifytype" @if(old('title',$user->notifytype) == 'V' ) checked  @endif value="V"> Video					
					</div>
					
					
					<div class="form-group" id="textsection" @if(old('title',$user->notifytype) == 'V' ) style="display:none"  @endif>
                        <label for="description">Description</label>
						<textarea class="ckeditor form-control" name="description" id="description" placeholder="Description
" >{{old('description',$user->description)}}</textarea>
                        
                        @error('description')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group" id="videosection" @if(old('title',$user->notifytype) == 'T' ) style="display:none"  @endif>
						<label for="notifyvideo">Video</label>
						<input type="file" class="form-control" id="notifyvideo" name="notifyvideo" placeholder="Video" />
						
						
						@error('notifyvideo')
							<span class="invalid-feedback" role="alert" style="display:block;">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
                    <input type="hidden" name="uid" value="{{$user->id}}" />
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAdminDashboardNotificationRequest','#userUpdate') 
<script type="text/javascript">
$('[name=notifytype]').on('click', function(){
			var notiftypeval = this.value;
			if(notiftypeval!="" && notiftypeval=="V"){
				$("#videosection").show();
				$("#textsection").hide();
			}
			
			if(notiftypeval!="" && notiftypeval=="T"){
				$("#textsection").show();
				$("#videosection").hide();
			}
			
			// $('.text').toggle(this.value === 'Show');
		})
</script>
@endsection
@endsection