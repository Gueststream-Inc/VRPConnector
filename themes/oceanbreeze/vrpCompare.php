<div align="center">
    <form id="compareprops" method="get" action="">
        <table align="center" cellspacing="10" cellpadding="20">
            <tr>
                <td>Arrival:</td>
                <td>
                    <input type="text"
                           name="c[arrival]"
                           class="input"
                           id="arrival2"
                           value="<?= $_SESSION['arrival']; ?>"
                        />
                </td>
                <td>Departure:</td>
                <td>
                    <input type="text"
                           name="c[depart]"
                           class="input"
                           id="depart2"
                           value="<?= $_SESSION['depart']; ?>"
                        />
                </td>
                <td>
                    <?php foreach ($_GET['c']['compare'] as $v) { ?>
                        <input type="hidden" name="c[compare][]" value="<?= $v; ?>">
                    <?php } ?>

                    <input type="submit" class="ButtonView" value="Check Availability"></td>
            </tr>
        </table>
    </form>
</div>

<table style="margin-top:50px;">
    <thead>
        <tr>
            <th>Property</th>
            <th>Beds/Baths</th>
            <th>Max #</th>
            <th>Location</th>
            <th>Amenities</th>
            <th>Rate Estimate</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data->results as $prop){ ?>
        <tr>
            <td>
                <a href="/vrp/unit/<?= $prop->page_slug; ?>">
                    <img src="<?= $prop->Thumb; ?>" style="max-width:150px;">
                    <br>
                    <?= $prop->Name; ?>
                </a>
            </td>

            <td>
                <span><?= $prop->Bedrooms; ?> Beds / <?= $prop->Bathrooms; ?> Baths</span>
            </td>

            <td>
                <span> <?= $prop->Sleeps; ?></span>
            </td>

            <td>
                <span> <?= $prop->Location; ?></span>
            </td>

            <td>
                <ul class="listsplitter" id="listfor_<?= $prop->id; ?>">
                    <?php
                    foreach ($prop->attributes as $v):
                        echo "<li>$v->name</li>";
                    endforeach;
                    ?>
                </ul>
            </td>

            <td>
                <span>
                    <?php if ($prop->unavail != '') {
                        echo "Not Available";
                    } else {
                        ?>$<?= number_format($prop->Rate); ?>
                    <?php } ?>
                </span>
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