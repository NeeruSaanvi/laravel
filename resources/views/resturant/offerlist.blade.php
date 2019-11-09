@extends('layouts/resturant_layout')
@section('page_title')
Coupons
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/resturant">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Coupons</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Coupons
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
        <div class="row">
         <div class="col-sm-12">
            <div class="portlet-body form">
                <form class="form-material form-horizontal" method="get" action="/resturant/useroffer/list">
                             <div class="form-actions">
                    <div class="form-group col-sm-4">
                        <label class="col-md-12" for="description">Status</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="status">
                                <option value="">Select</option>
                                <option value="Used" {{(old('status')?e(old('status')):$status)== 'Used'?'selected':''}}>Redeemed</option>
                                <option value="Pending" {{(old('status')?e(old('status')):$status)== 'Pending'?'selected':''}}>Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-5">
                        <label class="col-md-12" for="description">Date</span></label>
                        <div class="col-md-12">
                        <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                        <input type="text" class="form-control" name="date_from" value="{{old('date_from')?e(old('date_from')):$date_from}}" readonly="readonly">
                        <span class="input-group-addon"> to </span>
                        <input type="text" class="form-control" name="date_to" value="{{old('date_to')?e(old('date_to')):$date_to}}"  readonly="readonly"> </div>
                            
                        </div>
                    </div>
                                 <div class="col-sm-2">
                        <div class="col-sm-12" style="height:23px;"></div>
                  <button type="submit" class="btn blue">Search</button></div>
                  </div>

                </form>    
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
  
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-globe"></i>Coupons</div>
            <div class="tools"> </div>
        </div>

        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>User Name</th>
                    <th>E-Mail</th>
                    <th>Purchased At</th>
                    <th>Offer</th>
                    <th>Offer Code</th>
                    <th>Status</th>
                 </tr>
                </thead>
                <tbody>
                    @foreach($offer_all as $offer)
                   <tr>
                    <td>{{ $offer->name.' '.$offer->last_name }}</td>
                    <td>{{ $offer->email }}</td>
                    <td>{{ date('d-m-Y H:i',strtotime($offer->created_at)) }}</td>
                    <td>{{ $offer->offer_name }}</td>
                    <td>{{ $offer->offer_code }}</td>
                    <td>
                         @if($offer->redeem_by==null)
                          @if($offer->status)
                             <a class="redeem" href="/resturant/useroffer/redeem/{{ $offer->id }}"> Redeem</a>
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
@stop
@section('footer')
<script type="text/javascript">
    $(document).ready(function() {
        $('.table').DataTable( {
            "order": [[ 2, "desc" ]]
        } );
    } );

</script>
@stop