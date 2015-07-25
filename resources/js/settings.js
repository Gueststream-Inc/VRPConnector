(function($, global, undefined){
    /* Handles */
    $(function() {
        $("div[data-list-name='documentation-list'] > a.list-group-item").click(function(){
            $("div[data-list-name='documentation-list']").children().removeClass('active');
            $(this).addClass('active');
        });
    });
}(jQuery, window));