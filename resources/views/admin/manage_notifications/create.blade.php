@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST"  enctype="multipart/form-data" action="{{route('adminNotificationsStore')}}" id="userCreate">
                    @csrf	

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="title" maxlength="190" required />
                        @error('name')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					<div class="form-group">
                        <label for="notifytype">Notification type of users</label> <br/>                  
						<input type="radio" class="" id="notifytype_1" name="notifytype" value="P" > Paid User					
						<input type="radio" class="" id="notifytype_2" name="notifytype" value="A" checked="checked"> All User				
					</div>
					
				    <div class="form-group" >
                        <label for="description">Description</label>
						<textarea class="ckeditor form-control" name="description" id="description" placeholder="Description" maxlength="1000" >{{old('description')}}</textarea>
                        
                        @error('description')
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\AddAdminNotificationsRequest','#userCreate') !!}
<!-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>-->
<script type="text/javascript">
   /* $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });*/
	

</script>
@endsection
@endsection