@extends('layouts/user_layout')
@section('page_title')
Notifications
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/user">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Notifications</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title">Notifications

  </h1>

    <!-- /.row -->
    <!-- .row -->
  <div class="portlet box blue">
      <div class="portlet-title">
        </div>
          <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
              <thead>
                  <tr>
                    <th>Date</th>
                    <th>Notification</th>
                    <th>View</th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($notifications as $notification)
                    <?php $i=$i+1; ?>
                   
                   <tr>
                    <td><a href="{{$notification->notifyurl}}" data-id='{{$notification->id}}' class="notification_btn">{{ date('d/m/Y',strtotime($notification->created_at)) }}</a></td>
                    <td><a href="{{$notification->notifyurl}}" data-id='{{$notification->id}}' class="notification_btn">{{ $notification->notification }}</a></td>
                    <td><a href="{{$notification->notifyurl}}" data-id='{{$notification->id}}' class="notification_btn"><i class="fa fa-eye"></i></a></td>
                  </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
      </div>
@stop
@section('footer')
<script type="text/javascript">
   $(document).on('click','.notification_btn',function(e){
        e.preventDefault();
           var link=$(this).attr('href');
        $.get("/notificationsview/"+$(this).attr("data-id"), function(data){
        window.location.href = link;
     
      });
    });
  </script>                
@stop