@extends('layouts/user_layout')
@section('page_title')
Unsubscribe
@stop 

@section('content')
  <!-- BEGIN PAGE BAR -->
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <a href="/user">Dashboard</a>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>Unsubscribe</span>
          </li>
      </ul>
  </div>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> User Unsubscribe
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
    <div class="row">
     <div class="col-sm-12">
            <div class="portlet-body form">
                @if($user_all!=null)
                  <div class="form-group">
                        <label class="col-md-12" for="description">Reason</span></label>
                        <div class="col-md-12">
                            <label class="form-control" >{{$user_all->reason}}</label>
                        </div>
                    </div>
                   
                @else
                <form class="form-horizontal" method="post" action="/user">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                    <div class="form-group">
                        <label class="col-md-12" for="description">Reason</span></label>
                        <div class="col-md-12">
                            <input class="form-control validate[required]" name="reason" value="{{old('reason')?e(old('reason')):''}}" required />
                        </div>
                    </div>
                   
                    <hr>
                  
                    
                    <div class="col-sm-12 row">
                        <button type="submit" class="btn blue">Unsubscribe</button>
                    </div>
                </form>
                @endif    
            </div>
        </div>
  </div>
                    
	@stop
  @section('footer')
  @stop