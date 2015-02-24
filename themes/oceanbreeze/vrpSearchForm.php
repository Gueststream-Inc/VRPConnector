<div class="vrpsidebar">
    <div class="resultsfound">
        <h2>Search Our<br><span>Vacation Rentals</span></h2>
    </div>
    <?php

    if (isset($_GET['search']['arrival'])) {
        $_SESSION['arrival'] = $_GET['search']['arrival'];
    }

    if (isset($_GET['search']['departure'])) {
        $_SESSION['depart'] = $_GET['search']['departure'];
    }

    $arrival = date('m/d/Y', strtotime("now"));
    if (isset($_SESSION['arrival'])) {
        $arrival = date('m/d/Y', strtotime($_SESSION['arrival']));
    } else {
        $arrival = date('m/d/Y', strtotime("now"));
    }

    $depart = "";
    if (isset($_SESSION['depart'])) {
        $depart = date('m/d/Y', strtotime($_SESSION['depart']));
    } else {
        $depart = date('m/d/Y', strtotime("+9 Days"));
    }

    $type = "";
    if (isset($_GET['search']['type'])) {
        $_SESSION['type'] = $_GET['search']['type'];
    }

    if (isset($_SESSION['type'])) {
        $complex = $_SESSION['type'];
    }

    $sleeps = "";
    if (isset($_GET['search']['sleeps'])) {
        $_SESSION['sleeps'] = $_GET['search']['sleeps'];
    }

    if (isset($_SESSION['sleeps'])) {
        $sleeps = $_SESSION['sleeps'];
    }

    $location = "";
    if (isset($_GET['search']['location'])) {
        $_SESSION['location'] = $_GET['search']['location'];
    }

    if (isset($_SESSION['location'])) {
        $location = $_SESSION['location'];
    }

    $bedrooms = "";
    if (isset($_GET['search']['bedrooms'])) {
        $_SESSION['bedrooms'] = $_GET['search']['bedrooms'];
    }

    if (isset($_SESSION['bedrooms'])) {
        $bedrooms = $_SESSION['bedrooms'];
    }

    global $vrp;
    $searchoptions = $vrp->searchoptions();

    if (isset($_SESSION['arrival'])) {
        $aplaceholder = $arrival;
    } else {
        $aplaceholder = "Arrival:";
    }

    if (isset($_SESSION['departure'])) {
        $dplaceholder = $depart;
    } else {
        $dplaceholder = "Departure:";
    }

//print_r($searchoptions);

    ?>

    <form action="<?php bloginfo('url'); ?>/vrp/search/results/" method="get" class="form-sidebar">

        <ul>
            <!-- <label for="arrival">Check In:</label> -->
            <li class="input-group arrival">
                <input placeholder="Arrival:" type="text" class="input form-control" name="search[arrival]" id="arrival" value="<?= $aplaceholder; ?>">
                <label for="arrival" class="input-group-addon"><i class="icon-calendar glyph"></i></label>
            </li>

            <!-- <label for="depart">Check Out:</label> -->
            <li class="input-group depart">
                <input placeholder="Departure:" type="text" class="input form-control" name="search[departure]" id="depart" value="<?= $dplaceholder; ?>">
                <label for="depart" class="input-group-addon"><i class="icon-calendar glyph"></i></label>
            </li>
            <li class="input-group type">
                <!-- <label for="type">Type:</label> -->
                <select id ="type" name="search[type]" class="form-control">
                    <option value="">Type:</option>
                    <option value="">Any</option>
                    <?php
                    foreach ($searchoptions->types as $v) {

                        if ($type == $v) {
                            $sel = "selected=\"selected\"";
                        } else {
                            $sel = "";
                        }
                        ?>
                        <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                    <?php } ?>
                </select>
            </li>
            <li class="input-group location">
                <!-- <label for="location">Location:</label> -->
                <select id ="location" name="search[location]" class="form-control">
                    <option value="">Location:</option>
                    <option value="">No Preference</option>
                    <?php foreach ($searchoptions->areas as $v) {
                        $sel = "";
                        if ($location == $v) {
                            $sel = "selected=\"selected\"";
                        }
                        ?>

                        <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                    <?php } ?>

                </select>
            </li>
            <li>
                <ul>
                    <li class="input-group beds">
                        <!-- <label for="beds">Beds:</label> -->
                        <select id="beds" name="search[bedrooms]" class="form-control">
                            <option value="">Beds:</option>
                            <option value="">Any</option>
                            <?php foreach (range($searchoptions->minbeds, $searchoptions->maxbeds) as $v) {
                                $sel = "";
                                if ($bedrooms == $v) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>

                                <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                            <?php } ?>

                        </select>
                    </li>
                    <li class="input-group sleeps">
                        <!-- <label for="sleeps">Sleeps:</label> -->
                        <select id="sleeps" name="search[sleeps]" class="form-control">
                            <option value="">Sleeps:</option>
                            <option value="">Any</option>
                            <?php
                            foreach (range($searchoptions->minsleeps, $searchoptions->maxsleeps) as $v) {
                                $sel = "";
                                if ($sleeps == $v) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>

                                <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                            <?php } ?>

                        </select>
                    </li>    
                </ul>
            </li>
            
            <li class="input-group submit">
                 <input id="submit" type="submit" name="propSearch" class="ButtonView rounded form-control" value="Search">
            </li>
        </ul>

        




        


        


        


       


    </form>

</div>