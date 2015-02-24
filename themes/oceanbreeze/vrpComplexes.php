<?php
/**
 * [vrpComplexes] Shortcode view
 *
 */
//echo "<pre>"; print_r($data); echo "</pre>";

foreach($data as $complex) {
    ?>
    <div class="row">
        <div class="row">
            <h2>
                <a href="/vrp/complex/<?=$complex->page_slug?>">
                    <?=$complex->name?>
                </a>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <img src="<?=$complex->Photo?>" style="width:100%">
            </div>
            <div class="col-md-8">
                <?=$complex->shortdescription?>
            </div>
        </div>
    </div>
<?php
}

/*
    complex => stdClass Object
        (
            [thecount] => 270
            [specialnotesshort] =>
            [id] => 17
            [name] => AVALON
            [shortdescription] => The Avalon Condominiums offers luxuriously appointed 3BR/3BA luxury apartments on the broadest and most beautiful 300 feet of Seven Mile Beach, a destination world-renowned for its white sand and turquoise waters. These azure views are on display from each of the all-waterfront condos at the property - full beachfront, guaranteed. While the Avalon is just a short barefoot stroll from the Westin, Ritz-Carlton and other condos; the beach here is less crowded due to lower density and more beach per unit than other luxury condo choices. Each unit has a screened dining area and small balcony off the master bedroom.
            [View] =>
            [page_slug] => avalon
            [Bathrooms] => 3
            [minbeds] => 3
            [maxbeds] => 3
            [minsleeps] => 6
            [maxsleeps] => 6
            [Photo] => https://s3.amazonaws.com/vrp2/vrpimages/5/complexes/17/5060f98326c86_2N0U1145nopowerlines.jpg
            [Photo2] => https://s3.amazonaws.com/vrp2/vrpimages/5/complexes/17/5060f9825aca5_2N0U1145nopowerlines.jpg
            [maxrate] => 1250
            [minrate] => 595
        )
 */


