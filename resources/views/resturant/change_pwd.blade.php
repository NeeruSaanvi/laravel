@extends('layouts/resturant_layout')
@section('page_title')
Change Password
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/resturant">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Change Password</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title">Change Password

  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->

 
     <div class="row">
        <div class="col-sm-12">
          <div class="white-box">
             <form class="form-material form-horizontal" method="post" action="/resturant/change_pwd">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                <div class="form-group">
                      <label class="col-md-12" for="title">Old Password</span></label>
                      <div class="col-md-12">
                          <input type="password" placeholder="Old Password" class="form-control" name="oldpassword"
                           required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-12" for="title">New Password</span></label>
                      <div class="col-md-12">
                          <input type="password" id="password" placeholder="New Password" class="form-control validate[required,custom[password]]" name="password"
                          title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" minlength="6" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,20})"
                           required>
                      </div>
                  </div>
                   <div class="form-group">
                      <label class="col-md-12" for="title">Confirm Password</span></label>
                       <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control validate[required,equals[password]]" placeholder="Confirm New Password" name="password_confirmation"
                             title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" minlength="6" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,20})"
                            required>
                        </div>
                    </div>

                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Change Password</button>
                </form>
           </div>
        </div>
      </div>
    <!-- /.row -->
@stop