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
 var fav_count='';
jQuery(document).ready(function(){
if(jQuery( 'input[name="search[arrival]"]' ).length>0) {
    var dates = jQuery('input[name="search[arrival]"]' ).datepicker({
        beforeShow: customRange,
        minDate: 2,
        onSelect: function (selectedDate) {

            var option = this.id == "arrival" ? "minDate" : "30",
                instance = jQuery(this).data("datepicker"),
                date = jQuery.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        },
        onClose: function () {
            var departField = jQuery('input[name="search[departure]"]');
            var nextDayDate = jQuery('input[name="search[arrival]"]').datepicker('getDate');
            if (nextDayDate !== null) {
                nextDayDate.setDate(nextDayDate.getDate() + 7);
                departField.datepicker('setDate', nextDayDate);
                setTimeout(function () {
                    departField.datepicker("show");
                }, 10);
            }
        }


    });


    jQuery('input[name="search[departure]"]').datepicker({
         beforeShow: customRange,
        onSelect: function () {
            var arrivalDate=jQuery('input[name="search[arrival]"]').datepicker("getDate");
            var departureDate=jQuery('input[name="search[departure]"]').datepicker("getDate");
            var oneDay = 1000*60*60*24;
            var difference = Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay);
            difference=-difference;

            jQuery("#nights").val(difference);
            jQuery("#tn").val(difference);
        }
    });
}
    function customRange(a) {
        var b = new Date();
        var c = new Date(b.getFullYear(), b.getMonth(), b.getDate());
        if (a.id == 'depart') {
            if (jQuery('input[name="search[arrival]"]').datepicker('getDate') != null) {
                c = jQuery('input[name="search[arrival]"]').datepicker('getDate');
            }
        }
        return {
            minDate: c
        }
    }

    jQuery('.hasDatepicker').attr("autocomplete", "off").attr("readonly", "readonly");

    jQuery("#bookmsg").hide();

    if (jQuery("#unitsincomplex").length > 0){
        if (jQuery("#hassession").length > 0){
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).fadeIn();
            });
        }else{
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform2").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).fadeIn();
            });
        }
        jQuery("#jaxform").submit(function(){
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).slideDown(1000);
            });
            return false;
        });

        jQuery("#showallofthem").click(function(){
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform2").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).slideDown(1000);
            });
            return false;
        });
    }


    /** Step3.php **/
    jQuery("#country").on('change', function(){
      var country =jQuery(this).find(":selected").val();
if (country == 'CA' || country == 'US' || country == 'other'){
            if (country == 'CA'){

                jQuery("#state").val('');
                jQuery("#provincetr").show();
                jQuery("#provincetr").effect("highlight", {}, 2000);
                jQuery("#othertr,#regiontr,#statetr").hide();
            }

            if (country == 'US'){
                jQuery("#province,#region").val('');
                jQuery("#statetr").show();
                jQuery("#statetr").effect("highlight", {}, 2000);
                jQuery("#othertr,#regiontr,#provincetr").hide();
            }

            if (country == 'other'){
                jQuery("#province,#state").val('');
                jQuery("#provincetr,#statetr").hide();
                jQuery("#othertr,#regiontr").show();
                jQuery("#othertr,#regiontr").effect("highlight", {}, 2000);
            }
        }else{
            jQuery("#province,#state").val('');
            jQuery("#provincetr,#statetr,#othertr").hide();
            jQuery("#regiontr").show();
            jQuery("#regiontr").effect("highlight", {}, 2000);
        }

    });

    jQuery("#vrpbookform").submit(function(){
        jQuery("#bookingbuttonvrp").hide();
        jQuery("#vrploadinggif").show();
        jQuery("span.vrpmsg").remove();
        jQuery(".badfields").removeClass("badfields");
        jQuery("#comments").val(jQuery("#comments").val());
        jQuery.post(url_paths.site_url + "/?vrpjax=1&act=processbooking",jQuery(this).serialize(),function(data){

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
        	var c=0;
             for(var i=0; i<data.length; i++){
             	if(data[i] != 0){
             		c++;
             	}
             }

            jQuery('.vrp-favorite-button').each(function () {
                var fav_button = jQuery(this);
                var unit_id = fav_button.data('unit');
                var is_favorite = jQuery.inArray(unit_id,data);

                if(is_favorite != -1) {
                    if ( fav_button.is( ".vrp-favorite-button.button"  )  ) {
                      fav_button.html('Remove from Favorites');

                     }
                    fav_button.addClass('active-fav');
                     fav_button.removeClass('add-favorite');
                    fav_button.data('isFavorite',true);




                } else {
                 if ( fav_button.is( ".vrp-favorite-button.button"  )  ) {
                     fav_button.html('Add to Favorites');
                    }
                    fav_button.removeClass('active-fav');
                    fav_button.addClass('add-favorite');
                    fav_button.data('isFavorite',false);
                }

                fav_button.show();
            });
        });

        jQuery('.vrp-favorite-button').on('click',function () {

            var fav_button = jQuery(this);
            var unit_id = fav_button.data('unit');
            if(fav_button.data('isFavorite') == true) {
                // Remove existing favorite
                jQuery.get(url_paths.site_url + '/vrp/favorites/remove',{unit: unit_id}).done(function () {
                    fav_button.removeClass('active-fav');
                    fav_button.addClass('add-favorite');
                    fav_button.data('isFavorite',false);
                    if ( fav_button.is( ".vrp-favorite-button.button"  )  ) {
                     fav_button.html('Add to Favorites');
                     jQuery('#favorite_'+unit_id).hide();
                     }
                      jQuery('#fav-counter').val( function(i, oldval) {
                        return --oldval;



                    });

                       jQuery('#menu-item-6560 a').not(":has(input)").append('<input id="fav-counter" type="hidden" readonly name="counter" value="">');

                      if (jQuery('#fav-counter').val()=='0') {
                        jQuery('#fav-counter').attr('type', 'hidden');
                      } else {
                     jQuery('#fav-counter').removeAttr('type');
                      }

                       fav_count-1;
                });
            } else {
                // Add unit to favorites.
                jQuery.get(url_paths.site_url + '/vrp/favorites/add',{unit: unit_id}).done(function () {

                if ( fav_button.is( ".vrp-favorite-button.button"  )  ) {
                      fav_button.html('Remove from Favorites');
                    }
                    fav_button.addClass('active-fav');
                    fav_button.removeClass('add-favorite');
                    fav_button.data('isFavorite',true);
                      jQuery('#fav-counter').val( function(i, oldval) {
                        return ++oldval;


                    });

                    if (jQuery('#fav-counter').val()=='0') {
                        jQuery('#fav-counter').attr('type', 'hidden');
                      } else {
                      jQuery('#fav-counter').removeAttr('type');
                      }

                       fav_count+1;
                });
            }
        });

    }
});

