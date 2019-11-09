@extends('layouts/admin_layout')
@section('page_title')
Unsubscribe Requests
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Unsubscribe Requests
</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Unsubscribe Requests

  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
        <div class="row">
         <div class="col-sm-12">
            <div class="portlet-body form">
                <form class="form-material form-horizontal" method="get" action="/admin/resturant_unsubscribe">
                             <div class="form-actions">
                    <div class="form-group col-sm-3">
                        <label class="col-md-12" for="description">Status</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="status">
                                <option value="">Select</option>
                                <option value="Approved" {{(old('status')?e(old('status')):$status)== 'Used'?'selected':''}}>Approved</option>
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
                <i class="fa fa-globe"></i>Unsubscribe Requests
</div>
            <div class="tools"> </div>
        </div>

        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>E-Mail</th>
                    <th>Phone</th>
                    <th>Request on</th>
                    <th>Reason</th>
                    <th>Status</th>
                 </tr>
                </thead>
                <tbody>
                    @foreach($request_all as $rest)
                   <tr>
                    <td>{{ $rest->user_name }}</td>
                    <td>{{ $rest->role }}</td>
                    <td>{{ $rest->email }}</td>
                    <td>{{ $rest->phone }}</td>
                    <td>{{ date('d-m-Y H:i',strtotime($rest->created_at)) }}</td>
                    <td>{{ $rest->reason }}</td>
                    <td>
                         {{$rest->request_status}} 
                    </td>
                  </tr>
                    @endforeach
                </tbody>
              </table>
         </div> 
    </div>
@stop
