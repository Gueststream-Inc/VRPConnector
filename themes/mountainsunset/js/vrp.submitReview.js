/**
 * [vrpSubmitReview] Shortcode JavaScript
 */

jQuery(document).ready(function () {
    jQuery('#review_check_in').datepicker({});

    jQuery("#vrpSubmitReviewForm").submit(function(event){
        event.preventDefault();
        jQuery("#vrp-btn-add-review").attr("disabled","disabled");
        jQuery.post(url_paths.site_url + "/?vrpjax=1&act=addReview",jQuery(this).serialize(),function(response) {
            if(response.success == true) {
                jQuery("#vrp-add-review-success").show();
                jQuery("#vrp-add-review-form").hide();
            }
            if(response.success == false) {
                response.errors.forEach(function (element, index, array) {
                    alert(element);
                });
                jQuery("#vrp-btn-add-review").attr("disabled",false);
            }
            console.log(response);
        });
        return false;
    });
});