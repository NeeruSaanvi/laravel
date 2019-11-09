 $(document).ready(function () {
  $('[placeholder]').focus(function() {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
  }).blur(function() {
      $(this).attr('placeholder', $(this).attr('data-text'));
      $(this).attr('data-text', '');
  });

});

$(document).on('click','a .fa-trash',function(e){
        e.preventDefault();
        var link=$(this).parent().attr('href');
        var r = confirm("Are you sure?");
        if (r == true) {
           window.location.href = link;
        } 
    });
$(document).on('click','a.redeem',function(e){
        e.preventDefault();
        var link=$(this).attr('href');
        var r = confirm("Are you sure?");
        if (r == true) {
           window.location.href = link;
        } 
    });


 $('body').on('change', 'select.country', function() {
      var select=$(this).parent().parent().next('div').find('select.state');
      $.get("/ajaxstates?country="+$(this).val(), function(data){
            // Display the returned data in browser
            select.html(data);
      });
    });
  
 $('body').on('change', 'select.category', function() {
      var select=$(this).parent().parent().next('div').find('select.subcategory');
      $.get("/ajaxsubcategory?category="+$(this).val(), function(data){
            // Display the returned data in browser
            select.html(data);
      });
    });
  
 
$(function(){
    var current = location.pathname;
    $('.page-sidebar-menu li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href')==current){
            $this.parent().addClass('open active');
            $this.parent().parent().parent().addClass('open active');
       }
    })
});

