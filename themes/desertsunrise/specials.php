<?php
/**
 * Specials template
 *
 * @package VRPConnector
 */
?>
<?php if (empty($data)) : ?>

	<p>There are no current specials. Please check back soon.</p>
	
<?php else : ?>

	<div class="vrp">
		<div class="vrp-container-fluid unit vrp-col-md-12 vrp-col-sm-12">

			<!-- Special description content -->
			<div class="vrp-row vrp-pad">
				<div class="vrp-row">
					<div class="vrp-row vrp-pad">
						<h2><?php echo $data->title; ?></h2>
					</div>
					<div class="vrp-row vrp-pad">
						<h3>This special is active from <?php echo $data->start_date . " until " . $data->end_date; ?></h3>
					</div>
				</div>
				<div class="vrp-row vrp-pad">
					<img alt="" src="<?php echo $data->image; ?>"/>
				</div>
				<div class="vrp-row vrp-pad">
					<p><?php echo $data->content; ?></p>
				</div>
			</div>

			<!-- Special units -->
			<div class="vrp-row vrp-pad">
				<?php if (!empty($data->units)) : ?>

					<?php foreach ($data->units as $unit) : ?>
						<div class="vrp-col-md-4 vrp-col-xs-12 vrp-col-sm-6 vrp-col-lg-4 vrp-item-wrap vrp-grid">
							<div class="vrp-item result-wrap">
								<div class="vrp-result-image-container">
									<div class="fav-flyout">
										<div class="fav-flyout-txt">Add to my favorites!</div>
									</div>
									<div 
										data-unit="<?= $unit->id; ?>" 
										class="resultsFavorite vrp-favorite-button add-favorite">
									</div>
									<img alt="" src="<?= $unit->photos[0]->thumb_url; ?>"/>
								</div>
								<div class="vrp-results-description">
									<div class="vrp-results-wrap">
										<h3>
											<a 	href="/vrp/unit/<?= $unit->page_slug; ?>"
												Title="<?php echo $unit->Name; ?>"><?php echo $unit->Name; ?></a>
										</h3>
										<div class="vrp-result-line details">
											<?= $unit->Bedrooms; ?> BR | <?= $unit->City; ?>
										</div>
									</div>
								</div>
								<div class="vrp-results-more">
									<a 	href="/vrp/unit/<?= $unit->page_slug; ?>" 
										class="viewDetailsBtn">View Special</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

				<?php endif; ?>
			</div><!-- /vrp-row vrp-pad -->
		</div><!-- /vrp-container-fluid unit -->
	</div><!-- /vrp -->

<?php endif; ?>
