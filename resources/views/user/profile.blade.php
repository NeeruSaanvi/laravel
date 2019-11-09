@extends('layouts.user_layout')
@section('page_title')
Profile Setting
@stop 
@section('content')
@section('content')
  <!-- BEGIN PAGE BAR -->
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <a href="/user">Dashboard</a>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>Profile Settings</span>
          </li>
      </ul>
  </div>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Profile Settings
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
    <div class="row">
     <div class="col-sm-12">
            <div class="portlet-body form">
				<form action="/user/profile-update" class="form-horizontal" method="post">
					{{ csrf_field() }}
					<div class="form-group col-sm-6">
						<label class="col-md-12" for="description">First Name<span>*</span></label>
						<div class="col-md-12">
                        <input type="text" name="name" value="{{$userDetail[0]['name']}}" class="form-control validate[required,custom[onlyLetterSp]]" >
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="col-md-12" for="description">Last Name<span>*</span></label>
						<div class="col-md-12">
                        <input type="text" name="last_name" value="{{$userDetail[0]['last_name']}}" class="form-control validate[required,custom[onlyLetterSp]]" >
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="col-md-12" for="description">Email<span>*</span></label>
						<div class="col-md-12">
                        <input readonly type="email" name="email" value="{{$userDetail[0]['email']}}" class="form-control validate[required,custom[email]]" >
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="col-md-12" for="description">Phone Number<span>*</span></label>
						<div class="col-md-12">
                        <input type="text" name="phone" value="{{$userDetail[0]['phone']}}" class="form-control validate[required,custom[phone]]" >
						</div>
					</div>
					<div class="form-group col-sm-12">
				     <label class="col-md-12" for="description"><input type="checkbox" name="newsletter" value="1" @if($userDetail[0]['newsletter'] == 1) checked @endif>&nbsp;&nbsp;&nbsp;Subscribe to the Club Sip &amp; Savour newsletter here.<span></span></label>
					</div>
					<div class="form-group col-sm-6">
							<label class="col-md-12" for="description">Indicate Work Status Please <span></span></label>
							<div class="col-md-12">
                        	<select name="work_status" class="form-control" >
								<option @if($userDetail[0]['work_status'] == "") selected @endif value="">Select Work Status</option>
								<option @if($userDetail[0]['work_status'] == "Work Full Time") selected @endif value="Work Full Time">Work Full Time</option>
								<option @if($userDetail[0]['work_status'] == "Work Part Time") selected @endif value="Work Part Time">Work Part Time</option>
								<option @if($userDetail[0]['work_status'] == "Student Work Part Time") selected @endif value="Student Work Part Time">Student / Work Part Time</option>
								<option @if($userDetail[0]['work_status'] == "Student Full Time") selected @endif value="Student Full Time">Student Full Time</option>
								<option @if($userDetail[0]['work_status'] == "Homemaker") selected @endif value="Homemaker">Homemaker</option>
							</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="col-md-12" for="description">Type Of Work You Do<span></span></label>
							<div class="col-md-12">
                        	<select name="work_type" class="form-control" >
								<option @if($userDetail[0]['work_type'] == "") selected @endif value="">Select Work Type</option>
								<option @if($userDetail[0]['work_type'] == "CEO CFO") selected @endif value="CEO CFO">CEO / CFO</option>
								<option @if($userDetail[0]['work_type'] == "Medical") selected @endif value="Medical">Medical</option>
								<option @if($userDetail[0]['work_type'] == "Financial") selected @endif value="Financial">Financial</option>
								<option @if($userDetail[0]['work_type'] == "Legal") selected @endif value="Legal">Legal</option>
								<option @if($userDetail[0]['work_type'] == "Teaching") selected @endif value="Teaching">Teaching</option>
							</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="col-md-12" for="description">How Often Do You Dine Out<span></span></label>
							<div class="col-md-12">
                        	<select name="dine_out" class="form-control" >
								<option @if($userDetail[0]['dine_out'] == "") selected @endif value="">Select Work Type</option>
								<option @if($userDetail[0]['dine_out'] == "Once Per Week") selected @endif value="Once Per Week">Once Per Week</option>
								<option @if($userDetail[0]['dine_out'] == "Twice Per Week") selected @endif value="Twice Per Week">Twice Per Week</option>
								<option @if($userDetail[0]['dine_out'] == "Three Times Per Week") selected @endif value="Three Times Per Week">Three Times Per Week</option>
								<option @if($userDetail[0]['dine_out'] == "Four Times Per Week") selected @endif value="Four Times Per Week">Four Times Per Week</option>
								<option @if($userDetail[0]['dine_out'] == "Five Times Per Week") selected @endif value="Five Times Per Week">Five Times Per Week</option>
								<option @if($userDetail[0]['dine_out'] == "Daily") selected @endif value="Daily">Daily</option>
								<option @if($userDetail[0]['dine_out'] == "Multiple Times Per Day") selected @endif value="Multiple Times Per Day">Multiple Times Per Day</option>
							</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="col-md-12" for="description">What Part Of The App Will You Use Most</label>
							<div class="col-md-12">
                        	<select name="offer_like" class="form-control" >
								<option value="" @if($userDetail[0]['offer_like'] == "") selected @endif>Select Work Type</option>
								@foreach($allOffer as $offer)
								<option value="{{$offer['id']}}" @if($userDetail[0]['offer_like'] == $offer['id']) selected @endif>{{$offer['name']}}</option>
								@endforeach
								<option value="0"  @if($userDetail[0]['offer_like'] == 0) selected @endif>Will Use Both Equally</option>
							</select>
							</div>
							</div>
							<div class="form-group col-sm-6">
								<label class="col-md-12" for="description">Street Address<span>*</span></label>
							<div class="col-md-12">
                        		<input type="text" name="street_address"  class="form-control validate[required]"  value="{{$userDetail[0]['building']}}">
							</div>
							</div>
							<div class="form-group col-sm-6">
							<label class="col-md-12" for="description">Apt, suite, etc. (optional)<span></span></label>
							<div class="col-md-12">
                        	<input type="text" name="apt_suite" class="form-control"  value="{{$userDetail[0]['street']}}">
							</div></div>
							<div class="form-group col-sm-6">
										<label class="col-md-12" for="description">City<span>*</span></label>
							<div class="col-md-12">
                        	<input type="text" name="city" class="form-control validate[required,custom[onlyLetterSp]]"  value="{{$userDetail[0]['city']}}">
							</div>		
							</div>
							<div class="form-group col-sm-6">
								<label class="col-md-12" for="description">Zip/Postal Code<span>*</span></label>
								<div class="col-md-12">
                        		<input type="text" name="zip_code" class="form-control validate[required,custom[zip]]"  value="{{$userDetail[0]['pincode']}}">
                        		</div>
							</div>
						
							<div class="form-group col-sm-6">
							     <label class="col-md-12" for="description">Country<span>*</span></label>
								<div class="col-md-12">
                        
								<select name="country" class="country form-control validate[required]" >
									<option @if($userDetail[0]['country'] == "") selected @endif value="">Select Country</option>
									
									@foreach($countries as $country)
									<option @if($userDetail[0]['country'] == $country->id) selected @endif value="{{$country->id}}">{{$country->name}}</option>
									@endforeach
								</select>
								</div>
							</div>
							<div class="form-group col-sm-6">
							 <label class="col-md-12" for="description">State<span>*</span></label>
								<div class="col-md-12">
                        		<select name="state" class="state form-control validate[required]">
									<option @if($userDetail[0]['state'] == "") selected @endif value="">Select State</option>
									
									@foreach($statess as $state)
									<option @if($userDetail[0]['state'] == $state->name) selected @endif value="{{$state->name}}">{{$state->name}}</option>
									@endforeach
								</select>
								</div>
							</div>
						
                    
                    <div class="col-sm-12">
                        <button type="submit" class="btn blue">Update</button>
                    </div>

				</form>
			</div>
		</div>
		
	</div>
@endsection
@section('footer')

<script type="text/javascript">
    $('body').on('change', 'select.country', function() {
      var select=$(this).parent().next('div').find('select.state');
      $.get("/ajaxstates?country="+$(this).val(), function(data){
            // Display the returned data in browser
            select.html(data);
      });
    });
 
</script>
@stop