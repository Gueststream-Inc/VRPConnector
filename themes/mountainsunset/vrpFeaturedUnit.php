<?php
/**
 * @file vrpFeaturedUnit.php
 * @project VRPConnector
 * @author Josh Houghtelin <josh@findsomehelp.com>
 * @created 2/24/15 1:31 PM
 */

/**
 * $data['Location']
 * $data['City']
 * $data['page_slug']
 * $data['Area']
 * $data['Name']
 * $data['Bedrooms']
 * $data['Bathrooms']
 * $data['Photo']
 * $data['Thumb']
 */
?>
<?php if(is_array($data)) : ?>
    <?php foreach($data as $unit) : ?>
        <a href="<?php echo site_url("/vrp/unit/" . $unit->page_slug); ?>"
           Title="<?php echo $unit->Name; ?>">
            <img src="<?php echo $unit->Photo; ?>">
        </a>
    <?php endforeach; ?>
    <?php elseif (is_object($data)) : ?>
    <a href="<?php echo site_url("/vrp/unit/" . $data->page_slug); ?>"
       Title="<?php echo $data->Name; ?>">
        <img src="<?php echo $data->Photo; ?>">
    </a>
<?php endif; ?>