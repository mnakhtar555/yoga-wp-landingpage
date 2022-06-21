
;(function($){
    //Mobile Menu Display
    $('.toggle-bt').click(function(e){
        e.preventDefault();
        
        $('#mb-show').slideToggle("slow");
    });

    AOS.init();
    
})(jQuery);