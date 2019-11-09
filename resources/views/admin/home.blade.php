@extends('layouts/admin_layout')
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
  <h1 class="page-title"> Admin Dashboard
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="/admin/users">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="{{$analytic[0]->users}}">0</span>
                                        </div>
                                        <div class="desc">Users </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="/admin/resturant">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="{{$analytic[0]->resturants}}">0</span></div>
                                        <div class="desc"> Restaurants </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="/admin/useroffer">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="{{$analytic[0]->coupons}}">0</span>
                                        </div>
                                        <div class="desc"> Coupons </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="/admin/useroffer?status=Used">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="{{$analytic[0]->used_coupon}}"></span> </div>
                                        <div class="desc"> Coupons Used </div>
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
                                              <span class="caption-subject font-dark bold uppercase">Unsubscribe Requests</span>
                                          </div>
                                          <div class="actions">
                                              <div class="btn-group btn-group-devided">
                                                   <a href="/admin/resturant_unsubscribe">
                                                   <label class="btn blue btn-outline btn-circle btn-sm active">
                                                     View All</label></a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="portlet-body">
                                          <div class="tab-content">
                                              <div class="tab-pane active" id="portlet_comments_1">
                                                  <!-- BEGIN: Comments -->
                                                  <?php $i=0; ?>
                                                  @foreach($resturantsub_all as $rest)
                                                       <?php $i++; 
                                                      if($i>6)
                                                       break; 
                                                  ?>
                                        
                                                  <div class="mt-comments">
                                                      <div class="mt-comment">
                                                          <div class="mt-comment-body">
                                                              <div class="mt-comment-info">
                                                              <span class="mt-comment-author">{{ $rest->user_name }}</span>
                                                                  <span class="mt-comment-date"> {{ date('d/m/Y',strtotime($rest->created_at)) }}</span>
                                                              </div>
                                                              <div class="mt-comment-text"> {{ $rest->reason }}</div>
                                                             <div class="mt-action-buttons pull-right ">
                                                                      <div class="btn-group btn-group-circle">
                                                                          <a href="/admin/unsub_rest/{{ $rest->username }}"><button type="button" class="btn btn-outline blue btn-sm">Approve</button></a>
                                                                      </div>
                                                                  </div>     
                                                          </div>
                                                      </div>
                                                  </div>
                                                  @endforeach
                                                  <!-- END: Comments -->
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                            
                          </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                               <div class="portlet light bordered">
                                      <div class="portlet-title tabbable-line">
                                          <div class="caption">
                                              <i class="icon-bubbles font-dark hide"></i>
                                              <span class="caption-subject font-dark bold uppercase">Restaurant List</span>
                                          </div>
                                          <div class="actions">
                                              <div class="btn-group btn-group-devided">
                                                   <a href="/admin/resturant">
                                                   <label class="btn blue btn-outline btn-circle btn-sm active">
                                                     View All</label></a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="portlet-body">
                                          <div class="tab-content">
                                              <div class="tab-pane active" id="portlet_comments_1">
                                                  <div class="table-scrollable">
                                                  <!-- BEGIN: Comments -->
                                                  <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                          <th>Name</th>
                                                          <th>City</th>
                                                          <th>Food Type</th>
                                                          <th>E-Mail</th>
                                                          <th>Phone</th>
                                                          <th></th>
                                                       </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i=0; ?>
                                                          @foreach($resturant_all as $rest)
                                                         <tr>
                                                          <td>{{ $rest->rest_name }}</td>
                                                          <td>{{ $rest->city }}</td>
                                                          <td>{{ $rest->food_name }}</td>
                                                          <td>{{ $rest->email }}</td>
                                                          <td>{{ $rest->contact_no }}</td>
                                                          <td>
                                                              <a href="/admin/resturant/{{ $rest->username }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                        @if($i>10)
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
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                              <div class="portlet light bordered">
                                      <div class="portlet-title tabbable-line">
                                          <div class="caption">
                                              <i class="icon-bubbles font-dark hide"></i>
                                              <span class="caption-subject font-dark bold uppercase">Users</span>
                                          </div>
                                          <div class="actions">
                                              <div class="btn-group btn-group-devided">
                                                   <a href="/admin/users">
                                                   <label class="btn blue btn-outline btn-circle btn-sm active">
                                                     View All</label></a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="portlet-body">
                                          <div class="tab-content">
                                              <div class="tab-pane active" id="portlet_comments_1">
                                                  <div class="table-scrollable">
                                                  <!-- BEGIN: Comments -->
                                                  <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" width="100%">
                                                      <thead>
                                                        <thead>
                                                            <tr>
                                                              <th>Name</th>
                                                              <th>City</th>
                                                              <th>E-Mail</th>
                                                              <th>Phone</th>
                                                              <th></th>
                                                           </tr>
                                                          </thead>
                                                          <tbody>
                                                              <?php $i=0; ?>
                                                              @foreach($users_all as $user)
                                                             <tr>
                                                              <td>{{ $user->name.' '.$user->last_name }}</td>
                                                              <td>{{ $user->city }}</td>
                                                              <td>{{ $user->email }}</td>
                                                              <td>{{ $user->phone }}</td>
                                                              <td>
                                                                  <a href="/admin/users/{{ $user->uniqueid }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                                                            </tr>
                                                            <?php $i++; ?>
                                                        @if($i>10)
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

                        </div>
                    
	@stop
  @section('footer')
  <script type="text/javascript">
jQuery(document).ready(function() {
      // AREA CHART
  new Morris.Area({
    element: 'morris_chart_2',
    data: [
       @if(count($userrest)>0)
      @foreach($userrest as $user)
      { m: '{{$user->month}}', a: {{$user->user}}, b: {{$user->resturant}} },
      @endforeach
      @else
      { m: {{date('m')}}, a: 0, b: 0 },
      @endif
     
    ],
    xkey: 'm',
    ykeys: ['a', 'b'],
    labels: ['User', 'Restaurant']
  });

});
  </script>
  @stop