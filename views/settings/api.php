<div class="row">
    <div class="col-sm-8">

        <h3>Production API Thresholds</h3>
        <div class="progress">
            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 100%">
                <i class="fa fa-fw fa-minus"></i>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 100%;">
                <i class="fa fa-fw fa-minus"></i>
            </div>
        </div>

        <h3>Developer API Thresholds</h3>
        <div class="progress">
            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 100%">
                <i class="fa fa-fw fa-minus"></i>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;  width: 100%">
                <i class="fa fa-fw fa-minus"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <h5><strong>License</strong></h5>
        Next Renewal: <strong><?=date('m/d/Y',strtotime("+30 days"));?></strong>
        <hr />
        <h5><strong>Status</strong></h5>
        API is currently:
        <span class="text-<?= ($this->api->available? 'success':'warning'); ?>">
            <strong><?= ($this->api->available? 'Online':'Offline'); ?></strong>
        </span>
        <br />
        API Key: <strong><?= esc_attr(get_option('vrpAPI')); ?></strong>
        <hr />
        <form method="post"
              action="<?=admin_url('options-general.php?page=VRPConnector&vrpUpdateSection=updateVRPAPISettings') ;?>"
              name="vrpAPISettings">
            <div class="form-group">
                <select autocomplete="off" class="form-control" name="vrpPluginMode">
                    <option>Select your operating mode</option>
                    <option <?= esc_attr(get_option('vrpPluginMode')) === 'developer' ? 'selected':''; ?> value="developer">Developer</option>
                    <option <?= esc_attr(get_option('vrpPluginMode')) === 'live' ? 'selected':''; ?> value="live">Live</option>
                </select>
            </div>

            <div class="form-group" <?= esc_attr(get_option('vrpPluginMode')) !== 'live' ? 'style="display:none;"':''; ?>>
                <div class="input-group">
                    <input class="form-control"
                           type="text"
                           name="vrpAPI"
                           autocomplete="off"
                           value="<?= esc_attr(get_option('vrpAPI')); ?>"
                        />
                    <span class="input-group-btn">
                        <input type="submit" value="Update" class="btn btn-<?=$this->api->available? 'success' : 'warning';?>" />
                    </span>
                </div>
            </div>
            <?php wp_nonce_field('updateVRPAPISettings', 'nonceField'); ?>
        </form>

    </div>
</div>