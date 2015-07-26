<?php
global $vrp;
?>
<style>
    .tab-content {
        display: block;
        background: #fff;
        border: 0px !important;
        padding: 7px 10px;
    }
</style>

<div class="bootstrap-wrapper">

    <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <img src="<?php echo plugins_url('/images/vrpconnector-logo.png', __FILE__);; ?>" alt="VRP Connector Logo"/>
        </div>
    </div>
    <?php if ($this->pluginNotification['message'] !== ""): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-<?= $this->pluginNotification['type']; ?> alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong><?= $this->pluginNotification['prettyType']; ?></strong> <?= $this->pluginNotification['message']; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
                <li class="active"><a href="#theme" aria-controls="theme" role="tab" data-toggle="tab">Theme</a></li>
                <li><a href="#api" aria-controls="api" role="tab" data-toggle="tab">API</a></li>
                <li><a href="#support" aria-controls="support" role="tab" data-toggle="tab">Support</a></li>
                <li><a href="#documentation" aria-controls="documentation" role="tab" data-toggle="tab">Documentation</a></li>
                <li class="pull-right">
                    <a href="#">
                        <div>
                            <span class="badge progress-bar-<?= ($this->api->available ? 'success':'warning'); ?>">&nbsp;</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="overview">
        <?php include( plugin_dir_path( __FILE__ ) . '/settings/overview.php');?>
    </div>
    <div role="tabpanel" class="tab-pane active" id="theme">
        <?php include( plugin_dir_path( __FILE__ ) . '/settings/theme.php');?>
    </div>
    <div role="tabpanel" class="tab-pane" id="api">
        <?php include( plugin_dir_path( __FILE__ ) . '/settings/api.php');?>
    </div>
    <div role="tabpanel" class="tab-pane" id="support">
        <?php include( plugin_dir_path( __FILE__ ) . '/settings/support.php');?>
    </div>
    <div role="tabpanel" class="tab-pane" id="documentation">
        <?php include( plugin_dir_path( __FILE__ ) . '/settings/documentation.php');?>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>