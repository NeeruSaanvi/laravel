@extends('layouts.restaurant')
@section('page_title')
Browse Restaurants
@stop 
@section('content')
  <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">     
  <section class="banner">
	<img src="{{url('img/banner3.jpg')}}" class="img-responsive" alt="banner">
</section>
<center><img src="{{url('img/shadow.png')}}" class="img-responsive"></center>
<div class="clearfix"></div>
<section class="filter">
	<div class="container">
		<h1>Filter by Cuisine Type</h1>
		<div class="row">
			<div class="col-md-6">
				<h3 id="list">Showing {{count($allRestaurant)>10?'10':count($allRestaurant)}} of {{count($allRestaurant)}} restaurants <a><span id="all">(Show All)</span></a></h3>	
			</div>
			<div class="col-md-3">
				
					<select id="foodType">
						<option value="">Select Food Type</option>
						@foreach($allFoodType as $foodType)
						<option value="{{$foodType['id']}}">{{$foodType['name']}}</option>
						@endforeach
					</select>
			</div>
			<div class="col-md-3">
				<input type="text" id="search" name="search" placeholder="Search By Name, City, Zip Code" value="">
			</div>
			<div class="col-md-12">	
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19519834.187669218!2d-117.93878153843382!3d53.329072814317605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b0d03d337cc6ad9%3A0x9968b72aa2438fa5!2sCanada!5e0!3m2!1sen!2s!4v1493795726678" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>			
			</div>						
		</div>
	</div>			
</section>
<div class="clearfix"></div>
<section class="browse">
	<div class="container">
		<div class="row" id="filterData">
			@if(count($allRestaurant)>0)
			<?php $irest=0; ?>
			@foreach($allRestaurant as $resturant)	
			<?php $irest++; ?>
			@if($irest>10)
			<?php break; ?>
			@endif
			<div class="one-resto">
				<div class="col-md-4 col-sm-12">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<img src="{{ Config::get('images.user_images').$resturant->image }}" alt="restourant" class="img-responsive">
						</div>
						<div class="col-md-8 col-sm-8">
							<h3><a href="/rest_detail/{{$resturant->username}}">{{$resturant->rest_name}} </a></h3>
							<h5>{{$resturant->street}}</br> {{$resturant->building}}, {{$resturant->city}}, {{$resturant->pincode}}</h5>
					
							<span class="stars">{{ $resturant->star_rating }}</span>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-md-offset-1">
					<div class="row">
						<div class="responsive">
							@if(isset($resturant->images) && count($resturant->images)>0)
							<?php $i=0; ?>
							@foreach($resturant->images as $image)
								@if($image->image_type=='gallery')
								<?php $i=$i+1; ?>
								<div class="col-md-3 col-sm-3">
									<a href="{{ url('/').Config::get('images.user_images').$image->image_path }}"><img src="{{ Config::get('images.user_images').$image->image_path }}" alt="slide" class="img-responsive"></a>
									@if($i==4)
										<a href="/rest_detail/{{$resturant->username}}" class="more">View More</a>
									@endif
									
								</div>
								@endif
								@if($i==4)
									<?php break; ?>
								@endif
									
							@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@else
			<h3><center>No Restaurant Found(s).</center></h3>
			@endif
		</div>
	</div>
</section>	
<div class="clearfix"></div>
@endsection
@section('footer')
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="/css/magnific-popup.css">

<!-- Magnific Popup core JS file -->
<script src="/js/jquery.magnific-popup.min.js"></script>

<script type="text/javascript">
   $('.responsive').magnificPopup({  delegate: 'a',
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
$("#foodType").change(function(){
	var foodType = $("#foodType").val();
	var search = $("#search").val();
	var token = $("input[name='_token']").val();
	var datastring = "foodFilter="+foodType+"&searchFilter="+search+"&_token="+token;
	$.ajax({
		type: "POST",
		url: "{{url('browsefilter')}}",
		data: datastring,
		success: function (result) {
			$("#filterData").html(result);
			$('span.stars').stars();
		}
	});
	$.get("/restcount?foodFilter="+foodType+"&searchFilter="+search, function(data){
            // Display the returned data in browser
    		$('#list').html(data);
      });
	 $('html,body').animate({
        scrollTop: $("#foodType").offset().top},
        'slow');
});

$("#search").on('keyup',function(){
	var foodType = $("#foodType").val();
	var search = $("#search").val();
	var token = $("input[name='_token']").val();
	var datastring = "foodFilter="+foodType+"&searchFilter="+search+"&_token="+token;
	$.ajax({
		type: "POST",
		url: "{{url('browsefilter')}}",
		data: datastring,
		success: function (result) {
			$("#filterData").html(result);
			$('span.stars').stars();
		}
	});
	$.get("/restcount?foodFilter="+foodType+"&searchFilter="+search, function(data){
            // Display the returned data in browser
    		$('#list').html(data);
      });
	 $('html,body').animate({
        scrollTop: $("#foodType").offset().top},
        'slow');
});

$("#all").click(function(){
	$.get("/browseall", function(data){
            // Display the returned data in browser
            $("#filterData").html(data);
			$('span.stars').stars();
	  });
	$.get("/restcount", function(data){
            // Display the returned data in browser
    		$('#list').html(data);
      });
	 $('html,body').animate({
        scrollTop: $("#foodType").offset().top},
        'slow');
});

	 $('html,body').animate({
         scrollTop: $("#foodType").offset().top},
      'slow');
</script>
@stop
