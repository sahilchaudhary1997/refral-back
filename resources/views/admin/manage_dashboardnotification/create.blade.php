@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST"  enctype="multipart/form-data" action="{{route('adminDashboardNotificationStore')}}" id="userCreate">
                    @csrf	
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="title" required />
                        @error('name')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					<div class="form-group">
                        <label for="notifytype">Notification Type</label>                    
						<input type="radio" class="" id="notifytype_1" name="notifytype" value="T"> Text					
						<input type="radio" class="" id="notifytype_2" name="notifytype" value="V"> Video					
					</div>
					
				    <div class="form-group" id="textsection">
                        <label for="description">Description</label>
						<textarea class="ckeditor form-control" name="description" id="description" placeholder="Description
" >{{old('description')}}</textarea>
                        
                        @error('description')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group" id="videosection" style="display:none">
						<label for="video">Video</label>
						<input type="file" class="form-control" id="notifyvideo" name="notifyvideo" placeholder="video" />
						
						
						@error('video')
							<span class="invalid-feedback" role="alert" style="display:block;">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					
                    <button type="submit" class="btn btn-gradient-primary mr-2">Add</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\Admin\AddAdminDashboardNotificationRequest','#userCreate') !!}
<!-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>-->
<script type="text/javascript">
   /* $(document).ready(function () {
        $('.ckeditor').ckeditor();
		
		
    });*/
	
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