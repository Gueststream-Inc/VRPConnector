<div class="vrpsidebar vrpsearch">
<h3>Find Your Perfect Vacation Rental</h3>
<?php
/** Default Dates: **/
date_default_timezone_set('Pacific/Honolulu');
$today      = date("m/d/Y");
$thetime    = strtotime(date("g:i A"));
$cutofftime = strtotime("5:00 PM");
echo "<!-- " . date("m/d/Y g:i A", $thetime) . " vs. " . date("m/d/Y g:i A", $cutofftime) . " -->";
if (isset($_GET['destroy'])) {
    session_destroy();
}
$tomorrow = strtotime("+1 days");
if (isset($_SESSION['arrival'])) {
    $arrival = strtotime($_SESSION['arrival']);
    if ($arrival > $tomorrow) {
        $arrival = date("m/d/Y", $arrival);
    } else {
        //$arrival=date("m/d/Y",$arrival);
        $arrival   = date("m/d/Y", strtotime("+98 days"));
        $departure = date("m/d/Y", strtotime("+105 days"));
    }
} else {
    $arrival = date("m/d/Y", strtotime("+98 days"));
}

if (isset($_SESSION['depart'])) {
    $depart = date("m/d/Y", strtotime($_SESSION['depart']));
} else {
    $depart = date("m/d/Y", strtotime("+105 days"));
}

if(isset($_GET['search']['nights'])){
    $_SESSION['nights'] = $_GET['search']['nights'];
}

if (isset($_SESSION['nights'])) {
    $nights = $_SESSION['nights'];
} else {
    $nights = 7;
}

if (isset($departure)) {
    $depart = $departure;
}

global $vrp;
$searchoptions = $vrp->searchoptions();
?>

        <form action="/vrp/search/results/" method="get" class="vrpsearchform">

        <ul>
            <li>
                <label for="arrival">Arrival</label>
                <span class="input-group date">
                    <input type="text"
                       name="search[arrival]"
                       size="10"
                       id="arrival"
                       value="<?php echo $arrival; ?>"/>
               </span>
           </li>
           <li>
                <label for="depart">Departure</label>
                <span class="input-group date">
                    <input type="text"
                       name="search[departure]"
                       size="10"
                       id="depart" value="<?php echo $depart; ?>" />
               </span>
           </li>
           <li>
                <label for="bedrooms">Bedrooms</label>
                <div class="select--borderless">
                    <select name="search[bedrooms]" id="bedrooms">
                        <option value=""># Bedrooms</option>
                        <?php foreach (range($searchoptions->minbeds, $searchoptions->maxbeds) as $v) {
                            $sel = "";
                            if ($bedrooms == $v) {
                                $sel = "selected=\"selected\"";
                            }
                            ?>

                            <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                        <?php } ?>
                    </select><i class="fa fa-caret-down"></i>

                    <?php
                    $adults = 0;

                    if (isset($_GET['search']['adults'])) {
                        $_SESSION['adults'] = (int) $_GET['search']['adults'];
                    }

                    if (isset($_SESSION['adults'])) {
                        $adults = $_SESSION['adults'];
                    }
                    ?>
                </div>
            </li>
            <li>
                <label for="searchadults">Occupants</label>
                <div class="select--borderless">
                    <select id="searchadults" name="search[adults]">
                        <?php foreach (range(1, 10) as $v):
                            $sel = "";

                            if ($adults == $v) {
                                $sel = "selected=\"selected\"";
                            }
                            ?>
                            <option value="<?= $v; ?>" <?= $sel; ?>>
                                <?= $v; ?>
                            </option>

                        <?php endforeach; ?>
                    </select><i class="fa fa-caret-down"></i>
                </div>

                <?php
                $children = 0;

                if (isset($_GET['search']['children'])) {
                    $_SESSION['children'] = (int) $_GET['search']['children'];
                }

                if (isset($_SESSION['children'])) {
                    $children = $_SESSION['children'];
                }
                ?>
            </li>
            <input type="hidden" id="tn" value="<?= $nights; ?>"/>
            <li>
                <div style="padding: 15px 0px 8px 32px;">
                     <input type="submit"
                           name="propSearch"
                           class="ButtonView btn"
                           value="Search Now">
                </div>
            </li>
        </ul>
    </form>

</div>
