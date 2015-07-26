
<!-- @TODO: right align active theme, to the left show theme options (e.g: featured properties, perhaps certain display items in the products, etc. -->
<div class="row">
    <?php foreach ($this->available_themes as $name => $displayname): ?>
        <div class="col-sm-3">
            <div class="text-center block"><?= $displayname; ?>
                [<strong>
                    <?= ($this->themename === $name) ?
                        '<span class="text-success">Active</span>' :
                        '<a href="#" data-theme-selection="' . $name . '">Activate</a>';
                    ?>
                </strong>]
            </div>
            <img src="<?= VRP_URL; ?>themes/<?= $this->themename; ?>/preview.png"
                 class="theme-preview img-responsive img-thumbnail "/>
        </div>
    <?php endforeach; ?>
</div>

<form
    method="post"
    action="<?=admin_url('options-general.php?page=VRPConnector&vrpUpdateSection=updateVRPThemeSettings') ;?>"
    name="vrpThemeSelection">
    <input type="hidden" name="vrpTheme" value="<?=$this->themename;?>" />
    <?php wp_nonce_field('updateVRPThemeSettings', 'nonceField'); ?>
</form>