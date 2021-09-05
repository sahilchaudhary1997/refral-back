@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{route('adminAdvisoryNotificationChangeActionUpdate')}}" id="userUpdate">
                    @csrf
                    <div class="form-group">
                        <label for="section">Section</label>
                        <input type="text" class="form-control" name="section" value="{{$user->advisorySection}}" placeholder="Section" readonly />
                        @error('section')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
					<div class="form-group">
                        <!-- <label for="moduletype">Module</label>-->
						@foreach($moduletypes as $modulekey => $moduleval)
                        @php $displaynone= '' ;
                            if($moduleval->id==1){
                                $displaynone= ' display:none' ;
                            }
                        @endphp
                        <span style=" {{$displaynone}}">
						<input type="radio" class="" id="moduletype_{{$moduleval->id}}" @if(old('moduletype',$user->moduleId) == $moduleval->id ) checked  @endif  name="moduletype" value="{{$moduleval->id}}" />{{$moduleval->name}}	</span>				
                        @endforeach
                    </div>

					<div class="form-group">
                        <label for="markets">Markets</label>                    
						<select class="form-control" name="markets" id="markets">
                            <option value="">Select Market</option>
                            @foreach($markets as $marketkey => $marketval)                            
                            <option value="{{$marketval->id}}" @if(old('markets',$user->marketId) == $marketval->id ) selected @else disabled  @endif>{{$marketval->name}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="form-group">
                        <label for="advisorycourse">Advisory Courses</label>
						@php $categoryarr = explode(',',$user->categories); @endphp						
						<select class="form-control" name="advisorycourse" id="advisorycourse" >
                            <option value="">Select Category</option>
                            @foreach($coursesdata as $coursekey => $courseval)                        
                            <option value="{{$courseval->id}}"@if(old('markets',$user->courseId) == $courseval->id ) selected @else disabled   @endif >{{$courseval->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="script">Script</label>
                        <input type="text" class="form-control" name="script" id="script" value="{{old('script',$user->script)}}" placeholder="Script" readonly />
                        @error('script')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeaction">Trade Action</label>
						
						<span @if($user->action_trade == "1") style="display:none;" @endif > <input type="radio" class=""  id="tradeaction_1" name="tradeaction" value="1" @if($user->action_trade == "2") checked  @endif  />Buy</span>
                        <span @if($user->action_trade == "2") style="display:none;" @endif > <input type="radio" class=""  id="tradeaction_2" name="tradeaction" value="2" @if($user->action_trade == "1") checked  @endif   />Sale </span>
                    </div>
                    
                    <div class="form-group">
                        <label for="expirydate">Expiry Date</label>
                        <input type="text" class="form-control" name="expirydate" id="expirydate" value="{{old('script',$user->expiryDate)}}" placeholder="Expiry Date" readonly />
                        @error('expirydate')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

					<div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" name="quantity" id="quantity" value="{{old('script',$user->quantity)}}" placeholder="Quantity" />
                        @error('quantity')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" id="price" value="{{old('price',$user->price)}}" placeholder="Price" />
                        @error('price')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
                    

                    <div class="form-group">
                        <label for="actionvalue">Value</label>
                        <input type="text" class="form-control" name="actionvalue" id="actionvalue" value="{{old('actionvalue')}}" placeholder="Value" readonly />
                        @error('actionvalue')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="stoploss">Stoploss</label>
                        <input type="text" class="form-control" name="stoploss" id="stoploss" value="{{old('stoploss',$user->stoploss)}}" placeholder="Stop Loss" readonly />
                        @error('stoploss')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control" name="target" id="target" value="{{old('target',$user->target)}}" placeholder="Target" readonly />
                        @error('target')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="timeline">TimeLine</label>
                        <input type="text" class="form-control" name="timeline" id="timeline" value="{{old('timeline',$user->timeline)}}" placeholder="Timeline" readonly />
                        @error('timeline')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

				    <div class="form-group col-6">
                        <label for="description">Description</label>
						<textarea class="form-control" rows="10" cols="10" name="description" id="description" placeholder="Description
" readonly >{{old('description')}}</textarea>
                        
                        @error('description')
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAdminAdvisoryNotificationRequest','#userUpdate') !!}
<script src="{{url('admin/assets/js/moment.js')}}"></script>
<script type="text/javascript">
    $("#quantity,#price").change(function(){
       
       var quantity = $("#quantity").val();
       var price = $("#price").val();
       var totalvalue = 0;
       if(quantity!="" && price!=""){
           totalvalue = ((quantity) * (price));            
           $("#actionvalue").val(totalvalue.toFixed(2));
       }
   });

   $("#quantity,#price").change(function(){

        var script = $("#script").val();
        var expirydate = $("#expirydate").val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();        
        var stoploss = $("#stoploss").val();
        var target = $("#target").val();
        var timeline = $("#timeline").val();

        var tradeaction = $('input[name="tradeaction"]:checked').val();

        var notificationhtml = '';
        if(script!=""){
            notificationhtml += 'SCRIPT - '+script+'\n';
        }
        if(expirydate!=""){
            var momentjsdate =  moment(expirydate, "YYYY-MM-DD").format("ll");
            notificationhtml += 'EXPIRY - '+momentjsdate+'\n';
        }

        if(tradeaction!="" && quantity!=""){
            if(tradeaction=="1"){
                notificationhtml += 'BUY - '+quantity+'\n';
            }

            if(tradeaction=="2"){
                notificationhtml += 'SELL - '+quantity+'\n';
            }
        }
        if(price!=""){
            notificationhtml += 'PRICE - '+price+'\n';
        }
        // if(stoploss!=""){
        //     notificationhtml += 'STOPLOSS - '+stoploss+'\n';
        // }
        // if(target!=""){
        //     notificationhtml += 'TARGET - '+target+'\n';
        // }
        if(timeline!=""){
            notificationhtml += timeline+'\n';
        }

        notificationhtml += 'Market Mantra 99';
        $('#description').val(notificationhtml);
    });

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>

@endsection
@endsection