;VRP.ui = (function($, global, undefined){

    var triggerOverlayAction = function(overlay) {

        if(overlay.is(':visible') == false) {
            overlay.fadeIn('fast');
        } else {
            overlay.hide();
        }

    }

    var requestListingOverlayAction = function (handle, index, e) {

        var overlay = handle.find('.vrp-overlay');

        overlay.css({left: handle.width(), top: 0});
    }

    return {
        'overlay': function(handle, index, e) {
            requestListingOverlayAction(handle, index, e);
        }
    }

}(jQuery, window));