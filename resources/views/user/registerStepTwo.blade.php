@extends('layouts.restaurant')
@section('page_title')
Register Step 2
@stop
@section('content')
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
<section class="account">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>Let's create your account</h1>
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				<div class="row">
					<form action="{{url('user-register-step-2')}}" method="post">
					{{ csrf_field() }}
						<div class="col-md-6">
							<p>Indicate Work Status Please<span></span></p>
							<select name="work_status">
								<option value="">Select Work Status</option>
								<option value="Work Full Time">Work Full Time</option>
								<option value="Work Part Time">Work Part Time</option>
								<option value="Student Work Part Time">Student / Work Part Time</option>
								<option value="Student Full Time">Student Full Time</option>
								<option value="Homemaker">Homemaker</option>
							</select>
						</div>
						<div class="col-md-6">
							<p>Type Of Work You Do<span></span></p>
							<select name="work_type">
								<option value="">Select Work Type</option>
								<option value="CEO CFO">CEO / CFO</option>
								<option value="Medical">Medical</option>
								<option value="Financial">Financial</option>
								<option value="Legal">Legal</option>
								<option value="Teaching">Teaching</option>
							</select>
						</div>
						<div class="col-md-6">
							<p>How Often Do You Dine Out<span></span></p>
							<select name="dine_out">
								<option value="">Select Work Type</option>
								<option value="Once Per Week">Once Per Week</option>
								<option value="Twice Per Week">Twice Per Week</option>
								<option value="Three Times Per Week">Three Times Per Week</option>
								<option value="Four Times Per Week">Four Times Per Week</option>
								<option value="Five Times Per Week">Five Times Per Week</option>
								<option value="Daily">Daily</option>
								<option value="Multiple Times Per Day">Multiple Times Per Day</option>
							</select>
						</div>
						<div class="col-md-6">
							<p>What Part Of The App Will You Use Most</p>
							<select name="offer_like">
								<option value="">Select Work Type</option>
								@foreach($allOffer as $offer)
								<option value="{{$offer['id']}}">{{$offer['name']}}</option>
								@endforeach
								<option value="0">Will Use Both Equally</option>
							</select>
						</div>
						<div class="col-md-12">
							<center>
							<a href="/user-register-step-3" class="next-button">Skip</a>
							<button type="submit" class="next-button" alt="SUBMIT">Next
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
	 $('html,body').animate({
        scrollTop: $(".account").offset().top},
        'slow');
</script>
@stop