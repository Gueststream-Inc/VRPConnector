<?php global $vrp; ?>
<style>
    .tab-content {
        display:block;

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
                    <li class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
                    <li><a href="#theme" aria-controls="theme" role="tab" data-toggle="tab">Theme</a></li>
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
                <div role="tabpanel" class="tab-pane active" id="overview">1</div>
                <div role="tabpanel" class="tab-pane" id="theme">2</div>
                <div role="tabpanel" class="tab-pane" id="api">
                    <form method="post" action="options.php">
                        <?php settings_fields('VRPConnector'); ?>
                        <?php do_settings_sections('VRPConnector'); ?>
                        <?php submit_button(); ?>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="support">4</div>
                <div role="tabpanel" class="tab-pane" id="documentation">5</div>
            </div>
        </div>
    </div>
</div>