<!-- all the important responsive layout stuff -->
<div id="vrp">
    <div id="vrp-map">
        <div id="vrp-map-canvas"></div>
    </div>
    <div id="vrpresults" class="vrp-container-fluid hide">
<!--        <PRE>-->
<!--        --><?php //print_r($data);?>
<!--        </PRE>-->

        <?php if ($data->count === 0) : ?>

            <div class="vrp-row">
                <h2>No Results Found</h2>
                <p>Please revise your search criteria.</p>
            </div>

        <?php else: ?>
        <!-- Total number of results found -->
        <div class="vrp-row">


            <!--                                vrp-wrapper-presentation-actions-->
            <div class="vrp-col-md-10">
                <div class="vrp-form-filter-action">
                    <?php vrp_resultsperpage(); ?>
                    <?php vrpsortlinks($data->results[0]); ?>
                </div>
            </div>
            <div class="vrp-col-md-2 vrp-layout-action">
                <div class="vrp-pull-right">
                    <a href="#" id="vrp-list" class="vrp-btn">
                        <i class="fa fa-fw fa-lg fa-th-list"></i>
                    </a>
                    <a href="#" id="vrp-grid" class="vrp-btn">
                        <i class="fa fa-fw fa-lg fa-th"></i>
                    </a>
                    <a href="<?=site_url() . "/vrp/favorites/show";?>" id="vrp-favorites" class="vrp-btn turquoise">
                        <i class="fa fa-fw fa-lg fa-heart"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="vrp-row">
            <div class="vrp-col-xs-12"><hr /></div>
        </div>

        <div class="vrp-row">
        <?php foreach($data->results as $index => $a_unit) : ?>


            <div class="vrp-col-md-4 vrp-col-xs-12 vrp-col-sm-6 vrp-item-wrap vrp-grid">
                <div class="vrp-item">

                    <div class="vrp-thumbnail text-center" style="background-image:url(<?=esc_url($a_unit->Thumb); ?>);">

                        <div class="vrp-actions">
                            <a href="<?php echo site_url() . "/vrp/favorites/show";?>" data-unit="<?php echo $a_unit->id; ?>" class="vrp-favorite-button vrp-btn purple text-center">
                                <i class="fa fa-fw fa-lg fa-heart"></i>
                                Add to favorites
                            </a>

                            <a href="#" data-unit="<?php echo $a_unit->id; ?>" class="vrp-btn orange">
                                <i class="fa fa-fw fa-lg fa-calendar"></i>
                                Reserve now
                            </a>
                        </div>
<!--                        <img src="http://placehold.it/285x200/ddd/ddd" class="vrp-img-thumbnail vrp-img-responsive vrp-center-block" width="97%" alt="" /> -->
                    </div>

                    <div class="vrp-caption">
                        <div class="vrp-row">
                            <div class="vrp-col-xs-8 vrp-col-sm-7">
                                <h4><?=esc_html($a_unit->Name); ?></h4>
                            </div>
                            <div class="vrp-col-xs-4 vrp-col-sm-5">
                                <div class="vpr-meta-wrapper">
                                    <div class="vpr-row">
                                        <div class="col-xs-6">

                                            <span class="vrp-epink pull-right">
                                                <strong><?=esc_html($a_unit->Bedrooms); ?> Beds</strong>
                                            </span>

                                        </div>
                                        <div class="col-xs-6">

                                            <span class="vrp-kiwi pull-right">
                                                <strong><?=esc_html($a_unit->Bathrooms); ?> Baths</strong>
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
        <?php endif ?>
        <div class="vrp-row">
            <div class="vrp-col-md-12">
                <?=vrp_pagination($data->totalpages, $data->page); ?>
            </div>
        </div>
    </div>
</div>