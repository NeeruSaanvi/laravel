@extends('layouts.restaurant')
@section('page_title')
Who We Are
@stop 
@section('content')
			<section class="banner">
			    <img src="img/who_banner.jpg" class="img-responsive" alt="banner">
			</section>
			<center><img src="img/shadow.png" class="img-responsive"></center>
			<div class="clearfix"></div>
	        <section class="first-block first">
			    <div class="container">
				    <h2>Who We Are</h2>
				    <div class="row">
				        <div class="col-md-5 awesome-slideInLeft">
						    <div class="hovereffect">
						        <img src="img/ab1.jpg" class="img-responsive" alt="image">
							</div>
						</div>
					     <div class="col-md-7 awesome-slideInRight">
						    <h1>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h1>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						
						</div>
					</div>
				</div> 
			</section>
            <div class="clearfix"></div>
			  <section class="first-block thired-block">
			    <div class="container">
				    <div class="row">
					    <div class="col-md-5 hidden-md hidden-lg hidden-sm awesome-slideInRight">
						    <div class="hovereffect">
						        <img src="img/ab2.jpg" class="img-responsive" alt="image">
							</div>
						</div> 
					    <div class="col-md-7 awesome-slideInLeft">
						    <h1>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h1>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						
						</div>
						<div class="col-md-5 hidden-xs awesome-slideInRight">
						    <div class="hovereffect">
						        <img src="img/ab2.jpg" class="img-responsive" alt="image">
							</div>
						</div>
					</div>
				</div> 
			</section>
			<div class="clearfix"></div>
	        <section class="first-block  first b_clr">
			    <div class="container">
				    <div class="row">
				        <div class="col-md-5 awesome-slideInLeft">
						    <div class="hovereffect">
						        <img src="img/ab3.jpg" class="img-responsive" alt="image">
							</div>
						</div>
					     <div class="col-md-7 awesome-slideInRight">
						      <h1>Club Sip & Savor helps you save more, so you can enjoy more.</h1>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						
						</div>
					</div>
				</div> 
			</section>
			<div class="clearfix"></div>
@stop
@section('footer')
<script type="text/javascript">
	 $('html,body').animate({
        scrollTop: $(".first-block").offset().top},
        'slow');
</script>
@stop