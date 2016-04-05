<?php 
$arrival="";
if (!empty($_GET['search']['arrival'])){
    $_SESSION['arrival']=$_GET['search']['arrival'];
}

if (!empty($_SESSION['arrival'])){
    $arrival=date('m/d/Y',strtotime($_SESSION['arrival']));
}else{
    $arrival=date('m/d/Y',strtotime("tomorrow"));
}

$depart="";
if (!empty($_GET['search']['departure'])){
    $_SESSION['depart']=$_GET['search']['departure'];
}

if (!empty($_SESSION['depart'])){
    $depart=date('m/d/Y',strtotime($_SESSION['depart']));
}else{
    $depart=date('m/d/Y',strtotime("+9 Days"));
}

$sleeps="";
if (!empty($_GET['search']['sleeps'])){
    $_SESSION['sleeps']=$_GET['search']['sleeps'];
}

if (!empty($_SESSION['sleeps'])){
    $sleeps=$_SESSION['sleeps'];
}

?>

<div class="vrp-searchbox">
<?php global $vrp;
$searchoptions = $vrp->searchoptions();
?>
    <form id="vrp-searchbox-form" method="GET" action="<?php bloginfo('url'); ?>/vrp/search/results/" method="get">
        <legend>
            Search
        </legend>
        <div class="searchbox-input searchbox-input-arrive fa fa-calendar fa-fw">
            <input type="text" id="vrp-searchbox-start-date" name="search[arrival]" class="form-control input-lg" tabindex="1" placeholder="Arrive" <?php if (!empty($_GET['search']['arrival'])){ ?> value="<?php echo $arrival;?>" <?php } ?>>
        </div>
        <div class="searchbox-input searchbox-input-depart fa fa-calendar fa-fw">
            <input type="text" id="vrp-searchbox-end-date" name="search[departure]" class="form-control input-lg" tabindex="2" placeholder="Depart" <?php if (!empty($_GET['search']['departure'])){ ?> value="<?php echo $depart;?>" <?php } ?>>
        </div>

        <div class="searchbox-input searchbox-select fa fa-users fa-fw">
            <i class="fa fa-chevron-down"></i>
            <select class="select-lg is-default" tabindex="3" name="search[sleeps]" id="gssleeps">
                <option selected="selected" value="1">Guests</option>
                <?php $s = 1;?>
                <?php foreach (range(1,($searchoptions->maxsleeps)) as $v) {
                    $sel = "";
                    if ($sleeps == $v) {
                        $sel = "selected=\"selected\"";
                    }
                ?>
                <option value="<?= $v; ?>" <?php echo $sel;?> ><?php echo $v; ?><?php if ($s < $searchoptions->maxsleeps) { echo '+';}?></option>
                <?php 
                    $s++;
                    } ?>
            </select>
        </div>

        <input type="hidden" name="search[showmax]" value="true">
        <?php if (empty($_GET['search']['arrival'])){ ?> <input id="nodates" type="hidden" name="search[showall]" value="true"> <?php } ?>
        <input type="submit" name="propSearch" class="searchbox-submit" value="Search" tabindex="4">
    </form>
</div>



