@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST"  enctype="multipart/form-data" action="{{route('adminCourseVideosStore')}}" id="userCreate">
                    @csrf
                    <div class="form-group">
                        <label for="title">Course *</label>
                        <select class="form-control"  name="course" id="course">
                            <option value="">Select course</option>
                            @foreach($Coursesdata as $coursesval)
                            <option value="{{$coursesval->id}}" @if(old("course") == $coursesval->id) selected @endif>{{$coursesval->varTitle}}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>	
                    <div class="form-group">
                        <label for="title">Video Title *</label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="Video title" required />
                        @error('name')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					<div class="form-group" style="display:none">
                        <label for="videotype">Video Type *</label>
                        <br/>                   
						<input type="radio" class="" id="videotype_1" name="videotype" value="P" checked> Paid					
						<input type="radio" class="" id="videotype_2" name="videotype" value="F"> Free
					</div>
					
				    <div class="form-group" >
                        <label for="description">Description *</label>
						<textarea class="ckeditor form-control" name="description" id="description" maxlength="500" placeholder="Description
" >{{old('description')}}</textarea>
                        
                        @error('description')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group" >
						<label for="video">Video *</label>
						<input type="file" class="form-control" id="coursevideo" name="coursevideo" placeholder="video" />
						
						
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\AddAdminCourseVideosRequest','#userCreate') !!}
<!-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>-->
<script type="text/javascript">
   /* $(document).ready(function () {
        $('.ckeditor').ckeditor();		
    });*/	
</script>
@endsection
@endsection