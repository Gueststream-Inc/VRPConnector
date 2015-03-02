<?php
/**
 * @Author Josh Houghtelin <josh@findsomehelp.com>
 * Date: 10/23/14
 * Time: 1:07 PM
 */

//echo "<pre>"; print_r($data); echo "</pre>";

if($data->count == 0) {
    // No Units to display
} else {
    ?>
    <div class="row">
        <?=$data->count?> Results.
    </div>
    <?php
    foreach($data->results as $a_unit) {
        ?>
        <div class="row">
            <div class="row">
                <h2><a href="<?=get_bloginfo('url')?>/vrp/unit/<?=$a_unit->page_slug?>"><?=$a_unit->Name?></a></h2>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <img src="<?=$a_unit->Thumb?>" class="unit_thumbnail" />
                </div>
                <div class="col-md-10">
                    <?=$a_unit->ShortDescription?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <ul class="vrpPages">
        <?php
        for($i=1;$i<$data->totalpages;$i++){
            if($data->page == $i) {
                ?>
                <li><?= $i ?></li>
                <?php
            } else {
                ?>
                <li><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php
            }
        }
        ?>
        </ul>
    </div>
    <?php
}


