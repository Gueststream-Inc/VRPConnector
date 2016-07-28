(function($, global, undefined){
    /* Handles */
    $(function(){

        $('.vrpshowing').change(function() {

            var that = $(this);

            if(that.val() == '') {
                return;
            }

            location.search = VRP.queryString.formatQueryString(that.val());

        });

        $('.vrpsorter').change(function() {

            var that = $(this);

            if(that.val() == '') {
                return;
            }

            location.search = VRP.queryString.formatQueryString(that.val());
        });


        $('.vrpsorter').change(function() {

            var that = $(this);

            if(that.val() == '') {
                return;
            }

            location.search = VRP.queryString.formatQueryString(that.val());
        });

        $('.vrp-cd-pagination a').click(function(e){

            e.preventDefault();

            var that = $(this),
                parameters = that.attr('href');

            if(that.hasClass('current') || that.hasClass('disabled')) {
                return;
            }

            location.search = VRP.queryString.formatQueryString(parameters);

        });

        $('.vrp-thumbnail').hover(function(e){

            var that = $(this).parent(),
                index = $('.vrp-item').index(that);

            VRP.ui.overlay(that, index, e);

        }, function(e) {

            var that = $(this).parent(),
                index = $('.vrp-item').index(that);

            VRP.ui.overlay(that, index, e);

        });

        $('#vrp-list').click(function(e) {
            e.preventDefault();
            $('.list-grid-layout').attr('class', 'col-xs-12 list-grid-layout vpr-list-style');
        });

        $('#vrp-grid').click(function(e){
            e.preventDefault();
            $('.list-grid-layout').attr('class', 'col-md-4 col-xs-6 col-sm-12 vpr-list-grid-layout vpr-grid-style');
        });

    });
}(jQuery, window));

jQuery(document).ready(function(){
    var arrivalDate, departureDate;

    departureDate = jQuery("input[name='search[departure]").datepicker({

    });

    arrivalDate = jQuery( "input[name='search[arrival]']" ).datepicker({
        minDate: 2,
        onSelect: function( selectedDate ) {
            console.log(selectedDate);
            var option = jQuery(this).is(".vrpArrivalDate") ? "minDate" : "30";
            var instance = jQuery(this).data( "datepicker" );
            var date = jQuery.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );

            departureDate.not( this ).datepicker( "option", option, date );
        }
    });



    jQuery('.hasDatepicker').attr("autocomplete", "off").attr("readonly", "readonly");

    jQuery("#bookmsg").hide();

    if (jQuery("#unitsincomplex").length > 0){
        if (jQuery("#hassession").length > 0){
            jQuery.get("/?vrpjax=1&act=searchjax",jQuery("#jaxform").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).fadeIn();
            });
        }else{
            jQuery.get("/?vrpjax=1&act=searchjax",jQuery("#jaxform2").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).fadeIn();
            });
        }
        jQuery("#jaxform").submit(function(){
            jQuery.get("/?vrpjax=1&act=searchjax",jQuery("#jaxform").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).slideDown(1000);
            });
            return false;
        });

        jQuery("#showallofthem").click(function(){
            jQuery.get("/?vrpjax=1&act=searchjax",jQuery("#jaxform2").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).slideDown(1000);
            });
            return false;
        });
    }


    /** Step3.php **/
    jQuery("#country").change(function(){
        if (jQuery(this).val() == 'CA' || jQuery(this).val() == 'US' || jQuery(this).val() == 'other'){
            if (jQuery(this).val() == 'CA'){
                jQuery("#state").val('');
                jQuery("#provincetr").effect("highlight", {}, 2000);
                jQuery("#othertr,#regiontr,#statetr").hide();
            }

            if (jQuery(this).val() == 'US'){
                jQuery("#province,#region").val('');
                jQuery("#statetr").effect("highlight", {}, 2000);
                jQuery("#othertr,#regiontr,#provincetr").hide();
            }

            if (jQuery(this).val() == 'other'){
                jQuery("#province,#state").val('');
                jQuery("#provincetr,#statetr").hide();
                jQuery("#othertr,#regiontr").effect("highlight", {}, 2000);
            }
        }else{
            jQuery("#province,#state").val('');
            jQuery("#provincetr,#statetr,#othertr").hide();
            jQuery("#regiontr").effect("highlight", {}, 2000);
        }

    });

    jQuery("#vrpbookform").submit(function(){
        jQuery("#bookingbuttonvrp").hide();
        jQuery("#vrploadinggif").show();
        jQuery("span.vrpmsg").remove();
        jQuery(".badfields").removeClass("badfields");
        jQuery("#comments").val(jQuery("#comments").val());
        jQuery.post("/?vrpjax=1&act=processbooking",jQuery(this).serialize(),function(data){

            var obj=jQuery.parseJSON(data);
            if (obj.Bad.length != 0){
                jQuery("#bookingbuttonvrp").show();
                jQuery("#vrploadinggif").hide();
                jQuery.each(obj.Bad,function(k,v){
                    jQuery("#" + k + "tr td:last").append('<span class="vrpmsg alert alert-error">' + v + '</span>');
                    var oldcolor=jQuery("#" + k + "tr").css("color");
                    jQuery("#" + k + "tr").addClass("badfields");
                    jQuery("#" + k).change(function(){
                        jQuery("#" + k + "tr").removeClass("badfields");
                        jQuery("#" + k + "tr td span.vrpmsg").remove();
                    });
                });
                jQuery("html, body").animate({
                    scrollTop: 0
                }, "slow",function(){});
                alert("Please correct the errors with your reservation and try again.");

            }else{
                if (obj.Error.length != 0){
                    jQuery("#bookingbuttonvrp").show();
                    jQuery("#vrploadinggif").hide();
                    alert(obj.Error);
                }else{
                    window.location=jQuery("#vrpbookform").attr("action");
                }
            }

        });

        return false;
    });

    jQuery("#showContract").on('click', function(event) {
        event.preventDefault();
        jQuery('#theContract').show();
    });

    jQuery('#closeContract').on('click', function(event) {
        event.preventDefault();
        jQuery('#theContract').hide();
    });


    /** OTHER **/
    jQuery(".dpinquiry").datepicker();

    jQuery(".vrp-pagination li a,.dobutton").button();

    if(jQuery('.vrp-favorite-button').length) {
        jQuery.getJSON(url_paths.site_url + '/vrp/favorites/json').done(function (data) {

            jQuery('.vrp-favorite-button').each(function () {
                var fav_button = jQuery(this);
                var unit_id = fav_button.data('unit');
                var is_favorite = jQuery.inArray(unit_id,data);

                if(is_favorite != -1) {
                    fav_button.html('Remove from Favorites');
                    fav_button.data('isFavorite',true);
                } else {
                    fav_button.html('Add to Favorites');
                    fav_button.data('isFavorite',false);
                }

                fav_button.show();
            });
        });

        jQuery('.vrp-favorite-button').on('click',function (event) {
            event.preventDefault();
            var fav_button = jQuery(this);
            var unit_id = fav_button.data('unit');
            if(fav_button.data('isFavorite') == true) {
                // Remove existing favorite
                jQuery.get(url_paths.site_url + '/vrp/favorites/remove',{unit: unit_id}).done(function () {
                    fav_button.html('Add to Favorites');
                    fav_button.data('isFavorite',false);
                    jQuery('#favorite_'+unit_id).hide();
                });
            } else {
                // Add unit to favorites.
                jQuery.get(url_paths.site_url + '/vrp/favorites/add',{unit: unit_id}).done(function () {
                    fav_button.html('Remove from Favorites');
                    fav_button.data('isFavorite',true);
                });
            }
        });
    }
});

