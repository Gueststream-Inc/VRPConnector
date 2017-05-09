<?php
/**
 * VRPConnector Search Results Template
 *
 * @package VRPConnector
 * @since 1.3.1
 */?>


<?php

if (isset($_GET['search']['arrival'])) {
    $_SESSION['arrival'] = $_GET['search']['arrival'];
}

$arrival=$_SESSION['arrival'];


if (isset($_GET['search']['departure'])) {
    $_SESSION['depart'] = $_GET['search']['departure'];
}


$depart=$_SESSION['depart'];


$nights = (strtotime($depart) - strtotime($arrival)) / 86400;

$curResultURL="/vrp/search/results/?".$_SESSION['pageurl'];
?>
<!-- all the important responsive layout stuff -->

		<?php if ( empty( $data->count ) ) : ?>
    <div class="vrp-col-md-12 vrp-col-sm-6">
			<div class="vrp-row">
				<h2>No Results Found</h2>

				<p>
					<?php if ( ! empty( $data->Error ) ) : ?>
						<?php echo $data->Error; ?>
					<?php else : ?>
						Please revise your search criteria.
					<?php endif; ?>
				</p>
                <?php echo do_shortcode('[vrpResultsSearchForm]');?>
			</div>
    </div>
		<?php else : ?>
<div id="vrp"
     data-vrp-arrival="<?php echo $_SESSION['arrival'] ?>"
     data-vrp-depart="<?php echo $_SESSION['depart']?>">

    <div id="vrpresults" class="vrp-container-fluid results">


                <div id="results-tabs">
                    <div class="vrp-row">
                <!-- vrp-wrapper-presentation-actions-->
				<div class="vrp-col-md-12 vrp-col-sm-6">
					<div class="vrp-form-filter-action vrp-col-md-4 vrp-col-sm-12">
						<?php vrp_resultsperpage(); ?>
						<?php vrpsortlinks( $data->results[0] ); ?>
                        
					</div>
                    <div class="vrp-col-md-8 vrp-col-sm-12 vrp-pull-right vrp-layout-action">
					<span>
                        <ul id="resultsTabs" class="vrp-pull-right">
                            <li class="current"> <a href="#vrp-list-results" id="vrp-list-view"> <i class="fa fa-fw fa-lg fa-list"></i>List View</a> </li>
                            <li><a href="#vrp-list-map-results" id="vrp-map-view"> <i class="fa fa-fw fa-lg fa-map-marker"></i>Map View</a>     </li>
                           <li> <a href="#vrp-list-fav-results" id="vrp-favorites-view">	<i class="fa fa-fw fa-lg fa-heart"></i>Favorites</a></li>


                        </ul>


                    </span>

                    </div>
				</div>





        <!--displays list view of results-->
            <div id="vrp-list-results" class="tab-content">
			<div  class="vrp-row">
				<div class="vrp-col-xs-12">
					<hr/>
				</div>
			</div>




			<div class="vrp-row">

				<?php foreach ( $data->results as $index => $unit ) : ?>

					<div class="vrp-col-md-4 vrp-col-xs-12 vrp-col-sm-6 vrp-col-lg-4 vrp-item-wrap vrp-grid">
						<div class="vrp-item result-wrap"

                     data-vrp-address="<?php echo $unit->Address1; ?> <?php echo $unit->City; ?>, <?php echo $unit->State; ?>"
                     data-vrp-name="<?php echo esc_html($unit->Name); ?>"
                     data-vrp-url="<?php echo site_url() . "/vrp/unit/" . $unit->page_slug; ?>"
                     data-vrp-thumbnail="<?php echo $unit->Thumb; ?>"
                     data-vrp-latitude="<?php echo $unit->lat; ?>"
                     data-vrp-longitude="<?php echo $unit->long; ?>" >


                            <div class="vrp-result-image-container">

                                <div class="fav-flyout">
                                    <div class="fav-flyout-txt">Add to my favorites!</div>
                                </div>
                                <div data-unit="<?= $unit->id; ?>"
                                     class="resultsFavorite vrp-favorite-button add-favorite"></div>

                                <a  class="vrp-result-bg"href="/vrp/unit/<?= $unit->page_slug; ?>"
                                style="background-image:url('<?php echo $unit->Thumb; ?>');">
                                </a>
                            </div>

                                    <div class="vrp-results-description">
                                        <div class="vrp-results-wrap">

                                            <h3><a
                                                        href="/vrp/unit/<?= $unit->page_slug; ?>"
                                                        Title="<?php echo $unit->Name; ?>"><?php echo $unit->Name; ?> </a>
                                            </h3>
                                            <div class="vrp-result-line details"> <?= $unit->Bedrooms; ?> BR | <?= $unit->City; ?>   </div>

                                            <div class="vrp-results-line rate"> <?php if (!empty($unit->Rate)) { ?>$<?php echo esc_html(number_format(($unit->Rate) / ($nights), 2)); ?>/night
                                                <?php } else { ?>
                                                    Starting at $<?= esc_html(number_format($unit->MinDaily, 2)); ?>/night

                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                            <div class="vrp-results-more">
                                <a href="/vrp/unit/<?= $unit->page_slug; ?>" class="viewDetailsBtn">View
                                    Unit</a>
                            </div>




			</div>
                    </div>
                        <?php endforeach; ?>
            </div>
			<div class="vrp-row">
				<div class="vrp-col-md-12">
					<?php echo vrp_pagination( $data->totalpages, $data->page ); ?>
				</div>
			</div>
            </div>

                        <!--displays map view of results-->

                <div id="vrp-list-map-results" class="vrp-row tab-content">
                    <div  class="vrp-row">
                        <div class="vrp-col-xs-12">
                            <hr/>
                        </div>
                    </div>

                        <div id="vrp-result-list-map" class="vrp-col-md-12" style="width:100%"></div>


                </div>
                        <!--displays fav view of results-->
                <div class="vrp-row">
                    <div id="vrp-fav-loader"></div>
                        <div id="vrp-list-fav-results" class="tab-content">

                        </div>
                </div>


            </div>
	</div>
</div>
</div>
        <?php endif ?>


