@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{route('adminPagesUpdate')}}" id="userUpdate">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{$user->varTitle}}" readonly placeholder="title" required />
                        @error('title')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="description">Description</label>
						<textarea class="ckeditor form-control" name="description" id="description" placeholder="Description
" >{{old('description',$user->txtDescription)}}</textarea>
                        
                        @error('description')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group" style="display:none">
						<label for="photo">Photo</label>
						<input type="file" class="form-control" id="pagePhoto" name="pagePhoto" placeholder="Photo" />
						
						@if($user->pagePhoto!="")
						<img src="{{ResizeImageUsingImageName($user->pagePhoto,'pages',100,100)}}" class="mt-10" />
						@endif
						@error('photo')
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAdminPagesRequest','#userCreate') !!}
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>

@endsection
@endsection