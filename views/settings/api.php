
<form method="post">
    <input type="text" name="vrpAPI" value="<?= esc_attr(get_option('vrpAPI')); ?>"/>
    <?= esc_attr(get_option('vrpAPI')); ?>
    <?php wp_nonce_field('updateVRPAPISettings', 'nonceField'); ?>
</form>