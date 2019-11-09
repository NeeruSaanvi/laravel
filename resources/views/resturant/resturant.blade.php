@extends('layouts/resturant_layout')
@section('page_title')
Restaurant
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/resturant">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Restaurant</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Restaurant
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
 		<div class="row">
		 <div class="col-sm-12">
            <div class="portlet-body form">
                @if($action=='edit')
                    <form class="form-horizontal" method="post" action="/resturant/resturant/{{$resturant->username}}"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                   <div class="form-group">

                        <label class="col-md-12" for="description">Restaurant Name</span></label>
                        <div class="col-md-12">
                            <input name="rest_name" class="form-control validate[required]" value="{{old('rest_name')?e(old('rest_name')):$resturant->rest_name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Food Type</span></label>
                        <div class="col-md-12">
                                @foreach($foodtypes_all as $foodtype)
                                    <?php $foodtypes_rest=explode(',',$resturant->food_types);
                                        ?>
                                    <input name="food_types[]" type="checkbox" value="{{$foodtype->id}}" {{in_array($foodtype->id,$foodtypes_rest)?'checked':''}}>{{$foodtype->name}}
                                @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Working Hour</span></label>
                            <div class="col-md-6">
                            <input name="working_hours_from" class="form-control validate[required] timepicker timepicker-24 " value="{{old('working_hours_from')?e(old('working_hours_from')):$resturant->working_hours_from}}"  required>
                        </div>
                        <div class="col-md-6">
                            <input name="working_hours_to" class="form-control timepicker validate[required] timepicker-24" value="{{old('working_hours_to')?e(old('working_hours_to')):$resturant->working_hours_to}}"  required>
                        </div>
                   
                    </div>
                   <div class="form-group">
                        <label class="col-md-12" for="description">Contact No.</span></label>
                        <div class="col-md-12">
                            <input name="contact_no" class="form-control validate[required,custom[phone]]" value="{{old('contact_no')?e(old('contact_no')):$resturant->contact_no}}"  required>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-12" for="description">Website</span></label>
                        <div class="col-md-12">
                            <input name="website" class="form-control validate[required,custom[url]]" value="{{old('website')?e(old('website')):$resturant->website}}"  required>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-12" for="description">E-Mail</span></label>
                        <div class="col-md-12">
                            <input name="rest_email" type="email" class="form-control validate[required,custom[email]]" value="{{old('rest_email')?e(old('rest_email')):$resturant->rest_email}}" required>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-md-12" for="description">Address</span></label>
                        <div class="col-md-12">
                            <input name="building" class="form-control validate[required]" value="{{old('building')?e(old('building')):$resturant->building}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description"></span></label>
                        <div class="col-md-12">
                            <input name="street" class="form-control" value="{{old('street')?e(old('street')):$resturant->street}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">City</span></label>
                        <div class="col-md-12">
                            <input name="city" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('city')?e(old('city')):$resturant->city}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Pin Code</span></label>
                        <div class="col-md-12">
                            <input name="pincode" class="form-control validate[required,custom[zip]]" value="{{old('pincode')?e(old('pincode')):$resturant->pincode}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Country</span></label>
                        <div class="col-md-12">
                            <select name="country" class="form-control country validate[required]" id="country" required>
                                <option value="">Select</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{(old('country')?e(old('country')):$resturant->country)==$country->id?'selected':''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">State</span></label>
                        <div class="col-md-12">
                            <select name="state" id="state" class="form-control state validate[required]" required>
                                <option value="">Select</option>
                                @foreach($states as $state)
                                    <option value="{{$state->name}}" {{(old('state')?e(old('state')):$resturant->state)==$state->name?'selected':''}}>{{$state->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-12" for="description">Star Rating</span></label>
                        <div class="col-md-12">
                            <input type="number" min="0" max="5" class="form-control validate[required,custom[onlyNumberSp]]"  name="star_rating" value="{{old('star_rating')?e(old('star_rating')):$resturant->star_rating}}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Logo</span></label>
                        <div class="col-md-12">
                            <input type="file" class="form-control validate[checkFileType[jpg|jpeg|gif|JPG|png|PNG],checkFileSize[1]]"  title="Only PNG, JPG, GIF" name="image" {{$resturant->image==null?'required':''}} />
                            @if($resturant->image!=null)
                                <img src="{{ Config::get('images.user_images').$resturant->image }}" style="width:100px">

                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Cover Image</span></label>
                        <div class="col-md-12">
                            <input type="file" class="form-control validate[checkFileType[jpg|jpeg|gif|JPG|png|PNG],checkFileSize[1]]" title="Only PNG, JPG, GIF" name="coverimage" {{$resturant->coverimage==null?'required':''}} />
                            @if($resturant->coverimage!=null)
                                <img src="{{ Config::get('images.user_images').$resturant->coverimage }}" style="width:200px">

                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">More Info</span></label>
                        <div class="col-md-12">
                            <textarea name="more_info" class="form-control">{{old('more_info')?e(old('more_info')):$resturant->more_info}}</textarea>
                        </div>
                    </div>
                    
                    <hr>
                  
                    <h1 class="page-title"> Contact Person Details
                        </h1>
  
                    <div class="form-group">
                        <label class="col-md-12" for="description">First Name</span></label>
                        <div class="col-md-12">
                            <input name="name" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('name')?e(old('name')):$resturant->name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Last Name</span></label>
                        <div class="col-md-12">
                            <input name="last_name" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('last_name')?e(old('last_name')):$resturant->last_name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Email</span></label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control validate[required,custom[email]]" value="{{old('email')?e(old('email')):$resturant->email}}"  readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Phone</span></label>
                        <div class="col-md-12">
                            <input name="phone" class="form-control validate[required,custom[phone]]" value="{{old('phone')?e(old('phone')):$resturant->phone}}"  required>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 row">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>    
                @endif
                
            </div>
        </div>
	</div>
    <br>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-globe"></i>Restaurant</div>
        </div>

        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>Food Type</th>
                    <th>E-Mail</th>
                    <th>Phone</th>
                    <th></th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($resturant_all as $rest)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $rest->rest_name }}</td>
                    <td>{{ $rest->city }}</td>
                    <td>{{ $rest->food_name }}</td>
                    <td>{{ $rest->email }}</td>
                    <td>{{ $rest->contact_no }}</td>
                    <td>
                        <a href="/resturant/resturant/edit" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                  </tr>
                    @endforeach
                    @if($i==0)
                   <tr>
                    <td colspan="6" align="center">No Resturnat Found</td>
                    </tr>
                        
                    @endif
                </tbody>
              </table>
         </div> 
    </div>
@stop
@section('footer')

<script type="text/javascript">
    $('body').on('change', 'select.country', function() {
      var select=$(this).parent().parent().next('div').find('select.state');
      $.get("/resturant/ajaxstates?country="+$(this).val(), function(data){
            // Display the returned data in browser
            select.html(data);
      });
    });
 
</script>
@stop