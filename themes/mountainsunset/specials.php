<h1>Specials</h1>
<?php
 echo '<pre>';
 print_r($data);
 echo '</pre>';

if (count($data) == 0){ ?>
<p>There are no current specials.  Please check back soon.</p>
<?php }else{ 
   
foreach ($data as $special):
?>
<div class="sbox">
    <div class="vrpcontainer_12"><div class="vrpgrid_3">
    <?php
    if ($special->image != ''){ ?>
    <img src="<?=$special->image;?>" width="185px" class="simg">
    <?php
    }
    ?></div></div>
    <div class="vrpcontainer_12"><div class="vrpgrid_9">
    <b><?=$special->title;?></b><br>
    <br />
    <?=$special->content;?>
    </div></div>
    
</div><div class="clear"></div>
    <?php
endforeach;
}
    ?>