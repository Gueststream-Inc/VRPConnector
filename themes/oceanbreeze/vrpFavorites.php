<div align="center">
    <form id="compareprops" method="get" action="">
        <table align="center" cellspacing="10" cellpadding="20">
            <tr>
                <td>Arrival:</td>
                <td>
                    <input type="text"
                           name="arrival"
                           class="input"
                           id="arrival2"
                           value="<?php echo esc_attr($_SESSION['arrival']); ?>"
                        />
                </td>
            </tr>
            <tr>
                <td>Departure:</td>
                <td>
                    <input type="text"
                           name="depart"
                           class="input"
                           id="depart2"
                           value="<?php echo esc_attr($_SESSION['depart']); ?>"
                        />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php foreach ($_GET['favorites'] as $v) { ?>
                        <input type="hidden" name="favorites[]" value="<?php echo esc_attr($v); ?>">
                    <?php } ?>
                    <input type="submit" class="ButtonView" value="Check Availability">
                </td>
            </tr>
        </table>
    </form>
</div>

<table style="margin-top:50px;">
    <thead>
    <tr>
        <th>Property</th>
        <th>Beds</th>
        <th>Baths</th>
        <!--        <th>Max #</th>-->
        <!--        <th>Location</th>-->
        <!--        <th>Amenities</th>-->
        <th>Availability</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data->results as $prop) { ?>
        <tr id="favorite_<?php echo $prop->id ?>">
            <td>
                <a href="/vrp/unit/<?php echo esc_attr($prop->page_slug); ?>">
                    <img src="<?php echo esc_url($prop->Thumb); ?>" style="max-width:150px;">
                    <?php echo esc_html($prop->Name); ?>
                </a>
            </td>

            <td>
                <span>
                    <?php echo esc_html($prop->Bedrooms); ?>
                </span>
            </td>

            <td>
                </span>
                <?php echo esc_html($prop->Bathrooms); ?>
                </span>
            </td>

            <!--            <td>-->
            <!--                <span> --><?php //echo esc_html($prop->Sleeps); ?><!--</span>-->
            <!--            </td>-->

            <!--            <td>-->
            <!--                <span> --><?php //echo esc_html($prop->Location); ?><!--</span>-->
            <!--            </td>-->

            <!--            <td>-->
            <!--                <ul class="listsplitter" id="listfor_--><?php //echo esc_attr($prop->id); ?><!--">-->
            <!--                    --><?php //foreach ($prop->attributes as $v) {
            //                        echo '<li>' . esc_html($v->name) . '</li>';
            //                    } ?>
            <!--                </ul>-->
            <!--            </td>-->

            <td>
                <span>
                    <?php if ($prop->unavail != '') {
                        echo "Not Available";
                    } else {
                        echo "Available";
                    } ?>
                </span>
            </td>
            <td>
                <button class="vrp-favorite-button" data-unit="<?php echo $prop->id ?>"></button>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div class="clear"></div>
<div style="text-align:right;">
    <small>
        * Highest Rate Shown. Not based on occupancy.
    </small>
</div>
