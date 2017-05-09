<div id="vrp"><div class="vrpsidebar vrp-col-md-12 vrpsearch">
<?php 


if (isset($_GET['search']['arrival'])) {
            $_SESSION['arrival'] = $_GET['search']['arrival'];
        }

        if (isset($_GET['search']['departure'])) {
            $_SESSION['depart'] = $_GET['search']['departure'];
        }

$arrival="";
if (!empty($_SESSION['arrival'])) {
    $arrival = date('m/d/Y', strtotime($_SESSION['arrival']));
}
$depart="";
if (!empty($_SESSION['depart'])) {
    $depart = date('m/d/Y', strtotime($_SESSION['depart']));
}

 $nights = (strtotime($depart) - strtotime($arrival)) / 86400;


$adults="";
if (!empty($_GET['search']['Adults'])){
    $_SESSION['adults']=$_GET['search']['Adults'];
}
if (!empty($_SESSION['adults'])){
    $adults=$_SESSION['adults'];
}

$children="";
if (!empty($_GET['search']['Children'])){
    $_SESSION['children']=$_GET['search']['Children'];
}
if (!empty($_SESSION['children'])){
    $children=$_SESSION['children'];
}


$type="";
if (isset($_GET['search']['type'])){
    $_SESSION['type']=$_GET['search']['type'];
}

if (isset($_SESSION['type'])){
    $type=$_SESSION['type'];
}

$sleeps="";
if (isset($_GET['search']['sleeps'])){
    $_SESSION['sleeps']=$_GET['search']['sleeps'];
}

if (isset($_SESSION['sleeps'])){
    $sleeps=$_SESSION['sleeps'];
}

$view="";
if (isset($_GET['search']['view'])){
    $_SESSION['view']=$_GET['search']['view'];
}

if (isset($_SESSION['view'])){
    $view=$_SESSION['view'];
}


$location="";
if (isset($_GET['search']['location'])){
    $_SESSION['location']=$_GET['search']['location'];
}

if (isset($_SESSION['location'])){
    $location=$_SESSION['location'];
}
$bedrooms="";
if (isset($_GET['search']['bedrooms'])){
    $_SESSION['bedrooms']=$_GET['search']['bedrooms'];
}

if (isset($_SESSION['bedrooms'])){
    $bedrooms=$_SESSION['bedrooms'];
}

$bathrooms="";
if (isset($_GET['search']['bathrooms'])){
    $_SESSION['bathrooms']=$_GET['search']['bathrooms'];
}



global $vrp;
$searchoptions=$vrp->searchoptions();

 ?>

<form action="<?php bloginfo('url'); ?>/vrp/search/results/" method="get" id="vrp-searchbox-form" class="search">

    <div>
         
            <div class="advanced-search">
                <span class="input-group date advanced-search">
                    <input type="text"
                       name="search[arrival]"
                       size="30"
                       id="arrival"
                       value="<?php echo $arrival; ?>" placeholder="Check In"/>
                        
           </div>
        <div class="advanced-search">
                <span class="input-group date advanced-search">
                    <input type="text"
                       name="search[departure]"
                       size="30"
                       id="depart"
                       value="<?php echo $depart; ?>" placeholder="Check Out"/>

               </span>
           </div>
        <br style="clear:both;">
            <div class= "advanced-search">
                <div class="select--borderless advanced-search">
                    <select id="searchadults"  name="search[sleeps]">
                        <option selected="selected" value="">Guests</option>
                        <option value="">Any</option>
                         <?php foreach (range(2, $searchoptions->maxsleeps) as $v) {
                                $sel = "";
                                if ($sleeps == $v) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>

                                <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?> Guests</option>

                            <?php } ?>
                        </select>
                </div>
            </div>
             <div class="advanced-search">
                
                    <select id="searchchildren"  name="search[Children]">
                        <option selected="selected" value="">Children</option>
                        <option value="">Any</option>
                         <?php foreach (range(2, $searchoptions->maxsleeps) as $v) {
                                $sel = "";
                                if ($children == $v) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>

                                <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?> Children</option>

                            <?php } ?>
                        </select>
                </div>
            
          
             <div class="advanced-search">
                <select id="searchcbedrooms"  name="search[bedrooms]">
                    <option selected="selected" value="">Bedrooms</option>
                    <option value="">Any</option>
                     <?php foreach (range(2, $searchoptions->maxbeds) as $v) {
                            $sel = "";
                            if ($bedrooms == $v) {
                                $sel = "selected=\"selected\"";
                            }
                            ?>

                            <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?> Bedrooms</option>

                        <?php } ?>
                </select>
                </div>
        <br style="clear:both;">
                <div class="advanced-search">
              





           <input type="hidden" id="tn" value="<?= $nights; ?>"/>
        <input type="hidden" name="showmax" value="true">
        <input type="submit" name="propSearch" class="vrp-blue" value="Search Again">

         <input type="hidden" name="search[sort]" value="Name">
         <input type="hidden" name="search[order]" value="ASC">


            </div>
    </div>



</form>

</div>
</div>

