/**
 * Barefoot PMS Checkout Script.
 */

jQuery(document).ready(function() {

    // Booking Add-ons
    var bookingAddonCheckboxes = jQuery('input.vrp-booking-addon[type=checkbox]');
    var lease_id = jQuery('#vrp-booking-leaseid').val();

    bookingAddonCheckboxes.on('change', function() {
        // Selecting or de-selecting an add-on.

        var quoteUpdateRequest = {
            action: 'vrp_barefoot_update_quote_addons',
            nonce: url_paths.nonce,
            lease_id: lease_id,
            selected_addons: [],
            waived_addons: []
        };

        bookingAddonCheckboxes.each(function(i, element) {
            if (jQuery(element).is(':checked')) {
                // Add each selected add-on to our quote update request.
                quoteUpdateRequest.selected_addons.push(jQuery(element).val());
            } else {
                quoteUpdateRequest.waived_addons.push(jQuery(element).val());
            }
        });

        jQuery.ajax({
            method: 'POST',
            url: url_paths.ajaxurl,
            data: quoteUpdateRequest
        }).done(function(data) {
            // Update the displayed quote breakdown.
            ratebreakdown(data);
        });
    });
});
