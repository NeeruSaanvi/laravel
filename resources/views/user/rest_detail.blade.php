@extends('layouts.restaurant')
@section('page_title')
Browse Restaurants
@stop 
@section('content')
<section class="banner">
				    <img src="{{ Config::get('images.user_images').$allRestaurant[0]->coverimage }}" alt="banner" class="img-responsive">
								  
			</section>
			<center><img src="/img/shadow.png" class="img-responsive"></center>
			<div class="clearfix"></div>
		
			<section class="reb-page">
				<div class="container">

					<p class="star">
					{{ $allRestaurant[0]->rest_name }} (<span class="stars">{{ $allRestaurant[0]->star_rating }}</span>)<!--  3138 reviews -->
					</p>
					<div class="clearfix"></div>
					<div class="row">
						@if(session()->has('message'))
							<div class="alert alert-success">
								{{ session()->get('message') }}
							</div>
						@endif
						{{session()->forget('message')}}
						@if(Auth::user()->role!='Restaurant')
						<div class="col-md-6 col-md-offset-3">
							<ul class="add-option">
								<li>Choose Offer</li>
								@foreach($allOffer as $offer)
									@if(session()->has('offerid')) @if(session()->get('offerid')==$offer['id']) 
										<li>{{ session()->get('coupon') }}</li>
									@else 
										<li><a href="/chose/offer/{{$offer['id']}}/{{$allRestaurant[0]->username}}">{{$offer['name']}}</a></li>
									@endif
								@else
								<li><a href="/chose/offer/{{$offer['id']}}/{{$allRestaurant[0]->username}}">{{$offer['name']}}</a></li>
								@endif	
								@endforeach	
							</ul>
							{{session()->forget('offerid')}}
							{{session()->forget('coupon')}}
						@endif
						</div>
							<?php $i=0; ?>
								@foreach($allimages as $images)
								@if($images->image_type=='menu')
								@if($i==0)
								<div class="col-md-6 menu-col">
									<h3>Menu</h3>
									<div class="responsive">
									<?php $i++; ?>
								@endif
								<div>
									<div class="col-md-12">
									   <a href="{{ url('/').Config::get('images.user_images').$images->image_path }}" title="Photo Title">
          								 <img src="{{ Config::get('images.user_images').$images->image_path }}" alt="menu">
          								</a>
									</div>
								</div>
								@endif
								@endforeach
							@if($i>0)
										</div>		
						</div>
						
								@endif
								
							<?php $i=0; ?>
								@foreach($allimages as $images)
								@if($images->image_type=='gallery')
								@if($i==0)
								<div class="col-md-6 photo-col">
									<h3>Photos</h3>
									<div class="responsive1">
											<?php $i++; ?>
								@endif
								<div>
									<div class="col-md-12">
									   <a href="{{ url('/').Config::get('images.user_images').$images->image_path }}" title="Photo Title">
          								 <img src="{{ Config::get('images.user_images').$images->image_path }}" alt="menu">
          								</a>
									</div>
								</div>
								@endif
								@endforeach
							@if($i>0)
										</div>		
						</div>
						
								@endif
							
					</div>
				</div>
			</section>
			<div class="clearfix"></div>
			<section class="about-block">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							@foreach($allimages as $images)
							@if($images->image_type=='slider')
							<div class="hovereffect">
									<img class="img-responsive" alt="about" src="{{ Config::get('images.user_images').$images->image_path }}">
							</div>
							<?php break; ?>
							@endif
							@endforeach
						</div>
						<div class="col-md-6">
							<h1>About</h1>
							<p>{{$allRestaurant[0]->more_info}}</p>
						</div>	
					</div>
				</div>
			</section>
			
			<section class="location">
			<div class="container">
			<div class="row">
				<div class="col-md-3">
			        <h1>Address</h1>
					<p class="r-location">
						{{$allRestaurant[0]->street}}, {{$allRestaurant[0]->building}}, {{$allRestaurant[0]->city}},
						 {{$allRestaurant[0]->pincode}}
					</p>
				    <p class="r-phone"> {{$allRestaurant[0]->contact_no}}</p>
				    <p class="tab">{{$allRestaurant[0]->website}}</p>
				</div>
				<div class="col-md-9">
			        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26370307.26923503!2d-113.69772497502544!3d36.21442567184547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited+States!5e0!3m2!1sen!2sin!4v1494330023154" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
			    </div>
			</div>			
			</div>
			</section>

		<section class="rating-block about-block">
				<div class="container">

					<div class="row">
						@if(Auth::user()->role!='Restaurant')
						<div class="col-md-6">
							<h1>Reviews Us</h1>
							<div class="form-horizontal">
							    <div class="col-md-12">
                                    <label><input type="radio" name="rating" value="1">1</label>
                                    <label><input type="radio" name="rating" value="2">2</label>
                                    <label><input type="radio" name="rating" value="3">3</label>
                                    <label><input type="radio" name="rating" value="4">4</label>
                                    <label><input type="radio" name="rating" value="5">5</label>
                                </div>
                           <div class="col-md-12">
						        <textarea name="feedback" type="text"></textarea>
                            </div>
                           <div class="col-md-12">
							<center><input type="submit" class="rate_us" value="Rate Us"></center>
							</div>
                            <div class="clearfix"></div>
							</div>
                            <div class="clearfix"></div>
							</div>
							<div class="col-md-6">
						@else
							<div class="col-md-12">
						
						@endif
							<h1>Reviews ({{count($ratings)}})</h1>
							@if(count($ratings)>0)
							@foreach($ratings as $rating)
							<div class="media">
                              <div class="media-body">
	                              <h4 class="media-heading">
	                                 {{$rating->full_name}}(<span class="stars">{{$rating->rating}}</span>) on
	                                  <span class="c-date">{{date('d/m/Y',strtotime($rating->created_at))}}</span>
	                              </h4>{{$rating->remarks}}

	                              </div>
	                              <hr>
	                        </div>
							@endforeach
							@else
								<h3>No review(s) found.</h3>
							@endif
						</div>

					</div>
				</div>
			</section>
 <meta name="_token" content="{!! csrf_token() !!}"/>
	
@endsection
@section('footer')
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="/css/magnific-popup.css">

<!-- Magnific Popup core JS file -->
<script src="/js/jquery.magnific-popup.min.js"></script>

<script type="text/javascript">
   $('.responsive1,.responsive').magnificPopup({  delegate: 'a',
          type: 'image',
          tLoading: 'Loading image #%curr%...',
          mainClass: 'mfp-img-mobile',
          gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
          },
          image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
           
          }
      });

    $.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $(document).ready(function(){
      $('.rate_us').click(function(){            
        $.ajax({
          url: '/user/rating/{{$allRestaurant[0]->username}}',
          type: "post",
          data: {'rating':$('input[name=rating]:checked').val(),'feedback':$('input[name=feedback]').val()},
          success: function(data){
            alert(data);
          }
        });      
      }); 
    });
</script>

<script type="text/javascript">
    $.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 24;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
   $(function() {
    $('span.stars').stars();
}); 
</script>
<script>
$('.responsive').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  autoplay:true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
		
</script>
<script>
$('.responsive1').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 3,
  autoplay:true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
		
</script>
<script type="text/javascript">
	 $('html,body').animate({
        scrollTop: $(".reb-page").offset().top},
        'slow');
</script>
@stop