/**
 * [vrpSubmitReview] Shortcode JavaScript
 */
(function (jQuery) {
    'use strict';

    jQuery(document).ready(function () {
        var vrpSubmitReviewForm = jQuery("#vrpSubmitReviewForm");

        if (vrpSubmitReviewForm.length) {
            // Autocomplete Property Selection

            jQuery("#toggle").click(function () {
                jQuery("#unitId").toggle();
            });

            // Arrival Date
            jQuery("#arrivalDate").datepicker({});

            jQuery('#review_check_in').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            vrpSubmitReviewForm.submit(function (event) {

                event.preventDefault();

                jQuery("#vrp-btn-add-review").attr("disabled", "disabled");

                jQuery.post(url_paths.site_url + "/?vrpjax=1&act=addReview", jQuery(this).serialize(), function (response) {

                    if (response.success == true) {
                        jQuery("#vrp-add-review-success").show();
                        vrpSubmitReviewForm.hide();
                    }

                    if (response.success == false) {
                        response.errors.forEach(function (element, index, array) {
                            alert(element);
                        });
                        jQuery("#vrp-btn-add-review").attr("disabled", false);
                    }

                });

                return false;
            });
        }
    });

})(jQuery);