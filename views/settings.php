<?php global $vrp; ?>
<style>
    .tab-content {
        display:block;
        background:#fff;
        border:0px !important;
        padding:7px 10px;
    }
</style>

<div class="bootstrap-wrapper">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <img src="<?php echo plugins_url('/images/vrpconnector-logo.png',__FILE__);; ?>" alt="VRP Connector Logo"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
                    <li class="active"><a href="#theme" aria-controls="theme" role="tab" data-toggle="tab">Theme</a></li>
                    <li><a href="#api" aria-controls="api" role="tab" data-toggle="tab">API</a></li>
                    <li><a href="#support" aria-controls="support" role="tab" data-toggle="tab">Support</a></li>
                    <li><a href="#documentation" aria-controls="documentation" role="tab" data-toggle="tab">Documentation</a></li>
                    <li class="pull-right">
                        <a href="#">
                            <?php
                            $badge = 'badge progress-bar-success';
                            $data = $vrp->testAPI();
                            if ( !isset( $data->Status )) {
                                $badge = 'badge progress-bar-warning';
                                $data->Status = false;
                            }
                            ?>
                            <div title="Status: <?=$data->Status;?>">
                                <span class="<?=$badge;?>">&nbsp;</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="overview">1</div>
                <div role="tabpanel" class="tab-pane active" id="theme">
                    <!-- @TODO: right align active theme, to the left show theme options (e.g: featured properties, perhaps certain display items in the products, etc. -->
                    <div class="row">
                        <?php foreach ($this->available_themes as $name => $displayname):?>
                            <div class="col-sm-3">
                                <div class="text-center block"><?=$displayname;?> [<strong><?=($this->themename === $name) ? '<span class="text-success">Active</span>':'<a href="#">Activate</a>';?></strong>]</div>
                                <img src="<?=VRP_URL;?>themes/<?=$this->themename;?>/preview.png" class="theme-preview img-responsive img-thumbnail "/>
                            </div>
                        <?php endforeach;?>
                        <?php foreach ($this->available_themes as $name => $displayname):?>
                            <div class="col-sm-3">
                                <div class="text-center block"><?=$displayname;?> [<strong><a href="#">Activate</a></strong>]</div>
                                <img src="<?=VRP_URL;?>themes/<?=$this->themename;?>/preview.png" class="theme-preview img-responsive img-thumbnail "/>
                            </div>
                        <?php endforeach;?>
                        <?php foreach ($this->available_themes as $name => $displayname):?>
                            <div class="col-sm-3">
                                <div class="text-center block"><?=$displayname;?> [<strong><a href="#">Activate</a></strong>]</div>
                                <img src="<?=VRP_URL;?>themes/<?=$this->themename;?>/preview.png" class="theme-preview img-responsive img-thumbnail "/>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="api">
                    <input type="text" name="vrpAPI" value="<?=esc_attr(get_option('vrpAPI'));?>" />
                    <?=esc_attr(get_option('vrpAPI'));?>
                </div>
                <div role="tabpanel" class="tab-pane" id="support">4</div>
                <div role="tabpanel" class="tab-pane" id="documentation">5</div>
            </div>
        </div>
    </div>
</div>