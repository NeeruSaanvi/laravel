@extends('layouts/resturant_layout')
@section('page_title')
Dashboard
@stop 

@section('content')
  <!-- BEGIN PAGE BAR -->
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <a href="/">Home</a>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>Dashboard</span>
          </li>
      </ul>
  </div>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Restaurant Dashboard
  </h1>
  <!-- END PAGE TITLE-->
   <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="/resturant/useroffer/trans">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                             <span data-counter="counterup" data-value="{{$analytic[0]->coupons}}">0</span>
                                        </div>
                                        <div class="desc">Offer Purchased </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="/resturant/useroffer/trans?status=Used">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="{{$analytic[0]->used_coupon}}">0</span>
                                        </div>
                                        <div class="desc"> Offer Redeemed </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="/resturant/useroffer/trans">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="{{$analytic[0]->coupons_offer1}}">0</span>
                                        </div>
                                        <div class="desc"> {{$analytic[0]->offer1}} </div>
                                 
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="/resturant/useroffer/trans">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="{{$analytic[0]->coupons_offer2}}"></span> </div>
                                        <div class="desc"> {{$analytic[0]->offer2}} </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- END DASHBOARD STATS 1-->
                         <div class="row">
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                  <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-body">
                                        <div id="morris_chart_2"></div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                              <div class="portlet light bordered">
                                      <div class="portlet-title tabbable-line">
                                          <div class="caption">
                                              <i class="icon-bubbles font-dark hide"></i>
                                              <span class="caption-subject font-dark bold uppercase">Coupon List</span>
                                          </div>
                                          <div class="actions">
                                              <div class="btn-group btn-group-devided">
                                                   <a href="/resturant/useroffer/list">
                                                   <label class="btn blue btn-outline btn-circle btn-sm active">
                                                     View All</label></a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="portlet-body">
                                          <div class="tab-content">
                                              <div class="tab-pane active" id="portlet_comments_1">
                                                  <!-- BEGIN: Comments -->
                                                  <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" width="100%">
                                                      <thead>
                                                        <tr>
                                                          <th>User Name</th>
                                                          <th>Purchased At</th>
                                                          <th>Offer</th>
                                                          <th>Offer Code</th>
                                                          <th>Status</th>
                                                       </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i=0; ?>
                                                          @foreach($offer_all as $offer)
                                                          @if($i<5)
                                                         <tr>
                                                          <td>{{ $offer->name.' '.$offer->last_name }}</td>
                                                          <td>{{ date('d-m-Y H:i',strtotime($offer->created_at)) }}</td>
                                                          <td>{{ $offer->offer_name }}</td>
                                                          <td>{{ $offer->offer_code }}</td>
                                                          <td>
                                                              @if($offer->redeem_by==null)
                                                                <a class="redeem" href="/resturant/useroffer/redeem/{{ $offer->id }}"> Redeem</a>
                                                              @else
                                                                 Redeemed at {{date('d-m-Y H:i',strtotime($offer->redeem_at))}} 
                                                              @endif
                                                          </td>
                                                        </tr>
                                                          <?php $i++; ?>
                                                        @else
                                                        <?php break; ?>
                                                        @endif
                                                          @endforeach
                                                      </tbody>
                                                    </table>
                                                  <!-- END: Comments -->
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                            
                          </div>

                        </div>
                        
                    
  @stop
  @section('footer')
  <script type="text/javascript">
jQuery(document).ready(function() {
      // AREA CHART
  new Morris.Area({
    element: 'morris_chart_2',
    data: [
      @if(count($offersall)>0)
      @foreach($offersall as $user)
      { m: '{{$user->month}}', a: {{$user->coupons_offer1}}, b: {{$user->coupons_offer2}} },
      @endforeach
      @else
      { m: {{date('m')}}, a: 0, b: 0 },
      @endif
     
    ],
    xkey: 'm',
    ykeys: ['a', 'b'],
    labels: ['{{$analytic[0]->offer1}}', '{{$analytic[0]->offer2}}']
  });


});


  </script>
  @stop