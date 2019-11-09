var ComponentsBootstrapTagsinput = function() {

    var handleDemo1 = function() {
        var elt = $('#object_tagsinput');
        
        elt.tagsinput({
          itemValue: 'value',
          itemText: 'text',
        });

    }

  
    return {
        //main function to initiate the module
        init: function() {
            handleDemo1();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsBootstrapTagsinput.init();
});