
<!-- @TODO: right align active theme, to the left show theme options (e.g: featured properties, perhaps certain display items in the products, etc. -->
<div class="row">
    <?php foreach ($this->available_themes as $name => $displayname): ?>
        <div class="col-sm-3">
            <div class="text-center block"><?= $displayname; ?>
                [<strong><?= ($this->themename === $name) ? '<span class="text-success">Active</span>' : '<a href="#">Activate</a>'; ?></strong>]
            </div>
            <img src="<?= VRP_URL; ?>themes/<?= $this->themename; ?>/preview.png"
                 class="theme-preview img-responsive img-thumbnail "/>
        </div>
    <?php endforeach; ?>
    <?php foreach ($this->available_themes as $name => $displayname): ?>
        <div class="col-sm-3">
            <div class="text-center block"><?= $displayname; ?> [<strong><a href="#">Activate</a></strong>]</div>
            <img src="<?= VRP_URL; ?>themes/<?= $this->themename; ?>/preview.png"
                 class="theme-preview img-responsive img-thumbnail "/>
        </div>
    <?php endforeach; ?>
    <?php foreach ($this->available_themes as $name => $displayname): ?>
        <div class="col-sm-3">
            <div class="text-center block"><?= $displayname; ?> [<strong><a href="#">Activate</a></strong>]</div>
            <img src="<?= VRP_URL; ?>themes/<?= $this->themename; ?>/preview.png"
                 class="theme-preview img-responsive img-thumbnail "/>
        </div>
    <?php endforeach; ?>
</div>