
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<?php
/**
 * View Favorites from Results Tab
 *
 * @package VRPConnector
 */


parse_str($_SERVER['QUERY_STRING'], $output);

$favorites =comma_separated_to_array($output['search']['ids']);  // Input var okay.


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
$total = count($favorites);

?>


<div class="vrp-row">
    <div class="vrp-col-xs-12">
        <hr/>
    </div>
</div>
<div class="vrp-row">
    <?php if ($total == 0): ?>
        <h3>Sorry, you have not added any Favorites!</h3>


    <?php else : ?>
        <h3>Favorites shown for current search criteria. For a full list of your favorites, <a
                    href="/vrp/favorites/show"><i class="fa fa-fw fa-lg fa-heart"></i>Click Here.</a></h3>
        <?php foreach ($units as $index => $unit) : ?>

            <div class="vrp-col-md-4 vrp-col-xs-12 vrp-col-sm-6 vrp-col-lg-4 vrp-item-wrap vrp-grid">
                <div class="vrp-item result-wrap">
                    <div class="vrp-result-image-container">

                        <?php
                        if(!empty($unit->Photo)) { ?>
                            <a href="/vrp/unit/<?= $unit->page_slug; ?>" class="vrp-result-bg"
                               style="background-image:url('<?php echo $unit->Photo; ?>');">
                            </a>
                        <?php  } elseif(!empty($unit->AllPhotos[1]->thumb_url)){?>
                            <a href="/vrp/unit/<?= $unit->page_slug; ?>" class="vrp-result-bg"
                               style="background-image:url('<?php echo $unit->AllPhotos[1]->thumb_url; ?>');">
                            </a>
                        <?php } else  {?>
                        <a href="/vrp/unit/<?= $unit->page_slug; ?>" class="vrp-result-bg"
                            style="background-image:url('<?php echo $unit->AllPhotos[1]->url; ?>');">
                        </a>
                       <?php }?>

                    </div>

                    <div class="vrp-results-description">
                        <div class="vrp-results-wrap">

                            <h3><a href="/vrp/unit/<?= $unit->page_slug; ?>"
                                        Title="<?php echo $unit->Name; ?>"><?php echo $unit->Name; ?> </a>
                            </h3>
                            <div class="vrp-result-line details"> <?= $unit->Bedrooms; ?> BR
                                | <?= $unit->City; ?>   </div>

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



    <?php endif; ?>
</div>
