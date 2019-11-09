@extends('layouts/admin_layout')
@section('page_title')
NewsLetter List
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Newsletter Subscribers</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Newsletter Subscribers
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
  
     
    <!-- .row -->
   <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-globe"></i>Newsletter Subscriptions</div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>E-Mail</th>
                    <th>Joined On</th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($usersall as $user)
                   <?php $i=$i+1; ?>
                   <tr>
                     <td>{{ $i }}</td>
                     <td>{{ $user->email }}</td>
                    <td>{{ date('d/m/Y',strtotime($user->created_at)) }}</td>
                   </tr>
                    @endforeach
                    
                </tbody>
              </table>
        </div>
      </div>
    <!-- /.row -->
@stop
