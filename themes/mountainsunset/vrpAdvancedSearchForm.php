<?php
/**
 * Created by PhpStorm.
 * User: Josh Houghtelin <josh@findsomehelp.com>
 * Date: 10/23/14
 * Time: 1:35 PM
 */
global $vrp;
$searchoptions = $vrp->searchoptions();
?>
<h2>Advanced Search</h2>

<form action="<?php echo site_url(); ?>/vrp/search/results/" method="GET" id="vrp-advanced-search-form">
    <div class="large-3 columns">
        <div class="ui-widget-header ui-corner-all">
            <h4>Search Options</h4>
        </div>
        <table cellspacing="10">
            <tr>
                <td>Arrival:</td>
                <td><input type="text" name="search[arrival]" id="arrival2" value="Not Sure"></td>
            </tr>
            <tr>
                <td>Departure:</td>
                <td><input type="text" name="search[departure]" id="depart2" value="Not Sure"></td>
            </tr>
            <tr>
                <td>Adults:</td>
                <td>
                    <select name="search[Adults]">
                        <option selected="selected" value="">Any</option>
                        <?php foreach (range(1, $searchoptions->maxsleeps) as $v) : ?>
                            <option value="<?php echo esc_attr($v); ?>">
                                <?php echo esc_attr($v); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Children:</td>
                <td>
                    <!-- If selected this affects the total occupancy (search[Children] +  search[Adults]) a unit must meet -->
                    <select name="search[Children]">
                        <option value="">Any</option>
                        <?php foreach (range(1, 10) as $v) : ?>
                            <option value="<?php echo esc_attr($v); ?>">
                                <?php echo esc_attr($v); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Bedrooms:</td>
                <td>
                    <!-- search[bedrooms] - with search[showmax] set to true this field is the minimum number of
                    bedrooms a unit may have. with search[showmax] set to false (or not present) this will field
                    will set the exact number of rooms a unit may have. -->
                    <select name="search[bedrooms]" style="width:90px;">
                        <option selected="selected" value="">Any</option>
                        <?php foreach (range($searchoptions->minbaths, $searchoptions->maxbaths) as $v) : ?>
                            <option value="<?php echo esc_attr($v); ?>">
                                <?php echo esc_attr($v); ?>+
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Bathrooms:</td>
                <td>
                    <select name="search[bathrooms]" style="width:90px;">
                        <option selected="selected" value="">Any</option>
                        <?php foreach (range($searchoptions->minbaths, $searchoptions->maxbaths) as $v) : ?>
                            <option value="<?php echo esc_attr($v); ?>">
                                <?php echo esc_attr($v); ?>+
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Type:</td>
                <td>
                    <!-- search[type] - is the single unit type a guest wants to limit their search to -->
                    <select name="search[type]">
                        <option value="">Any</option>
                        <?php foreach ($searchoptions->types as $type) : ?>
                            <option value="<?php echo esc_attr($v); ?>">
                                <?php echo esc_attr($v); ?>+
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="large-9 columns">
        <div class="ui-widget-header ui-corner-all">
            <h4>Locations</h4>
        </div>
        <div style="padding:10px;">
            <ul class="advancedlist">
                <!-- search[location][] - is an array of all the locations a guest wants to limit their search to -->
                <?php foreach ($searchoptions->locations as $v) : ?>
                    <li>
                        <label>
                            <input type="checkbox" name="search[location][]" id="location_<?php echo $v; ?>"
                                   value="<?php echo esc_attr($v); ?>"/>
                            <?php echo esc_html($v); ?>
                        </label>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
        <br style="clear:both;"><br>

        <div class="ui-widget-header ui-corner-all">
            <h4>Amenities</h4>
        </div>
        <div style="padding:10px;">
            <ul class="advancedlist">
                <?php foreach ($searchoptions->attrs as $v) : ?>
                    <li>
                        <input type="checkbox" name="search[attrs][]" value="<?php echo esc_attr($v); ?>"/>
                        <label><?php echo esc_html($v); ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <br style="clear:both;">

    <!-- show -- sets the default number of results to show -->
    <input type="hidden" name="show" value="20">

    <!-- search[showmax] - Will display results that are equal to or greater then the number of
    bedrooms/bathrooms/occupancy totals selected by the guest.  If this is removed and a guest selects
    4 bedrooms then only 4 bedroom units will show.  If this is set to true and a guest selects 4 bedrooms
    then all units with 4+ bedrooms will show in the result set -->
    <input type="hidden" name="search[showmax]" value="true"/>

    <input type="submit" name="propSearch" class="ButtonView" value="Search">
</form>
