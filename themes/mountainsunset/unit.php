<?php
if (!isset($_SESSION['arrival'])) {
    $_SESSION['arrival'] = '';
}
if (!isset($_SESSION['depart'])) {
    $_SESSION['depart'] = '';
}
?>
<div class="" id="vrpcontainer">
    <div class="vrp_unit_intro">
        <div class="unit-meta-header">
            <h1 class="page-title" itemprop="headline"><?= $data->Name; ?></h1>
            <ul class="results_meta ">
                <?php if ($data->Sleeps != '' ){ ?> <li class="sleeps">Sleeps <?= $data->Sleeps; ?></li><?php } ?> 
                <?php if ($data->Bedrooms != '' ){ ?><li class="bedrooms"><?= $data->Bedrooms; ?><?php if ($data->Bedrooms == 1) { ?> Bed<span class="noroom">room</span> <?php } else { ?> Bed<span class="noroom">room</span>s <?php } ?></li><?php } ?> 
                <?php if ($data->Bathrooms != '' ){ ?> <li class="bathrooms"><?= $data->Bathrooms; ?> <?php if ($data->Bathrooms == 1) { ?> Bath<span class="noroom">room</span> <?php } else { ?> Bath<span class="noroom">room</span>s <?php } ?></li> <?php } ?> 
            </ul>
        </div>
    </div> <!-- close .vrp_unit_intro -->


        <div class="vrp_image_slider">
             
            <!-- Photo Gallery -->
            <div id="photo" class="grid_12">
                <div id="slider" class="flexslider">
                    <ul class="slides">
                    <?php
                    $count = 0;
                    foreach ($data->photos as $k => $v) {
                        $style = "";
                        if ($count > 0) {
                            $style = "";
                        }
                        ?>
                        <li>
                        <img id="full<?php echo esc_attr($v->id); ?>" alt="<?php echo esc_attr($v->caption); ?>"
                             src="<?php echo esc_url($v->url); ?>"
                             style="width:100%; <?php echo esc_attr($style); ?>"/>
                         </li>
                        <?php
                        $count ++;
                    }
                    ?>
                    </ul>
                </div>
                <div id="carousel" class="flexslider">
                    <ul class="slides"> <!--this id gets inserted in manualControls -->
                      <?php
                    $count = 0;
                    foreach ($data->photos as $k => $v) {
                        $style = "";
                        if ($count > 0) {
                            $style = "";
                        }
                        ?>
                        <li>
                        <a href="#"><img 
                             id="thumb<?php echo esc_attr($v->id); ?>" alt="<?php echo esc_attr($v->caption); ?>"
                             src="<?php echo esc_url($v->url); ?>"
                             style="width:100%; <?php echo esc_attr($style); ?>"/></a>
                         </li>
                        <?php
                        $count ++;
                    }
                    ?>
                    </ul>
                </div>
            </div>

        <br style="clear:both;" class="clearfix">

        
        </div>


        <div class="vrp_booking_box">
            <div id="checkavailbox">
                <h2 class="bookheading">Check Availability</h2>
                <div id="datespicked">
                    <form action="<?php echo esc_url(site_url('/vrp/book/step3/', 'https')); ?>"
                          method="get" id="bookingform">

                        <ul>
                            <li>
                                <ul>
                                    <li class="dates">
                                        <label for="arrival2">Arrival</label>
                                        <span class="input-group date">
                                            <input type="text" id="arrival2" name="obj[Arrival]"
                                                   class="input unitsearch"
                                                   value="<?php echo esc_attr($_SESSION['arrival']); ?>">
                                        </span>
                                    </li>
                                    <li class="dates">
                                        <label for="depart2">Departure</label>
                                        <span class="input-group date">
                                            <input type="text" id="depart2" name="obj[Departure]"
                                               class="input unitsearch"
                                               value="<?php echo esc_attr($_SESSION['depart']); ?>">
                                       </span>
                                   </li>
                               </ul>
                           </li>
                           Pick your arrival and departure dates to confirm availability.<br><br>
                            <li>
                                <input type="hidden" name="obj[PropID]"
                                       value="<?php echo esc_attr($data->id); ?>">
                                <input type="button" value="GO"
                                       class="bookingbutton rounded" id="checkbutton" style="float:right;">
                           </li>
                           <li>
                               <table>
                                    <tr id="errormsg">
                                        <td colspan="2">
                                            <div></div>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div id="ratebreakdown"></div>
                                        </td>
                                    </tr>
                                </table>
                            </li>
                           <li>
                                <button type="submit" value="Proceed with Booking" id="booklink" class="hvr-wobble-horizontal" style="display:none;text-align:right;line-height:1.25em;"/>Continue Booking <i class="fa fa-caret-right"></i>
                                </button>
                            </li>
                        </ul>

                    </form>
                </div>
            </div> <!-- close .checkavailbox --> 
        </div> <!-- close .grid_4 --> 

        <div id="tabs" style="clear:both;" class="grid_12">
                <ul>
                    <li><a href="#overview">Overview</a></li>
                    <li><a href="#calendar">Availability</a></li>
                    <li><a href="#rates">Rates</a></li>
                    <?php if (isset($data->lat) && isset($data->long)) { ?>
                        <li><a href="#gmap" id="gmaplink">Map</a></li>
                    <?php } ?>
                    <?php if (count($data->attributes) != 0) { ?>
                        <li><a href="#amenities">Amenities</a></li>
                    <?php } ?>
                    <?php if (isset($data->reviews[0])) { ?>
                        <li><a href="#reviews">Reviews</a></li>
                    <?php } ?>
                    <li><a href="#inquireform">Inquire</a></li>
                    
                </ul>

                <!-- OVERVIEW TAB -->
                <div id="overview">
                    <div class="row">
                        <h2 style="font-size: 19px !important;margin-top: -5px;">Overview:</h2>
                        <div class="grid_12">
                            <div id="description">
            <div style=""><?php echo wp_kses_post(nl2br($data->Description)); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <?php if (count($data->attributes) != 0) { ?>
                    <div id="amenities">
                        <table class="amenTable" cellspacing="0">
                            <tr>
                                <td colspan="2" class="heading"><h4>Amenities</h4></td>
                            </tr>
                            <?php foreach ($data->attributes as $amen) { ?>

                                <tr>
                                    <td class="first">
                                        <b><?php echo esc_html($amen->name); ?></b>:
                                    </td>
                                    <td> <?php echo esc_html($amen->value); ?></td>
                                </tr>

                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                <?php if (isset($data->reviews[0])) { ?>
                    <!-- REVIEWS TAB -->
                    <div id="reviews">
                        <?php if (isset($data->reviews[0])) { ?>
                            <table class="amenTable" cellspacing="0">
                                <tr>
                                    <td colspan="2" class="heading"><h4>Reviews</h4></td>
                                </tr>
                                <?php foreach ($data->reviews as $review): ?>

                                    <tr>
                                        <td class="first"><b><?php echo esc_html($amen->name); ?></b>:</td>
                                        <td> <?php echo esc_html($amen->value); ?></td>
                                        </td>
                                    </tr>
                                <?php endforeach; ?></table>
                        <?php } ?>
                    </div>
                <?php } ?>

                <!-- CALENDAR TAB -->
                <div id="calendar">
                    <div class="row">
                        <h2 style="font-size: 19px !important;margin-top: -5px;">Availability:</h2>
                        <div class="col-md-6">
                            <div id="availability" style="">
                                <?php echo wp_kses_post(vrpCalendar($data->avail)); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="rates">
                    <div class="vrpgrid_12">
                        <h2 style="font-size: 19px !important;margin-top: -5px;">Rates:</h2>
                        <?php if ( isset($data->Location) ) {
                            if ( $data->Location == "Kolea" || $data->Location == "Halii Kai" || $data->Location == "Mauna Lani Terrace") {?>
                            <h5 style="color:red;">7th Night Free with No Cleaning Fee</h5>
                            <?php }
                        } ?>
                        <?php if (count($data->rates) != 0) { ?>
                            <?php
                            $r = array();
                            foreach ($data->rates as $v) {
                                $start = date("M d, Y", strtotime($v->start_date));
                                if ($v->end_date == '2053-01-01') {
                                    $end = "Jan 01, 2053";
                                } else {
                                    $end = date("M d, Y", strtotime($v->end_date));
                                }

                                if ($v->chargebasis == 'Daily') {
                                    $r["<td style='text-align:left'>" . $start . " - " . $end . "</td>"]->daily = "$" . number_format($v->amount);
                                }
                                if ($v->chargebasis == 'Weekly') {
                                    $r["<td style='text-align:left'>" . $start . " - " . $end . "</td>"]->weekly = "$" . number_format($v->amount);
                                }
                                if ($v->chargebasis == 'Monthly') {
                                   $r["<td style='text-align:left'>" . $start . " - " . $end . "</td>"]->monthly = "$" . number_format($v->amount);
                                }
                            }
                            ?>
                            <table cellspacing="0" cellpadding="5" class="rateTable" style="">
                                <thead>
                                <tr>
                                    <th style="text-align:left;">Season</th>
                                    <th style="text-align:right;">Daily (5-6 nights)</th>
                                    <th style="text-align:right;">Daily (7+ nights)</th>
                                    <th style="text-align:right;">Daily (10+ nights)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($r as $k => $v):
                                    if ($i == 0) {
                                        $theclass = 'class="even"';
                                        $i ++;
                                    } else {

                                        $theclass = "";
                                        $i        = 0;
                                    }
                                    ?>
                                    <tr <?= $theclass; ?>>

                                        <?= $k; ?>

                                        <td style="text-align:right;"><?= $v->daily; ?></td>
                                        <td style="text-align:right;"><?= $v->weekly; ?></td>
                                        <td style="text-align:center"><?= $v->monthly; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>

                        <?php } ?>


                    </div>
                </div>

                <div id="gmap">
                    <?php if ( !$data->additonal->property_map || $data->additonal->property_map == "" ) { ?>
                        <div id="map" style="width:100%;height:500px;"></div>
                    <?php  } else { ?>
                        <div style="width:100%;height:500px;">
                            <img class="vrpgrid_12" src="<?= $data->additonal->property_map ?>" >
                        </div>
                    <?php } ?>
                </div>

                <div id="inquireform">
                    <div class="inquireform" style="overflow: auto;">
                        <div id="inquiry-form">
                            <form id="vrpinquire">
                                <input type="hidden" name="obj[unit_id]" value="<?= $data->id; ?>">
                                <ul style="max-width:400px;">
                                    <li>
                                    <h2 style="font-size: 19px !important;margin-top: -5px;">Inquire about this property:</h2>
                                    </li>
                                    <li>
                                        <label for="iname">Name*:</label>
                                        <input type="text" name="obj[name]" id="iname">
                                    </li>
                                    <li>
                                        <label for="iemail">Email*:</label>
                                        <input id="iemail" type="text" name="obj[email]">
                                    </li>
                                    <li>
                                        <label for="iphonenum">Phone Number:</label>
                                        <input type="text" id="iphonenum" name="obj[phone]">
                                    </li>
                                    <li class="dates">
                                        <label for="icheckin">Desired Check-In Date*:</label>
                                        <span class="input-group date">
                                            <input type="text" id="icheckin" name="obj[checkin]" class="input unitsearch dpinquiry" value="<?php echo esc_attr($_SESSION['arrival']); ?>" id="icheckin">
                                        </span>
                                    </li>
                                    <li>
                                        <label for="inumnights">Number of Nights*:</label>
                                        <select id="inumnights" name="obj[nights]">
                                                <?php foreach (range(3, 30) as $v): ?>
                                                    <option value="<?= $v; ?>"><?= $v; ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                    </li>
                                    <li>
                                        <label for="icomments">Comments &amp; Questions:</label>
                                        <textarea id="icomments" name="obj[comments]" style="width:100%;height:200px;letter-spacing:0.025em;line-height:1.5em;"></textarea>
                                    </li>
                                    <li style="overflow:auto;">
                                        <input style="float:right;padding:0.5em;border:none;" type="submit" value="Submit Inquiry" id="iqbtn" class="bookingbutton rounded">
                                    </li>
                                </ul>
                            </form>
                            <div class="inquireform-decoration">
                                <img id="full<?php echo esc_attr($v->id); ?>" alt="<?php echo esc_attr($v->caption); ?>" src="<?php echo esc_url($data->photos[1]->url); ?>" style="width:100%;heigh:auto;"/>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
    
</div>

<?php if ( !$data->additonal->property_map || $data->additonal->property_map == "") { ?>
    <!-- GOOGLE MAPS SCRIPT -->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
        var geocoder;
        var map;
        var query = "<?= $data->Address . " " . $data->Address2 . " " . $data->City . " " . $data->State . " " . $data->PostalCode; ?>";
        var image = '<?php bloginfo('template_directory'); ?>/images/mapicon.png';

        function initialize() {
            geocoder = new google.maps.Geocoder();
            var myOptions = {
                zoom: 13,
                <?php if(strlen($data->lat) > 0 && strlen($data->long) > 0){ ?>
                center: new google.maps.LatLng(<?= $data->lat; ?>, <?= $data->long; ?>),
                <?php } ?>
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            <?php if(strlen($data->lat) > 0 && strlen($data->long) > 0){ ?>
                var marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(<?= $data->lat; ?>, <?= $data->long; ?>)
                });
                <?php } ?>

                <?php if(strlen($data->lat) == 0 || strlen($data->long) == 0){ ?>
                codeAddress();
                <?php } ?>
        }

        function codeAddress() {
            var address = query;
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);

                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: "<?= $data->title; ?>",
                        //icon: image
                    });
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
        jQuery(document).ready(function () {
            jQuery("#gmaplink").on('click', function () {
                initialize();
            });
        });

    </script>


<?php } //endif ?> 



<script type="text/javascript">
    jQuery('#tabs').tabs();

    jQuery(window).load(function() {
      // The slider being synced must be initialized first
      jQuery('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 170,
        itemMargin: 5,
        asNavFor: '#slider'
      });
       
      jQuery('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
      });
    });

    jQuery(document).ready(function (){
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
    });




</script>

