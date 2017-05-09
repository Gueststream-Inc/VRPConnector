<?php
/**
 * View Favorites Template
 *
 * @package VRPConnector
 */
if ($_SESSION['arrival']) {
    $arrival=$_SESSION['arrival'];
}

if (isset($_SESSION['depart'])) {
    $depart=$_SESSION['depart'];
}

?>
<div id="vrp" class="results-action-wrap" >
          <div class="results-action-content">           
    <form id="compareprops" method="get" action="">
    
    <div class="fav-wrapper">
         <div class="advanced-search" ><input type="text" id="fav-arrival" name="search[arrival]" class="form-control input-lg" tabindex="1" placeholder="Arrive"  value="<?php echo $arrival;?>">
        
     
            <input type="text" id="fav-depart" name="search[departure]" class="form-control input-lg" tabindex="2" placeholder="Depart" value="<?php echo $depart;?>" >
             <?php foreach ($_GET['favorites'] as $v) { ?>
                 <input type="hidden" name="favorites[]" value="<?php echo esc_attr($v); ?>">
             <?php } ?>
             <div id="search-favorites">
             <input type="submit" class="fav-search vrp-blue" value="Check Availability"></div>

         </div>
            

            
       </div>
    </form>
    
</div>
  </div>


    <div class="favorites-wrapper">
     
    <?php foreach ($data->results as $prop) { ?>
    
       
      <div class="vertical-search-result" id="favorite_<?php echo $prop->id ?>">
           <div class="image-container">
               <a href="/vrp/unit/<?php echo esc_attr($prop->page_slug); ?>">
                    <img src="<?php echo esc_url($prop->Thumb); ?>" style="max-width:16em;"> </a>
           </div>
           <div class="header">
              <div class="property-name">
                      <a href="/vrp/unit/<?php echo esc_attr($prop->page_slug); ?>"> <?php echo esc_html($prop->Name); ?> </a>    
              </div>
              </div>
              <div class="detail-row"> <?php echo esc_html($prop->Bedrooms); ?> Bedrooms</div>
              <div class="detail-row"> <?php echo esc_html($prop->Bathrooms); ?> Bathrooms </div>
              <div class="detail-row"> Sleeps <?php echo esc_html($prop->Sleeps); ?>  </div>
            
                <div class="detail-row"> <?php echo esc_html($prop->Area); ?>, <?php echo esc_html($prop->Location); ?> </div> 
                
                <?php           
                       $view=$prop->attributes[0]->value;                
                ?> 
                <div class="detail-row"><?php echo esc_html($view); ?> </div>
                  <div class="detail-row avail">   <?php if ($prop->unavail != '') {
                        echo "Not Available";
                    } else {
                        echo "Available";
                    } ?>
                </div>
               <div class="detail-row padding">
                   <button class="vrp-favorite-button vrp-blue button" data-unit="<?php echo $prop->id ?>"></button></div>
               
               </div>
                <?php } ?>
               </div>
              

<div class="clear"></div>
<div style="text-align:right;">
    <small>
        * Highest Rate Shown. Not based on occupancy.
    </small>
</div>
