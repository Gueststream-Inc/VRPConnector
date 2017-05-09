<?php
/**
 * VRP Search Form Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */

global $vrp;

$sleeps=esc_attr( $vrp->search->sleeps);
$searchoptions=$vrp->searchoptions();


?>


<div id="vrp-search-form" class="search-container">

    <form id="vrp-searchbox-form" method="GET" action="<?php bloginfo('url'); ?>/vrp/search/results/" method="get">


       
            <input type="text" id="arrival" name="search[arrival]" class="vrp-form-control" tabindex="1" placeholder="Check In" value="">
        
     
            <input type="text" id="depart" name="search[departure]" class="vrp-form-control" tabindex="2" placeholder="Check Out"  value="" >
        


        <select class="select-lg vrp-form-control is-default" tabindex="3" name="search[sleeps]" id="gssleeps">
            <option selected="selected" value="">Guests</option>
            <?php $s = 1;?>
            <?php foreach (range(1,($searchoptions->maxsleeps)) as $v) {
                $sel = "";
                if ($sleeps == $v && $sleeps>0) {
                    $sel = "selected=\"selected\"";
                }
                ?>
                <option value="<?= $v; ?>" <?php echo $sel;?> ><?php echo $v; ?><?php if ($s < $searchoptions->maxsleeps) { }?></option>
                <?php
                $s++;
            } ?>
        </select>

        <?php ?>


       <input type="hidden" id="tn" value="<?= $nights; ?>"/>
        <input type="hidden" id="typefield" name="search[type]" value="">

           <input type="hidden" name="show" value="10">
            <input type="hidden" name="search[sort]" value="Name">
         <input type="hidden" name="search[order]" value="ASC">
        <div class="vrp-search-button">
            <button type="submit" name="propSearch" class="vrp-search-submit vrp-blue vrp-custom-color1" value="Search">Search</button>
       </div>
          

 
    </form>
</div>
