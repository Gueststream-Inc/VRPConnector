<?php
/**
 * [vrpSpecialsUnits] Template
 *
 * @package VRPConnector
 */

?>

<h1>Specials</h1>
<?php if ( 0 === count( $data ) ) : ?>
	<p>There are no current specials. Please check back soon.</p>
<?php else : ?>

			<div class="vrp-row">

				<?php foreach ( $data as $index => $unit ) : ?>

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
					<?php //echo vrp_pagination( $data->totalpages, $data->page ); ?>
				</div>
			</div>
            </div>
<?php endif; ?>