<?php
/**
 * [vrpFeaturedReviews] Shortcode Template
 *
 * @package VRPConnector
 */

?>

<div id="featuredReviews">
	<div class="vrp-conatiner-fluid">
		<div class="vrp-row">
			<div class="vrp-col-lg-12 vrp-col-md-12 vrp-col-xs-12">
				
				<?php foreach ($data->featuredReviews as $review) : ?>
					<div class="vrp-col-lg-4 vrp-col-md-4 vrp-col-xs-12 freview">
						<div class="vrp-review-title">
							<?= $review->title; ?>
						</div>
						<div class="vrp-review-stars">
							<?php if ($review->rating != '' || $review->rating != NULL) {
								$stars = (int) $review->rating;

								for ($i = 1; $i <= $stars; $i++) {
									echo "<i class='fa fa-star'></i>";
								} ?>

								<span>
									| <?php echo $stars ." out of 5 stars!"; ?>
								</span>
							<?php }	?>
						</div>
						<div class="vrp-review-details">
							<?= "<span class='vrp-review-name'>" . (($review->name != '') ? $review->name : "Unknown") . "</span> reviewed on <span class='vrp-review-date'>" . $review->review_date . "</span>"; ?>
						</div>
						<hr>
						<div class="vrp-review">
							<?= htmlspecialchars_decode($review->review); ?>
						</div>
					</div>
				<?php endforeach; ?>

			</div>			
		</div>
	</div>
</div>