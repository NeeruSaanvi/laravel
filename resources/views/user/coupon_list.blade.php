@extends('layouts/user_layout')
@section('page_title')
Coupon List
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/user">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Coupon List</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Coupon List
  </h1>
  <!-- END PAGE TITLE-->
   <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-globe"></i>Coupon List</div>
            <div class="tools"> </div>
        </div>

        <div class="portlet-body">
				 <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Restaurant</th>
                    <th>Address</th>
                    <th>Purchased on</th>
                    <th>Offer</th>
                    <th>Offer Code</th>
                    <th>Status</th>
                 </tr>
                </thead>
                <tbody>
                    @foreach($offer_all as $offer)
                   <tr>
                    <td>{{ $offer->rest_name }}</td>
                    <td>{{ $offer->building}}, {{$offer->street}}, {{$offer->city}} - 
						           {{$offer->pincode}}</td>
                    <td>{{ date('d-m-Y H:i',strtotime($offer->created_at)) }}</td>
                    <td>{{ $offer->offer_name }}</td>
                    <td>{{ $offer->offer_code }}</td>
                    <td>
                        @if($offer->redeem_by==null)
                          @if($offer->status)
                            Active
                          @else
                            Expired at {{date('d-m-Y H:i',strtotime( $offer->expired_at))}} 
                          @endif
                        @else
                           Redeemed at {{date('d-m-Y H:i',strtotime( $offer->redeem_at))}} 
                        @endif
                    </td>
                  </tr>
                    @endforeach
                </tbody>
              </table>	
			</div>
		</div>
		
@endsection
@section('footer')


@stop