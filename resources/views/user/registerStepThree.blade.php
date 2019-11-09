@extends('layouts.restaurant')
@section('page_title')
Register Step 3
@stop 
@section('content')
<div class="clearfix"></div>
<section class="join-banner">
	<h1>You're almost done!</h1>
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
				<h1>Your billing information</h1>
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				<div class="row">
					<form action="{{url('user-register-step-3')}}" method="post">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-12">
								<p>Street Address<span>*</span></p>
								<input type="text" class=" validate[required]" name="street_address" value="{{old('street_address')}}">
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
								<input type="text" name="apt_suite" value="{{old('apt_suite')}}">
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
								<input type="text" name="city" class=" validate[required,custom[onlyLetterSp]]" value="{{old('city')}}">
								
								@if ($errors->has('city'))
									
									<span class="help-block">
										<strong>{{ $errors->first('city') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-6">
								<p>Zip/Postal Code<span>*</span></p>
								<input type="text" name="zip_code" class=" validate[required,custom[zip]]" value="{{old('zip_code')}}">
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
								
								<select name="country" class="country" class=" validate[required]">
									<option  value="" @if(old('country') == "") selected @endif>Select Country</option>
									
									@foreach($countries as $country)
									<option  value="{{$country->id}}" @if(old('country') == $country->id) selected @endif>{{$country->name}}</option>
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
								<select name="state" class="state" class=" validate[required]">
									<option value="" @if(old('state') == "") selected @endif>Select State</option>
									
									@foreach($statess as $state)
									<option value="{{$state->name}}" @if(old('state') == $state->name) selected @endif>{{$state->name}}</option>
									@endforeach
								</select>
								
								@if ($errors->has('state'))
									<span class="help-block">
										<strong>{{ $errors->first('state') }}</strong>
									</span>
								@endif
							</div>
							
						</div>
							
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>Your credit card information</h1>
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				<div class="row">
						<div class="row">
							<div class="col-md-8">
								<p>Card Number<span>*</span></p>
								<input type="text" name="card_number" class=" validate[required]" value="{{old('card_number')}}">
								@if ($errors->has('card_number'))
									<span class="help-block">
										<strong>{{ $errors->first('card_number') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-4">
								<p>Exp. Date* (MM/YYYY)<span>*</span></p>
								<input type="text" name="exp_date" class=" validate[required]" value="{{old('exp_date')}}">
								@if ($errors->has('exp_date'))
									<span class="help-block">
										<strong>{{ $errors->first('exp_date') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<p>Name on Card<span>*</span></p>
								<input type="text" name="name_of_card" class=" validate[required,custom[onlyLetterSp]]" value="{{old('name_of_card')}}">
								
								@if ($errors->has('name_of_card'))
									
									<span class="help-block">
										<strong>{{ $errors->first('name_of_card') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-md-4">
								<p>CVV<span>*</span></p>
								<input type="text" name="cvv" class=" validate[required,custom[onlyNumberSp]]" value="{{old('cvv')}}">
								@if ($errors->has('cvv'))
									<span class="help-block">
										<strong>{{ $errors->first('cvv') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
						<div class="col-md-12">
							<center><button type="submit" class="next-button" alt="NEXT" >Submit<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
							</button></center>
						</div>
					</form>		
				</div>
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
<script type="text/javascript">
	 $('html,body').animate({
        scrollTop: $(".account").offset().top},
        'slow');
</script>
@stop