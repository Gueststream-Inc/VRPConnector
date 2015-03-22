jQuery(document).ready(function(){
    jQuery('#vpr-list').click(function(e) {
        e.preventDefault();
        jQuery('.list-grid-layout').attr('class', 'col-xs-12 list-grid-layout vpr-list-style');
    });
    jQuery('#vpr-grid').click(function(e){
        e.preventDefault();
        jQuery('.list-grid-layout').attr('class', 'col-md-4 col-xs-6 col-sm-12 vpr-list-grid-layout vpr-grid-style');
    });

    // Unit Page Tabs
    unitTabs = jQuery("#tabs").tabs();

    // Allow outside links to open tabs
    jQuery('.open-tab').click(function (event) {
        var tab = jQuery(this).attr('href');
        unitTabs.tabs("load",2);
    });

    // Unit Page photo gallery
    jQuery('#gallery .thumb').click(function () {
        var photoid = jQuery(this).attr('id');
        var showImage = "#full"+photoid;
        jQuery("#photo img").hide();
        jQuery("#photo "+showImage).show();
    });

    jQuery(".vrpsorter").change(function(){
        var url=jQuery(this).val();
        window.location=url;
    });

    var inquireopen=false;

    jQuery("#inline").click(function(){
        if (inquireopen == false){
            jQuery("#pinquire").slideDown();
            inquireopen=true;
        }else{
            jQuery("#pinquire").slideUp();
            inquireopen=false;
        }
    });

    jQuery("#vrpinquire").submit(function(){
        jQuery("#iqbtn").attr("disabled","disabled");
        jQuery.post("/?vrpjax=1&act=custompost&par=addinquiry",jQuery(this).serialize(),function(data){
            var obj=jQuery.parseJSON(data);
            if (obj.success){
                jQuery("#vrpinquire").replaceWith("Thank you for your inquiry!");
            }else{
                var item;
                var thetotal=obj.err.length - 1;
                for(i=0;i<=thetotal;i++){
                    item=obj.err[i];
                    /// alert(item.name);
                    jQuery("#i" + item.name).append("<span class='errormsg'>" + item.msg + "</span>");
                }
                jQuery("#iqbtn").removeAttr("disabled");
            }
        });
        return false;
    });

    var oldcolor="";

    var dates = jQuery( "#arrival, #depart" ).datepicker({
        minDate: 2,
        //showOn: "both",
        //buttonImage: "/wp-content/plugins/VRPAPI/themes/mountainsunset/images/cal.jpg",
        //buttonImageOnly: true,

        onSelect: function( selectedDate ) {
            var option = this.id == "arrival" ? "minDate" : "30",
                instance = jQuery( this ).data( "datepicker" ),
                date = jQuery.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
            if (jQuery("#depart").val() != ''){
                var arrivalDate=jQuery("#arrival").datepicker("getDate");
                var departureDate=jQuery("#depart").datepicker("getDate");
                var oneDay = 1000*60*60*24;

                var difference = Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay);
                //alert(difference);
                difference=-difference;

                jQuery("#nights").val(difference);
                jQuery("#tn").val(difference);
            }
        }
    });

    var dates2 = jQuery( "#arrival2, #depart2" ).datepicker({
        minDate: 2,
        showOn: "both",
        buttonImage: url_paths.plugin_url + "/themes/mountainsunset/images/cal.jpg",
        buttonImageOnly: true,
        onSelect: function( selectedDate ) {
            var option = this.id == "arrival2" ? "minDate" : "30",
                instance = jQuery( this ).data( "datepicker" ),
                date = jQuery.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates2.not( this ).datepicker( "option", option, date );
            if (jQuery("#depart2").val() != ''){
                var arrivalDate=jQuery("#arrival2").datepicker("getDate");
                var departureDate=jQuery("#depart2").datepicker("getDate");
                var oneDay = 1000*60*60*24;
            }
        }
    });

    if (jQuery("#featuredimg").length > 0){
        jQuery.getJSON('/?featuredunit=1', function(data) {

            var href="/vrp/unit/" + data.page_slug + "/";
            jQuery("#featuredhref").attr("href",href);
            jQuery("#featuredimg").attr("src",data.Photo);
            jQuery("#featuredName").html(data.Name);
            jQuery("#loadingimg").fadeOut(500,function(){
                jQuery("#featuredunit").fadeIn(500);
            });
        });
    }

    jQuery(".nextfeatured").click(function(){
        jQuery("#featuredunit").fadeOut(500,function(){
            jQuery("#loadingimg").fadeIn(500);
        });

        jQuery.getJSON('/?featuredunit=1', function(data) {
            var href="/vrp/unit/" + data.page_slug + "/";
            jQuery("#featuredimg").attr("src",data.Photo);
            jQuery("#featuredhref").attr("href",href);
            jQuery("#featuredName").html(data.Name);
            jQuery("#loadingimg").fadeOut(500,function(){
                jQuery("#featuredunit").fadeIn(500);
            });

        });
        return false;
    });

    jQuery("#bookmsg").hide();

    jQuery("#checkbutton").click(function (){
        checkavailability();
    });

    if (jQuery("#datespicked").length > 0){
        checkavailability();
    }

    jQuery("#selectnewdates").click(function(){
        jQuery("#datespicked,#orselect").slideUp();
        jQuery("#checkavailbox").slideDown();
        return false;
    });

    jQuery("#showchange").click(function(){
        jQuery("#emailbox").show();
        jQuery("#emailaddress,#changelink").hide();
        jQuery("#passwordbox").slideDown();
        return false;
    });

    jQuery("#newuserbox").height(jQuery("#returnbox").height());

    jQuery("#packagesform").submit(function(){
        return false;
    });

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

    if (jQuery("#packagesform").length > 0){
        jQuery.get("/?vrpjax=1&act=addtopackage",jQuery("#packagesform").serialize(),function(data){
            var obj=jQuery.parseJSON(data);
            jQuery("#packageinfo,.addontotal").html(obj.packagecost).fadeIn(1000);
            jQuery("#TotalCost").html(obj.TotalCost).fadeIn(1000);
            jQuery("#TotalCost2").html(obj.TotalCost).fadeIn(1000);
        });
    }

    jQuery("#packagesform").submit(function(){
        jQuery.get("/?vrpjax=1&act=addtopackage",jQuery(this).serialize(),function(data){
            var obj=jQuery.parseJSON(data);
            jQuery("#packageinfo,.addontotal").html(obj.packagecost).fadeIn(1000);
            jQuery("#TotalCost").html(obj.TotalCost).fadeIn(1000);
            jQuery("#TotalCost2").html(obj.TotalCost).fadeIn(1000);
        });
        return false;
    });

    jQuery(".continuebtn").click(function(){
        jQuery.get("/?vrpjax=1&act=addtopackage",jQuery("#packagesform").serialize(),function(data){
            var obj=jQuery.parseJSON(data);
            jQuery("#packageinfo,.addontotal").html(obj.packagecost).fadeIn(1000);
            jQuery("#TotalCost").html(obj.TotalCost).fadeIn(1000);
            window.location=jQuery(".continuebtn").attr('href');
        });

        return false;
    });

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
            console.log(data);
            var obj=jQuery.parseJSON(data);
            //alert(obj.Bad);
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

    jQuery(".dpinquiry").datepicker();

    jQuery(".vrp-pagination li a,.dobutton").button();

    // Unit Compare

    jQuery(".compareit").click(function(){
        var id=jQuery(this).attr("rel");
        jQuery("#comparison").load("/?addcompare=1&id=" + id,function(){
            jQuery("#comparecount").load("/?comparecount=1");
        });
        jQuery("#cpr_" + id).show();
        jQuery("#cpc_" + id).hide();
        return false;
    });

    jQuery(".compareremove").click(function(){
        var id=jQuery(this).attr("rel");

        jQuery("#comparison").load("/?addcompare=1&remove=1&id=" + id,function(){
            jQuery("#comparecount").load("/?comparecount=1");
        });
        jQuery("#cpc_" + id).show();
        jQuery("#cpr_" + id).hide();

        return false;
    });

    jQuery("#sharethecompare").click(function(){
        jQuery('#sharingcompare').load("/?savecompare=1",function(d){
            jQuery(this).slideDown();
        });
        return false;
    });

    if(jQuery('.vrp-favorite-button').length) {
        jQuery.getJSON('/vrp/favorites/json').done(function (data) {
            console.log(data);
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

        jQuery('.vrp-favorite-button').on('click',function () {
            var fav_button = jQuery(this);
            var unit_id = fav_button.data('unit');
            if(fav_button.data('isFavorite') == true) {
                // Remove existing favorite
                jQuery.get('/vrp/favorites/remove',{unit: unit_id}).done(function () {
                    fav_button.html('Add to Favorites');
                    fav_button.data('isFavorite',false);
                    jQuery('#favorite_'+unit_id).hide();
                });
            } else {
                // Add unit to favorites.
                jQuery.get('/vrp/favorites/add',{unit: unit_id}).done(function () {
                    fav_button.html('Remove from Favorites');
                    fav_button.data('isFavorite',true);
                });
            }
        });
    }

    //alert(url_paths.site_url);
    //alert(url_paths.stylesheet_dir_url);
    //alert(url_paths.plugin_url);
});

function checkavailability(){
    if (jQuery("#arrival2").val() == ''){
        return false;
    }
    jQuery("#ures").fadeIn();
    jQuery("#errormsg").html('');
    jQuery("#booklink").hide();
    jQuery("#loadingicons").show();
    jQuery.get("/?vrpjax=1&act=checkavailability&par=1",jQuery("#bookingform").serialize(),function(data){
        var obj=jQuery.parseJSON(data);
        console.log(obj);
        if (!obj.Error){
            jQuery("#loadingicons").hide();
            //jQuery("#totalcost").html(obj.TotalWithoutInsurance);
            jQuery("#thetotal,#booklink").fadeIn();
            ratebreakdown(obj);
            jQuery("#checkbutton").fadeTo(500,0.5);
            jQuery(".unitsearch").change(function(){
                //jQuery("#booklink").hide();
                jQuery("#errormsg").html('').hide();
                jQuery("#checkbutton").fadeTo(500,1);
            });
        }else{
            jQuery("#loadingicons").hide();
            var theerror='<div class="alert alert-error">' + obj.Error + '</div>';
            jQuery("#errormsg").html(theerror);
        }
    });
}
function ratebreakdown(obj) {
    var tbl = jQuery("#ratebreakdown");
    console.log(obj);
    tbl.empty();
    for (var i in obj.Charges) {
        var row = "<tr><td>" + obj.Charges[i].Description + "</td><td>$" + obj.Charges[i].Amount + "</td></tr>";
        tbl.append(row);
    }
    if (obj.HasInsurance && obj.HasInsurance == 1) {
        var row = "<tr><td>Insurance</td><td>$" + obj.InsuranceAmount + "</td></tr>";
        tbl.append(row);
    }
    var tax = "<tr><td>Tax:</td><td>$" + obj.TotalTax + "</td></tr>";
    var total = "<tr><td><b>Total Cost:</b></td><td><b>$" + obj.TotalCost + "</b></td></tr>";
    var totaldue = "<tr class='success'><td><b>Total Due Now:</b></td><td><b>$" + obj.DueToday + "</b></td></tr>";

    tbl.append(tax);
    tbl.append(total);
    tbl.append(totaldue);
}
