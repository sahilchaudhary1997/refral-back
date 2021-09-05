@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST"  enctype="multipart/form-data" action="{{route('adminAdvisoryNotificationCreate')}}" id="userCreate">
                    @csrf	
                    <div class="form-group">
                        <label for="section">Section</label>
                        <input type="text" class="form-control" name="section" value="{{old('section')}}" placeholder="Section" required />
                        @error('section')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <!-- <label for="moduletype">Module</label>                     -->
						@foreach($moduletypes as $modulekey => $moduleval)
                        @php $displaynone= '' ;
                            if($moduleval->id==1){
                                $displaynone= ' display:none' ;
                            }
                        @endphp
						<span style=" {{$displaynone}}"><input type="radio" class=""  id="moduletype_{{$moduleval->id}}" @if($modulekey==1) checked @endif name="moduletype" value="{{$moduleval->id}}" />{{$moduleval->name}}</span>
                        @endforeach
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
					
					<!-- <div class="form-group">
                        <label for="Category">Category</label>                    
						<select class="form-control" name="category[]" id="category" multiple="multiple">
                            <option value="">Select Category</option>
                            @foreach($categorydata as $categorykey => $categoryval)                            
                            <option value="{{$categoryval->id}}">{{$categoryval->name}}</option>
                            @endforeach
                        </select>
                    </div> -->
					<div class="form-group" style="display:none" id="advisorycourse">
                        <label for="script">Advisory Courses</label>
                        <span id="advisorycourse_select">

                        </span>
                        @error('script')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

					<div class="form-group">
                        <label for="script">Script</label>
                        <input type="text" class="form-control" name="script" id="script" value="{{old('script')}}" placeholder="Script" required />
                        @error('script')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeaction">Trade Action</label>
						
						<input type="radio" class=""  id="tradeaction_1" checked name="tradeaction" value="1" />Buy
                        <input type="radio" class=""  id="tradeaction_2" name="tradeaction" value="2" />Sale    
                    </div>
                    
                    <div class="form-group">
                        <label for="expirydate">Expiry Date</label>
                        <input type="text" class="form-control" name="expirydate" id="expirydate" value="{{old('expirydate')}}" placeholder="Expiry Date" readonly />
                        @error('expirydate')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

					<div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" name="quantity" id="quantity" value="{{old('quantity')}}" placeholder="Quantity" />
                        @error('quantity')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
					
					<div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" id="price" value="{{old('price')}}" placeholder="Price" />
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
                        <input type="text" class="form-control" name="stoploss" id="stoploss" value="{{old('stoploss')}}" placeholder="Stop Loss" />
                        @error('stoploss')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control" name="target" id="target" value="{{old('target')}}" placeholder="Target" />
                        @error('target')
                        <span class="invalid-feedback" role="alert" style="display:block;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="timeline">TimeLine</label>
                        <input type="text" class="form-control" name="timeline" id="timeline" value="{{old('timeline')}}" placeholder="Timeline" />
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
                    <button type="submit" class="btn btn-gradient-primary mr-2">Send Notification</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{url('admin/assets/js/moment.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\AddAdminAdvisoryNotificationRequest','#userCreate') !!}

<script type="text/javascript">
    $(document).ready(function () {
        $( "#expirydate").datepicker();
    });
    $("#markets").change(function(){
        var marketid = $(this).val();
        // alert(marketid);
        $.ajax({
            url: '{{url("systemadmin/advisorynotification/advisorycourses")}}',
            type: "post",           
            data: { 
                
                id : $(this).val(),
                moduletype: $('input[name="moduletype"]:checked').val()
            },
            success: function(data){
                $("#advisorycourse").show();
                $("#advisorycourse_select").html(data);
                // advisorycourse
                // advisorycourse_select
            }
        });
    });

    $("#quantity,#price").change(function(){
       
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var totalvalue = 0;
        if(quantity!="" && price!=""){
            totalvalue = ((quantity) * (price));            
            $("#actionvalue").val(totalvalue.toFixed(2));
        }
    });

    $("#script,#quantity,#price,#expirydate,#stoploss,#target,#timeline").change(function(){

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
            var momentjsdate =  moment(expirydate, "MM/DD/YYYY").format("ll");
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
        if(stoploss!=""){
            notificationhtml += 'STOPLOSS - '+stoploss+'\n';
        }
        if(target!=""){
            notificationhtml += 'TARGET - '+target+'\n';
        }
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