<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="stylesheet" href="/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="/css/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="/css/hover.css">
     <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}">
	 <link rel="stylesheet" type="text/css" href="{{url('css/animate.min.css')}}">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{url('css/slick.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('css/slick-theme.css')}}">
		 <script src="{{url('js/wow.js')}}"></script>
            <script>
            wow = new WOW(
                      {
                      boxClass:     'wow',      // default
                      animateClass: 'animated', // default
                      offset:       0,          // default
                      mobile:       true,       // default
                      live:         true        // default
                    }
                    );
           wow.init();
              </script>
	<script src="{{url('js/modernizr.js')}}"></script> <!-- Modernizr -->
	<title>@yield('page_title')</title>
</head>
<body>
			<header class="header cls-rel">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-xs-5">
							<a href="/"><img src="{{url('img/logo.png')}}" alt="logo" class="img-responsive"></a>
						</div>
						<div class="hidden-md hidden-lg col-sm-7 col-xs-7">
							<div class="menu">
								<a id="toggler" href="javascript:void(0)">
								<img class="barss" src="{{url('img/micon.png')}}" width="15"/> 
								<img class="close-bar" src="{{url('img/close.png')}}" width="15"  />
								</a>
								<ul class="main-menu1">
									<li><a href="{{url('who-we-are')}}"> Who We Are</a></li>
									<li><a href="{{url('works')}}"> How It Works</a></li>
									<li><a href="@if(Auth::check())	{{url('browse')}} @else {{url('login')}} @endif"> Browse Restaurants & Bars</a></li>
									<li><a href="{{url('faq')}}"> Faq</a></li>
									@if(Auth::check())
										@if(Auth::user()->role=='User')
										<li><a href="/user">Welcome, {{Auth::user()->name}}</a>
										<ul class="sub-menu">
										<li><a href="/user/user-profile">Profile</a></li>
										<li><a href="/user/couponlist">Coupon List</a></li>
										<li><a href="/logout">Logout</a></li>
										</ul></li>
										@elseif(Auth::user()->role=='Admin')
										<li><a href="/admin">Welcome, {{Auth::user()->name}}</a></li>
										@else
										<li><a href="/resturant">Welcome, {{Auth::user()->name}}</a></li>
										@endif
									@else
									<li><a href="{{url('login')}}"> Log In</a></li>
									<li><a href="{{url('user-register-step-1')}}"> Join</a></li>
									@endif
								</ul>
							</div>
						</div>
						<div class="col-md-9 hidden-xs hidden-sm">
							<ul class="main-menu">
								<li><a href="{{url('who-we-are')}}" class="hvr-outline-in"> Who We Are</a></li>
								<li><a href="{{url('works')}}" class="hvr-outline-in"> How It Works</a></li>
								<li><a href="@if(Auth::check())	{{url('browse')}} @else {{url('login')}} @endif" class="hvr-outline-in"> Browse Restaurants & Bars</a></li>
								<li><a href="{{url('faq')}}" class="hvr-outline-in"> Faq</a></li>
								@if(Auth::check())
										@if(Auth::user()->role=='User')
										<li><a href="/user">Welcome, {{Auth::user()->name}}</a>
										<ul class="sub-menu">
										<li><a href="/user/user-profile">Profile</a></li>
										<li><a href="/user/couponlist">Coupon List</a></li>
										<li><a href="/logout">Logout</a></li>
										</ul></li>
										@elseif(Auth::user()->role=='Admin')
										<li><a href="/admin">Welcome, {{Auth::user()->name}}</a></li>
										@else
										<li><a href="/resturant">Welcome, {{Auth::user()->name}}</a></li>
										@endif
									@else
									<li><a href="{{url('login')}}"> Log In</a></li>
									<li><a href="{{url('user-register-step-1')}}"> Join</a></li>
									@endif
							</ul>
						</div>
					</div>
				</div>
			
			</header>
			<div class="clearfix"></div>
			@yield('content')
			<div class="clearfix"></div>
			<footer>
				<div class="container">
					<div class="col-md-3">
						<img src="{{url('img/logo.png')}}" alt="logo" class="img-responsive">
						<p>Lorem Ipsum is simply dummy text of the printing</p>
					</div>
					 <div class="col-md-4 col-md-offset-1">
						<h1>Contact Details</h1>
						<p class="mark1">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
						<p class="phone">+1 1987654320</p>
						<center>
							<ul class="footer-icon">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-instagram"></i></a></li>
							</ul>
						</center>
					</div>
					<div class="col-md-3 col-md-offset-1">
					 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41274847.78911851!2d-130.06768675331236!3d50.845669766283294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b0d03d337cc6ad9%3A0x9968b72aa2438fa5!2sCanada!5e0!3m2!1sen!2sin!4v1493727055055" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</footer>
			
<script src="{{url('js/jquery-2.1.4.js')}}"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/slick.js')}}"></script>
<script src="{{url('js/jquery.viewportchecker.min.js')}}"></script> 
    <link rel="stylesheet" href="/assets/css/validationEngine.jquery.css" type="text/css"/>
        <link rel="stylesheet" href="/assets/css/template.css" type="text/css"/>
        <script src="/assets/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="/assets/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    
     <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("form").validationEngine();
        });
    </script>
  
<script>
jQuery('.awesome-slideInLeft').addClass("hideme").viewportChecker({
    classToAdd: 'visible animated slideInLeft',
    offset: 100
});
</script>

<script>
jQuery('.awesome-slideInRight').addClass("hideme").viewportChecker({
    classToAdd: 'visible animated slideInRight',
    offset: 100
});
</script>

<script>
jQuery('.awesome-zoomIn').addClass("hideme").viewportChecker({
    classToAdd: 'visible animated zoomIn',
    offset: 100
});
</script>
<script>

$('.one-time').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  adaptiveHeight: true,
  autoplay:true,
    responsive: [
    {
      breakpoint: 720,
      settings: {
        arrows: false
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]


});
</script>
<script>
 $(document).ready(function () {
 $("#toggler").click(function () {
                    $(".main-menu1").toggleClass("show-in");
                    $(".close-bar").toggleClass("show-me");
                    $(".barss").toggleClass("show-me-not");
                });
                
                $(document).click(function(e) {
                    if ( $('.main-menu1').hasClass("show-in") && 
                            $(e.target).closest('.main-menu1').length === 0 &&
                            $(e.target).closest('#toggler').length === 0) {
                        $(".main-menu1").toggleClass("show-in");
                        $(".close-bar").toggleClass("show-me");
                        $(".barss").toggleClass("show-me-not");
                    }
                });
				});
</script>
<script>

$(window).scroll(function() {    



    var scroll = $(window).scrollTop();

    if (scroll >= 200) {
        $(".header").addClass("darkHeader");
    }

 else
	  if (scroll >= 0) {
        $(".header").removeClass("darkHeader");
	  }
    });
 
</script>
		@yield('footer')
	
</body>
</html>

   