@extends('layouts.restaurant')
@section('page_title')
How It Works
@stop 
@section('content')
			<section class="banner">
			    <img src="img/banner2.jpg" class="img-responsive" alt="banner">
			</section>
			<center><img src="img/shadow.png" class="img-responsive"></center>
			<div class="clearfix"></div>
	        	<section class="works">
			    <div class="container">
			        <h1>How It Works</h1>
					<p class="sub_heading">Lorem Ipsum is simply dummy text of the printing<br> and typesetting industry</p>
				    <div class="row">
					    <div class="col-md-3 col-sm-3 awesome-zoomIn">
						     <center><img src="img/i1.png" alt="icon"> </center>
							<h4>BROWSE dozens of local establishments.</h4>	
						</div>
					    <div class="col-md-3 col-sm-3 pdd awesome-zoomIn">
						     <center><img src="img/i2.png" alt="icon"> </center>
							<h4>VISIT a Club Savor establishment.</h4>	
						</div>
						<div class="col-md-3 col-sm-3 awesome-zoomIn">			
						     <center><img src="img/i3.png" alt="icon"> </center>
							<h4>SHOW your Club Savor electronic ID to your server.</h4>	
						</div>
						<div class="col-md-3 pdd col-sm-3 awesome-zoomIn">
						   <center> <img src="img/i4.png" alt="icon"></center>
							<h4>ENJOY half off an entrée and one alcoholic drink for both you and a guest!</h4>	
						</div>
					</div>
				</div>		
			</section>
			<section class="works1 work-page">
			    <div class="container">
				    <div class="col-md-3 col-sm-6 awesome-slideInLeft col-md-offset-3">			
						<center><img src="img/alarm.png" alt="icon"> </center>
						<h4>Use your Club Savor membership all day, any day!</h4>	
					</div> 
					 <div class="col-md-3 col-sm-6 awesome-slideInRight">			
						<center><img src="img/calander.png" alt="icon"> </center>
						<h4>Refer your friends to earn free months!</h4>	
					</div> 
				</div>
			</section>
			<div class="clearfix"></div>
			<section class="note">
				<div class="container">
				    <p><span>Note:</span> Some restrictions may apply, see FAQ for details.</p>
				</div>
			</section>
@stop
@section('footer')
<script type="text/javascript">
	 $('html,body').animate({
        scrollTop: $(".works").offset().top},
        'slow');
</script>
@stop