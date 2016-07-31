<?php
/**
 * VRPConnector Search Results Template
 *
 * @package VRPConnector
 * @since 1.3.1
 */
?>
<!-- all the important responsive layout stuff -->
<div id="vrp">
	<div id="vrp-map">
		<div class="vrp-map-canvas"></div>
	</div>
	<div id="vrpresults" class="vrp-container-fluid">
		<?php if ( empty( $data->count ) ) : ?>

			<div class="vrp-row">
				<h2>No Results Found</h2>

				<p>
					<?php if ( ! empty( $data->Error ) ) : ?>
						<?php echo $data->Error; ?>
					<?php else: ?>
						Please revise your search criteria.
					<?php endif; ?>
				</p>
			</div>

		<?php else: ?>

			<div class="vrp-row">
				<!-- vrp-wrapper-presentation-actions-->
				<div class="vrp-col-md-10">
					<div class="vrp-form-filter-action">
						<?php vrp_resultsperpage(); ?>
						<?php vrpsortlinks( $data->results[0] ); ?>
					</div>
				</div>
				<div class="vrp-col-md-2 vrp-layout-action">
					<div class="vrp-pull-right">
						<a href="<?php echo site_url() . "/vrp/favorites/show"; ?>" id="vrp-favorites"
						   class="vrp-btn turquoise">
							<i class="fa fa-fw fa-lg fa-heart"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="vrp-row">
				<div class="vrp-col-xs-12">
					<hr/>
				</div>
			</div>

			<div class="vrp-row">
				<div id="vrp-result-list-map" class="vrp-col-md-12" style="height:300px;width:100%"></div>
			</div>

			<div class="vrp-row">
				<div class="vrp-col-xs-12">
					<hr/>
				</div>
			</div>

			<div class="vrp-row">

				<?php foreach ( $data->results as $index => $unit ) : ?>

					<div class="vrp-col-md-6 vrp-col-xs-12 vrp-col-sm-6 vrp-item-wrap vrp-grid">
						<div class="vrp-item"
						     data-vrp-address="<?php echo $unit->Address1; ?> <?php echo $unit->City; ?>, <?php echo $unit->State; ?>"
						     data-vrp-name="<?php echo esc_html( $unit->Name ); ?>"
						     data-vrp-url="<?php echo site_url() . "/vrp/unit/" . $unit->page_slug; ?>"
						     data-vrp-thumbnail="<?php echo $unit->Thumb; ?>">

							<div class="vrp-thumbnail text-center"
							     style="background-image:url('<?php echo $unit->Thumb; ?>');">
								<div class="vrp-actions">
									<a href="#" data-unit="<?php echo $unit->id; ?>"
									   class="vrp-favorite-button vrp-btn purple text-center">
										<i class="fa fa-fw fa-lg fa-heart"></i>
										Add to favorites
									</a>

									<a href="<?php echo site_url( '/vrp/unit/' . $unit->page_slug ); ?>"
									   data-unit="<?php echo $unit->id; ?>" class="vrp-btn orange">
										<i class="fa fa-fw fa-lg fa-calendar"></i>
										Reserve now
									</a>
								</div>
							</div>
							<div class="vrp-caption">
								<div class="vrp-row">
									<div class="vrp-col-xs-8 vrp-col-sm-7">
										<h4><?php echo esc_html( $unit->Name ); ?></h4>
									</div>
									<div class="vrp-col-xs-4 vrp-col-sm-5">
										<div class="vrp-meta-wrapper">
											<div class="vrp-row">
												<div class="col-xs-6">
		                                            <span class="vrp-epink pull-right">
		                                                <strong><?php echo esc_html( $unit->Bedrooms ); ?> Beds</strong>
		                                            </span>
												</div>
												<div class="col-xs-6">
			                                        <span class="vrp-kiwi pull-right">
			                                            <strong><?php echo esc_html( $unit->Bathrooms ); ?> Baths</strong>
			                                        </span>
												</div>
											</div>
										</div>
									</div>
								</div>
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
		<?php endif ?>
	</div>
</div>
