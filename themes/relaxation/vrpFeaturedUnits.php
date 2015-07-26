<?php
/**
 * @file vrpFeaturedUnits.php
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

foreach($data as $a_featured_unit) { ?>
    <a href="/vrp/unit/<?php echo $a_featured_unit->page_slug; ?>"
       Title="<?php echo $a_featured_unit->Name; ?>"
        >
        <img src="<?php echo $a_featured_unit->Photo; ?>">
    </a>
<?php } ?>
