@extends('layouts.restaurant')
@section('page_title')
Register Step 1
@stop 
@section('content')
<style>
.referal_code{
	background: #DB1718;
	color: #fff;
	width: 315px;
	border: 0px;
	font-family: 'goudy-old-styleoldstylenormal';
	font-size: 18px;
	margin-top: 20px;
}
</style>
<div class="clearfix"></div>
<section class="join-banner">
	<h1>Let's get you started!</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<h2>$ {{$setting[0]->subscription_price}}</h2>
			</div>
			<div class="col-md-7">
				<h3>MONTHLY MEMBERSHIP</h3>
				<p>Get HALF OFF Entrees and Alcohol for You and a Guest All Day, Every Day.</p>
				<p>HAPPINESS GUARANTEED; cancel at any time!</p>
				<p>Can be used at ANY CLUB SIP & SAVOR ESTABLISHMENT</p>
			</div>
		</div>
   </div>
</section>
<center><img src="{{url('img/shadow.png')}}" class="img-responsive"></center>
<div class="clearfix"></div>
<form action="{{url('user-register-step-1')}}" method="post">
			
<section class="tell_us">
	<div class="container">
			<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>Tell us who sent you</h1>
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				<div class="row">
						<div class="col-md-6">
							<p>Referral Code or Member ID<span>*</span></p>
							<input type="text" value="{{old('offer_code')}}" placeholder="Referral Code" name="offer_code" id="offer_code" class="validate[required]">
							@if ($errors->has('offer_code'))
								<span class="help-block">
									<strong>{{ $errors->first('offer_code') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-md-6">
							<p>+3 Code (optional)</p>
							<input type="text" name="three_code" placeholder="+3 Code" value="{{old('three_code')}}">
							@if ($errors->has('three_code'))
								<span class="help-block">
									<strong>{{ $errors->first('three_code') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-md-12">
							<center><input id="referal_code" class="referal_code" type="button" value="DON’T HAVE A REFERRAL CODE?"></center>
						</div>
						
						<div class="col-md-12"  id="display_offer" style="display:none">
							<select name="select_offer" id="select_offer">
								<option value="">Select Offer Code</option>
								@foreach($allOffer as $offer)
								<option value="{{$offer['offer_code']}}" {{old('offer_code')==$offer['offer_code']?'selected':''}}>{{$offer['name']}}</option>
								@endforeach
							</select>
						</div>
						
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>
<section class="account">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>Let's create your account</h1>
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				@if(session()->has('success'))
					<div class="alert alert-success">
						{{ session()->get('success') }}
					</div>
				@endif
				{{session()->forget('success')}}
				<div class="row">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6">
								<p>First Name<span>*</span></p>
								<input type="text" name="name" value="{{old('name')}}" class=" validate[required,custom[onlyLetterSp]]" placeholder="First Name">
								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-6">
								<p>Last Name<span>*</span></p>
								<input type="text" name="last_name" class=" validate[required,custom[onlyLetterSp]]" value="{{old('last_name')}}" placeholder="Last Name">
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
								<input type="email" name="email" class="email validate[required,custom[email]]" value="{{old('email')}}">
									<span class="help-block alert-danger @if(!$errors->has('email')) hide @endif">
										<strong>* E-Mail ID is already registered.</strong>
									</span>
							</div>
							<div class="col-md-6">
								<p>Phone Number<span>*</span></p>
								<input type="text" name="phone" class=" validate[required,custom[phone]]" placeholder="+911234567890" value="{{old('phone')}}">
								@if ($errors->has('phone'))
									<span class="help-block">
										<strong>{{ $errors->first('phone') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<p>Password<span>*</span></p>
								<input type="password" id="password" name="password" class=" validate[required,custom[password]]" value="" placeholder="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" 
								 title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" minlength="6" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,20})" required="">
								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-6">
								<p>Confirm Password<span>*</span></p>
								<input type="password" name="password_confirmation" class=" validate[required,equals[password]]" value="" placeholder="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" 
								 title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" minlength="6" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,20})">
								@if ($errors->has('password_confirmation'))
									<span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<p><input type="checkbox" name="newsletter" value="1">&nbsp;&nbsp;&nbsp;Subscribe to the Club Sip &amp; Savour newsletter here.<span></span></p>
							</div>
						</div>	
						<div class="col-md-12">
							<center><button type="submit" class="next-button" alt="NEXT" >NEXT<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
							</button></center>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>
		</form>		
			
<div class="clearfix"></div>
@endsection
@section('footer')
<script type="text/javascript">
$("#select_offer").change(function(){
	var offerVal = $("#select_offer").val();
	$("#offer_code").val(offerVal);
});

$("#referal_code").click(function(){	
	$("#display_offer").css("display","block");
});

$(document).ready(function(){
	$("#display_offer").css("display","none");
	$("#select_offer").val($("#select_offer option:first").val());
	
});
 $('.email').blur(function (event) {
                $.get("/checkuser?email="+$(this).val(), function(data){
                    // Display the returned data in browser
                    if(data==1)
                        $('.help-block').removeClass('hide');
                    else
                        $('.help-block').addClass('hide');
                 });
        });
</script>
<script type="text/javascript">
	 $('html,body').animate({
        scrollTop: $(".account").offset().top},
        'slow');
</script>
@stop