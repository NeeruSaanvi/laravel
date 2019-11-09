@extends('layouts.restaurant')
@section('page_title')
Profile Setting
@stop 
@section('content')
<div class="clearfix"></div>
<section class="join-banner">
	<h1>Profile Settings</h1>
	<div class="container">
		<div class="row">
			
		</div>
   </div>
</section>
<center><img src="{{url('img/shadow.png')}}" class="img-responsive"></center>
<div class="clearfix"></div>
<section class="account">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				@if(session()->has('success'))
					<div class="alert alert-success">
						{{ session()->get('success') }}
					</div>
				@endif
				{{session()->forget('success')}}
					<form action="{{url('profile-update')}}" method="post">
					{{ csrf_field() }}
				<div class="row">
					<div class="col-md-6">
						<p>First Name<span>*</span></p>
						<input type="text" name="name" value="{{$userDetail[0]['name']}}">
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<p>Last Name<span>*</span></p>
						<input type="text" name="last_name" value="{{$userDetail[0]['last_name']}}">
						@if ($errors->has('last_name'))
							<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<p>Email<span>*</span></p>
						<input readonly type="email" name="email" value="{{$userDetail[0]['email']}}">
						
						@if ($errors->has('email'))
							
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<p>Phone Number<span>*</span></p>
						<input type="text" name="phone" value="{{$userDetail[0]['phone']}}">
						@if ($errors->has('phone'))
							<span class="help-block">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
					<div class="row">
							<div class="col-md-12">
								<p><input type="checkbox" name="newsletter" value="1" @if($userDetail[0]['newsletter'] == 1) checked @endif>&nbsp;&nbsp;&nbsp;Subscribe to the Club Sip &amp; Savour newsletter here.<span></span></p>
							</div>
						</div>	
					
					<div class="row">
					<div class="col-md-6">
							<p>Indicate Work Status Please <span></span></p>
							<select name="work_status">
								<option @if($userDetail[0]['work_status'] == "") selected @endif value="">Select Work Status</option>
								<option @if($userDetail[0]['work_status'] == "Work Full Time") selected @endif value="Work Full Time">Work Full Time</option>
								<option @if($userDetail[0]['work_status'] == "Work Part Time") selected @endif value="Work Part Time">Work Part Time</option>
								<option @if($userDetail[0]['work_status'] == "Student Work Part Time") selected @endif value="Student Work Part Time">Student / Work Part Time</option>
								<option @if($userDetail[0]['work_status'] == "Student Full Time") selected @endif value="Student Full Time">Student Full Time</option>
								<option @if($userDetail[0]['work_status'] == "Homemaker") selected @endif value="Homemaker">Homemaker</option>
							</select>
						</div>
						<div class="col-md-6">
							<p>Type Of Work You Do<span></span></p>
							<select name="work_type">
								<option @if($userDetail[0]['work_type'] == "") selected @endif value="">Select Work Type</option>
								<option @if($userDetail[0]['work_type'] == "CEO CFO") selected @endif value="CEO CFO">CEO / CFO</option>
								<option @if($userDetail[0]['work_type'] == "Medical") selected @endif value="Medical">Medical</option>
								<option @if($userDetail[0]['work_type'] == "Financial") selected @endif value="Financial">Financial</option>
								<option @if($userDetail[0]['work_type'] == "Legal") selected @endif value="Legal">Legal</option>
								<option @if($userDetail[0]['work_type'] == "Teaching") selected @endif value="Teaching">Teaching</option>
							</select>
						</div>
						<div class="col-md-6">
							<p>How Often Do You Dine Out<span></span></p>
							<select name="dine_out">
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
						<div class="col-md-6">
							<p>What Part Of The App Will You Use Most</p>
							<select name="offer_like">
								<option value="" @if($userDetail[0]['offer_like'] == "") selected @endif>Select Work Type</option>
								@foreach($allOffer as $offer)
								<option value="{{$offer['id']}}" @if($userDetail[0]['offer_like'] == $offer['id']) selected @endif>{{$offer['name']}}</option>
								@endforeach
								<option value="0"  @if($userDetail[0]['offer_like'] == 0) selected @endif>Will Use Both Equally</option>
							</select>
						</div>
				</div>		
						<div class="row">
							<div class="col-md-12">
								<p>Street Address<span>*</span></p>
								<input type="text" name="street_address" value="{{$userDetail[0]['building']}}">
								@if ($errors->has('street_address'))
									<span class="help-block">
										<strong>{{ $errors->first('street_address') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="row">	
							<div class="col-md-12">
								<p>Apt, suite, etc. (optional)<span></span></p>
								<input type="text" name="apt_suite" value="{{$userDetail[0]['street']}}">
								@if ($errors->has('apt_suite'))
									<span class="help-block">
										<strong>{{ $errors->first('apt_suite') }}</strong>
									</span>
								@endif
							</div>
						</div>	
						
						<div class="row">
							<div class="col-md-6">
								<p>City<span>*</span></p>
								<input type="text" name="city" value="{{$userDetail[0]['city']}}">
								
								@if ($errors->has('city'))
									
									<span class="help-block">
										<strong>{{ $errors->first('city') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-6">
								<p>Zip/Postal Code<span>*</span></p>
								<input type="text" name="zip_code" value="{{$userDetail[0]['pincode']}}">
								@if ($errors->has('zip_code'))
									<span class="help-block">
										<strong>{{ $errors->first('zip_code') }}</strong>
									</span>
								@endif
							</div>
						</div>	
						<div class="row">
						
							<div class="col-md-6">
								<p>Country<span>*</span></p>
								
								<select name="country" class="country">
									<option @if($userDetail[0]['country'] == "") selected @endif value="">Select Country</option>
									
									@foreach($countries as $country)
									<option @if($userDetail[0]['country'] == $country->id) selected @endif value="{{$country->id}}">{{$country->name}}</option>
									@endforeach
								</select>
								@if ($errors->has('country'))
									<span class="help-block">
										<strong>{{ $errors->first('country') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-6">
								<p>State<span>*</span></p>
								<select name="state" class="state">
									<option @if($userDetail[0]['state'] == "") selected @endif value="">Select State</option>
									
									@foreach($statess as $state)
									<option @if($userDetail[0]['state'] == $state->name) selected @endif value="{{$state->name}}">{{$state->name}}</option>
									@endforeach
								</select>
								
								@if ($errors->has('state'))
									<span class="help-block">
										<strong>{{ $errors->first('state') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
				<div class="col-md-12">
					<center><button type="submit" class="next-button" alt="SUBMIT">Update <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
					</button></center>
				</div>
				</form>
			</div>
		</div>
		
	</div>
</section>

<div class="clearfix"></div>
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