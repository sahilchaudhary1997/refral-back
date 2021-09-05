@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{route('adminCoursesUpdate')}}" id="userUpdate">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" class="form-control" name="title" value="{{$user->varTitle}}" placeholder="title" required />
                        @error('title')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="moduletype">Module</label>                    
						@foreach($moduletypes as $modulekey => $moduleval)
						<input type="radio" class="" id="moduletype_{{$moduleval->id}}" @if(old('title',$user->moduleTypes) == $moduleval->id ) checked  @endif  name="moduletype" value="{{$moduleval->id}}" />{{$moduleval->name}}					
                        @endforeach
                    </div>
					
					<div class="form-group blackcolor">
                        <label for="leveltype">Level *</label>                    
						<select class="form-control blackcolor" name="leveltype" id="leveltype">
                            <option value="">Select Level</option>
                            @foreach($leveltypes as $levelkey => $levelval)
                            
                            <option value="{{$levelval->id}}" @if(old('leveltype',$user->level) == $levelval->id ) selected  @endif  >{{$levelval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group blackcolor">
                        <label for="markets">Markets *</label>                    
						<select class="form-control blackcolor" name="markets" id="markets">
                            <option value="">Select Market</option>
                            @foreach($markets as $marketkey => $marketval)                            
                            <option value="{{$marketval->id}}" @if(old('markets',$user->market) == $marketval->id ) selected  @endif>{{$marketval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group blackcolor">
                        <label for="Category">Category</label>
						@php $categoryarr = explode(',',$user->categories); @endphp						
						<select class="form-control blackcolor" name="category[]" id="category" multiple="multiple">
                            <option value="">Select Category</option>
                            @foreach($categorydata as $categorykey => $categoryval)                            
                            <option value="{{$categoryval->id}}" @if(in_array($categoryval->id,$categoryarr)) selected  @endif >{{$categoryval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group">
                        <label for="indiafees">India Fees(Rs) *</label>
                        <input type="text" class="form-control" name="indiafees" id="indiafees" value="{{old('indiafees',$user->chrIndiaFees)}}" placeholder="India Fees" required />
                        @error('indiafees')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="worldfees">World Fees($) *</label>
                        <input type="text" class="form-control" name="worldfees" id="worldfees" value="{{old('worldfees',$user->chrWorldFees)}}" placeholder="World Fees" required />
                        @error('worldfees')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="courseduration">Course Duration in days *</label>
                        <input type="text" class="form-control" name="courseduration" id="courseduration" value="{{old('courseduration',$user->courseDuration)}}" placeholder="Course Duration in days" required />
                        @error('courseduration')
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
					
					<div class="form-group">
						<label for="photo">Photo</label>
						<input type="file" class="form-control" id="coursephoto" name="coursephoto" placeholder="Photo" />
						
						@if($user->coursePhoto!="")
						<img src="{{ResizeImageUsingImageName($user->coursePhoto,'course',100,100)}}" class="mt-10" />
						@endif
						@error('photo')
							<span class="invalid-feedback" role="alert" style="display:block;">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>

                    <div class="row" id="offlinecourse" @if($user->market !='11') style="display:none" @endif >
                        <div class="form-group col-md-2">
                            <label for="offlinefees">Offline Fees(Rs)</label>
                            <input type="text" class="form-control" name="offlinefees" id="offlinefees" value="{{old('offlinefees',$user->offlineCourseFee)}}" placeholder="Offline Course Fees"  />
                            
                        </div>
                        <div class="form-group col-md-10">                            
                            <label for="registerlink">Offline Course Link</label>
                            <input type="text" class="form-control" name="registerlink" id="registerlink" value="{{old('registerlink',$user->offlineRegisterLink)}}" placeholder="Course Register link"  />
                        
                        </div>
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAdminCoursesRequest','#userUpdate') !!} 
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
    $("#markets").change(function(){
        var marketid = $(this).val();        
        
        if(marketid=="11"){
            $("#offlinecourse").show();
        }else{
            // $("#offlinefees").val('');
            // $("#registerlink").val('');
            $("#offlinecourse").hide();
        }
    });
</script>

@endsection
@endsection