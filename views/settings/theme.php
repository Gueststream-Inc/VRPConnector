
<!-- @TODO: right align active theme, to the left show theme options (e.g: featured properties, perhaps certain display items in the products, etc. -->
<div class="row">
    <?php foreach ($this->themes->availableThemes as $name => $displayName): ?>
        <div class="col-sm-3">
            <div class="text-center block"><?= $displayName; ?>
                [<strong>
                    <?= ($this->themes->theme === $name) ?
                        '<span class="text-success">Active</span>' :
                        '<a href="#" data-theme-selection="' . $name . '">Activate</a>';
                    ?>
                </strong>]
            </div>
            <img src="<?= VRP_URL; ?>themes/<?= $this->themes->theme ;?>/preview.png"
                 class="theme-preview img-responsive img-thumbnail "/>
        </div>
    <?php endforeach; ?>
</div>

<form
    method="post"
    action="<?=admin_url('options-general.php?page=VRPConnector&vrpUpdateSection=updateVRPThemeSettings') ;?>"
    name="vrpThemeSelection">
    <input type="hidden" name="vrpTheme" value="<?=$this->themes->theme;?>" />
    <?php wp_nonce_field('updateVRPThemeSettings', 'nonceField'); ?>
</form>