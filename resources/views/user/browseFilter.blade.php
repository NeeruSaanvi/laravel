@if(sizeof($allRestaurant)>0)
@foreach($allRestaurant as $resturant)	
<div class="one-resto">
	<div class="col-md-4 col-sm-12">
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<img src="{{url('img/one_r.jpg')}}" alt="restourant" class="img-responsive">
			</div>
			<div class="col-md-8 col-sm-8">
				<h3><a href="detail.html">{{$resturant['name']}} </a></h3>
				<h5>{{$resturant['street']}}</br> {{$resturant['building']}}, {{$resturant['city']}}, {{$resturant['pincode']}}, {{$resturant['country']}}</h5>
		
				<ul>
					<li><i class="fa fa-star"></i></li>
					<li><i class="fa fa-star"></i></li>
					<li><i class="fa fa-star"></i></li>
					<li><i class="fa fa-star"></i></li>
					<li><i class="fa fa-star-half-o"></i></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-12 col-md-offset-1">
		<div class="row">
			<div class="responsive">
				@if(isset($resturant['resturant']) && sizeof($resturant['resturant'])>0)
				@foreach($resturant['resturant'] as $images)	
				<div class="col-md-3 col-sm-3 hidden-xs">
					<div class="hovereffect">
						<img src="{{url('img/r1.jpg')}}" alt="slide" class="img-responsive">{{$images['image_path']}}
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
@endforeach
@endif