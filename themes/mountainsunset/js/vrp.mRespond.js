;var VRP = Object.create(null);

VRP.mRespond = (function($, global){

    var responseActive = false;
    var initializedWidth = 0;

    $(function(){

        initializedWidth = $('#vrp').width();
        resizeHandler();

    });

    var resizeHandler = function() {
        if(initializedWidth <= 660) {

            responseActive = true;
            $('.vrp-item-wrap').removeClass('vrp-col-md-4 vrp-col-sm-6').addClass('vrp-col-md-6 vrp-col-sm-12');
            $('.vrp-favorite-action').removeClass('vrp-col-md-3').addClass('vrp-col-md-5');
            $('.vrp-filter-result-handles').removeClass('vrp-col-md-9').addClass('vrp-col-md-7');
            $('#vrp-list, #vrp-grid').hide();
            $("#vrpresults").fadeIn();

        } else {

            $("#vrpresults").fadeIn();

        }
    };

    return {

    }

}(jQuery, window, undefined));