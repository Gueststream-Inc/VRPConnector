<div class="feature-inner specials">
    <?php if ( !is_page('specials') ) { ?>
    <div class="featured-headline">Specials</div>
    <?php } ?>
    <div class="featured-body special_list">
    	<?php foreach($data as $special) { ?>
    	<div class="special_item">
		        <div class="special_info">
		            <?php if ( is_page('specials') ) { ?>
		            <h3><?= $special->title; ?></h3><br>
		            <?php } ?>

		            <a href="/vrp/specials/<?= $special->slug; ?>/"><?= $special->offertext; ?></a><br>

		            <?php
		            if ( is_page('specials') ) { 
		            	 if ( isset($special->shortcontent) && $special->shortcontent !== "" ) {
		            	 	echo $special->shortcontent;
		            	 } else if ( isset($special->content) && $special->content !== "" ) {
		            	 	echo $special->content;
		            	 }
		            } ?>
		        </div>
		        <div class="special_redeem">
		        	<small>
			        	<?php if ( isset($special->promocode) && $special->promocode !== "" && isset($special->slug) && $special->slug !== "" ) { ?>
				        	Promo Code<br>
				            <a href="/vrp/specials/<?= $special->slug; ?>/"><?= $special->promocode; ?></a>
			            <?php } else if ( isset($special->promocode) && $special->promocode !== "") { ?>
				            Promo Code<br>
				            <?= $special->promocode; ?>
			            <?php } else if ( isset($special->slug) && $special->slug !== "") { ?> 
			            	<a href="/vrp/specials/<?= $special->slug; ?>/">More Info</a>
			            <?php } else { ?>
			            	Please call for more info.
			            <?php } ?>
			        </small>
		        </div>
		    </div> <!-- close .special-item -->
        <?php } ?>
    </div>
    
</div>

<?php
// echo '<pre>';
// print_r($data);
// echo '</pre>';
?>
