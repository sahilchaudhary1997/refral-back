@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST"  enctype="multipart/form-data" action="{{route('adminCoursesStore')}}" id="userCreate">
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
                        <label for="moduletype">Module</label>                    
						@foreach($moduletypes as $modulekey => $moduleval)
						<input type="radio" class="" id="moduletype_{{$moduleval->id}}" @if($modulekey==0) checked @endif name="moduletype" value="{{$moduleval->id}}" />{{$moduleval->name}}					
                        @endforeach
                    </div>
					
					<div class="form-group">
                        <label for="leveltype">Level</label>                    
						<select class="form-control" name="leveltype" id="leveltype">
                            <option value="">Select Level</option>
                            @foreach($leveltypes as $levelkey => $levelval)
                            
                            <option value="{{$levelval->id}}">{{$levelval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group">
                        <label for="markets">Markets</label>                    
						<select class="form-control" name="markets" id="markets">
                            <option value="">Select Market</option>
                            @foreach($markets as $marketkey => $marketval)                            
                            <option value="{{$marketval->id}}">{{$marketval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group">
                        <label for="Category">Category</label>                    
						<select class="form-control" name="category[]" id="category" multiple="multiple">
                            <option value="">Select Category</option>
                            @foreach($categorydata as $categorykey => $categoryval)                            
                            <option value="{{$categoryval->id}}">{{$categoryval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group">
                        <label for="indiafees">India Fees(Rs)</label>
                        <input type="text" class="form-control" name="indiafees" id="indiafees" value="{{old('indiafees')}}" placeholder="India Fees" required />
                        @error('indiafees')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="worldfees">World Fees($)</label>
                        <input type="text" class="form-control" name="worldfees" id="worldfees" value="{{old('worldfees')}}" placeholder="World Fees" required />
                        @error('worldfees')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="courseduration">Course Duration in days</label>
                        <input type="text" class="form-control" name="courseduration" id="courseduration" value="{{old('courseduration')}}" placeholder="Course Duration in days" required />
                        @error('courseduration')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
				    <div class="form-group">
                        <label for="description">Description</label>
						<textarea class="ckeditor form-control" name="description" id="description" placeholder="Description
" >{{old('description')}}</textarea>
                        
                        @error('description')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
						<label for="photo">Photo</label>
						<input type="file" class="form-control" id="coursephoto" name="coursephoto" placeholder="Photo" />
						
						
						@error('photo')
							<span class="invalid-feedback" role="alert" style="display:block;">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<!--
					<div class="form-group">
                        <label for="name">Select Gender</label>
                        <select class="form-control" name="gender_id">
                            <option value="">Select Gender</option>
                            @foreach($moduletypes as $data)
                            
                            <option value="{{$data->id}}">{{ucwords($data->name)}}</option>
                            @endforeach
                        </select>
                    </div>
					-->
                    <button type="submit" class="btn btn-gradient-primary mr-2">Add</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\Admin\AddAdminCoursesRequest','#userCreate') !!}
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
@endsection
@endsection