/**
 * Created by houghtelin on 4//27/16.
 */
jQuery(document).ready(function () {
    jQuery('#vrp-fav-loader').hide();
    jQuery("#resultsTabs a").click(function (event) {
        event.preventDefault();

        if (jQuery(this).attr("id") == "vrp-favorites-view") {
            jQuery(".tab-content").not('#vrp-list-fav-results').css("display", "none");
            jQuery('#vrp-fav-loader').show();
            get_favorites();
           } else {
            var tab = jQuery(this).attr("href");
            jQuery(".tab-content").not(tab).css("display", "none");

            jQuery(tab).fadeIn();
        }
        if (jQuery(this).attr("id") == "vrp-map-view") {
            jQuery("#vrp-result-list-map").css("height", "300px");
        } else {
            jQuery("#vrp-result-list-map").css("height",0)
        }
        jQuery(this).parent().addClass("current");
        jQuery(this).parent().siblings().removeClass("current");

    });

   
    function get_favorites() {

        var vrpSearchVals = jQuery('#vrp');
        var arrival = vrpSearchVals.data('vrp-arrival');
        var depart = vrpSearchVals.data('vrp-depart');
        jQuery.ajax({
            dataType: "text",
            contentType: "contentType: 'text/plain",
            url: url_paths.site_url + "/vrp/favorites/json",
            success: function (result) {
                var data = result;
                var favstring = (data).replace(/]|[[]/g, '');
                var url = url_paths.site_url + "/?vrpjax=1&act=searchjax&search[ids]=" + favstring + "&search[arrival]=" + arrival + "&search[departure]=" + depart;
                if (typeof url !== "undefined") {
                    jQuery('#vrp-list-fav-results').load(url, function (result) {
                        jQuery('#vrp-fav-loader').hide();
                        jQuery('#vrp-list-fav-results').fadeIn();

                    });
                }

            }
        });
    }

    jQuery('#vrp .add-favorite').hover(function () {
        if (jQuery(this).hasClass('add-favorite')) {
            jQuery(this).closest('.vrp-result-image-container').find('.fav-flyout').animate({width: 150}, 200);
        }

    }, function () {
        jQuery(this).closest('.vrp-result-image-container').find('.fav-flyout').animate({width: 0}, 200);
    });
});