<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Admin | @yield('page_title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
         <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
          <link href="/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        
        <link href="/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
        <link href="/assets/pages/css/blog.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
       <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
   @if(Auth::check())
     @else
     <script>
       $(window).load(function(){
          $(location).attr('href',"/login");
      });
      </script>

    @endif

         </head>
    <!-- END HEAD -->
  <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="/">
                           <h3 style="color:#fff;margin-top:10px;"> Club Sip </h3></a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                             <li class="dropdown">
                                <a href="/admin/notifications" class="dropdown-toggle">
                                    <i class="icon-bell"></i>
                                    @if($analytic[0]->notifications>0)<span class="badge badge-default"> {{$analytic[0]->notifications}} </span>@endif
                                </a>
                            </li>
                           <!--  <li class="dropdown">
                                <a href="/admin/notifications" class="dropdown-toggle">
                                    <i class="icon-bell"></i>
                                </a>
                            </li> -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="/assets/layouts/layout/img/avatar.png" />
                                    <span class="username username-hide-on-mobile"> {{Auth::user()->name}} </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <!-- <li>
                                        <a href="/admin/messages_received">
                                            <i class="icon-envelope-open"></i> My Inbox
                                        </a>
                                    </li> -->
                                     <li><a href="/admin/change_pwd"><i class="icon-key"></i>  Change Password</a></li>
                                     <li class="divider"> </li>
                                    <li>
                                        <a href="/logout">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown">
                                <a href="/logout">
                                    <i class="icon-logout"></i>
                                </a>
                            </li>
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px"
                        id="side-menu">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                             <li class="nav-item start"  id="0">
                                <a href="/admin" class="nav-link">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                </a>
                          </li> 
                          <li class="nav-item" id="1"> 
                          <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-cutlery"></i>
                                    <span class="title">Manage Restaurants</span>
                                    <span class="arrow"></span>
                                </a>
                               <ul class="sub-menu">
                               
                                  <li  class="nav-item  " id="1_0"> <a href="/admin/resturant"  class="nav-link "><span class="title">Restaurant</span></a></li>
                                  <li  class="nav-item  " id="1_4"> <a href="/admin/resturant/add"  class="nav-link "><span class="title">Add New Restaurant</span></a></li>
                                  <li  class="nav-item  " id="1_1"> <a href="/admin/resturant_images"  class="nav-link "><span class="title">Restaurant Images</span></a></li>
                                  <li  class="nav-item  " id="1_2"> <a href="/admin/resturant_menu"  class="nav-link "><span class="title">Restaurant Menu</span></a></li>
                                  <li  class="nav-item  " id="1_3"> <a href="/admin/resturant_unsubscribe"  class="nav-link "><span class="title">Unsubscribe Requests</span></a></li>
                                                                                           

                             </ul>
                          </li>
                          <li class="nav-item" id="2"> 
                          <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-users"></i>
                                    <span class="title">Manage User</span>
                                    <span class="arrow"></span>
                                </a>
                               <ul class="sub-menu">
                               
                                  <li  class="nav-item  " id="2_0"> <a href="/admin/users"  class="nav-link "><span class="title">Users</span></a></li>
                                  <li  class="nav-item  " id="2_1"> <a href="/admin/users/add"  class="nav-link "><span class="title">Add New User</span></a></li>
                                                                                                                           

                             </ul>
                          </li>
                        
                          <li class="nav-item"   id="5"> 
                          <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-cogs"></i>
                                    <span class="title">Masters</span>
                                    <span class="arrow"></span>
                                </a>
                               <ul class="sub-menu">
                               
                                  <li  class="nav-item  " id="5_0"> <a href="/admin/foodtype"  class="nav-link "><span class="title">Food Type</span></a></li>
                                  <li  class="nav-item  " id="5_1"> <a href="/admin/offers"  class="nav-link "><span class="title">Offers</span></a></li>
                                  <li  class="nav-item  " id="5_2"> <a href="/admin/offercode"  class="nav-link "><span class="title">Offer Codes</span></a></li>
                                 
                             </ul>
                          </li>
                        


                           <li class="nav-item"  id="7">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-bar-chart"></i>
                                    <span class="title">Reports</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  " id="7_0"><a href="/admin/useroffer" class="nav-link "><span class="title">Restaurant Wise Coupons</span></a></li>
                                    <li class="nav-item  " id="7_1"><a href="/admin/restoffer" class="nav-link "><span class="title">User Wise Coupons</span></a></li>
                                    <li class="nav-item  " id="7_2"><a href="/admin/newsletter" class="nav-link "><span class="title">Newsletter</span></a></li>
                                </ul>
                            </li>
                    
                            
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                 <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                     @yield('content')
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> <?php echo date('Y'); ?> &copy; 
                    <a target="_blank" href="/">Club Sip &amp; Savour</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<script src="/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
       <script src="/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
         <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
      
        <script src="/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
           <script src="/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
      
           <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
       
         <script src="/assets/pages/scripts/table-datatables-responsive.js" type="text/javascript"></script>
        
         <script src="/assets/pages/scripts/components-editors.js" type="text/javascript"></script>
        <script src="/assets/pages/scripts/components-bootstrap-tagsinput.js" type="text/javascript"></script>
        <script src="/assets/pages/scripts/ui-tree.js" type="text/javascript"></script>
        <script src="/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
            <link rel="stylesheet" href="/assets/css/validationEngine.jquery.css" type="text/css"/>
        <link rel="stylesheet" href="/assets/css/template.css" type="text/css"/>
        <script src="/assets/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="/assets/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    
   
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        {!! Html::script('/assets/js/main.js') !!}
 
        <!-- END THEME LAYOUT SCRIPTS -->
        
    </body>

@if(Session::has('message') || Session::has('error') || count($errors) > 0)

 <!-- Display Validation Errors -->
  @include('common.errors')
<!-- Display Validation Errors -->
  @include('common.success')
@endif    
    </body>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("form").validationEngine();
        });
    </script>
   @if(Session::has('error') || count($errors) > 0)
    <script type="text/javascript">
       $(window).load(function(){
            $('#error').modal('show');
        });
    </script>
  @endif
  @if(Session::has('message'))
    <script type="text/javascript">
       $(window).load(function(){
            $('#success').modal('show');
        });
    </script>
  @endif
<style type="text/css">
  #side-menu li{display:none}
    
</style>
   <script type="text/javascript">
     var _p ='<?php echo $rightsall; ?>';
      if (_p.toString() == "all") {
          $('#side-menu li').css('display', 'block');
      }
      else {
          var _obj_1 = $.parseJSON(_p);
          console.log(_obj_1);

          try {
              $.each(_obj_1, function(i, item) {
                  $('#side-menu > li').each(function() {
                      // get the id attribute value
                      var _id = $(this).attr('id');

                      if (_id == i) {
                          if ($(this).children().length > 0) {
                              // now we need to check is there any sub-menu in the obj by checking 
                              // that is it contains the object or not
                              if (typeof item === 'object') {
                                  $.each(item, function(j, _item) {
                                      $('#side-menu > li  ul > li').each(function() {
                                          var _id_inner = $(this).attr('id');

                                          if (_id_inner == j) {
                                              $(this).css('display', 'block');
                                              return false;
                                          }
                                          else {

                                          }
                                      });
                                  });
                              }
                              else {

                              }

                          }
                          else {

                          }
                          $(this).css('display', 'block');
                          return false;

                      }
                      else {

                      }
                  });
              });

          }
          catch (e) {
              // alert(e);
              console.log(e);
          }

      }
</script>

  @yield('footer')
 
</html>