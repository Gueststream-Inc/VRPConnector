<div class="vrpgrid_3 alpha vrpsidebar">
    <div class="vrpgrid_100  resultsfound2">
        <h2>Search Availability</h2>
    </div>
  <?php global $vrp; ?>

    <form action="<?php bloginfo('url'); ?>/vrp/search/results/" method="get">
        <table>
            <tr>
                <th>
                    Check In:
                </th>
                <td>
                    <input type="text" class="input" name="search[arrival]" id="arrival"
                           value="<?php echo esc_attr($vrp->search->arrival); ?>">
                </td>
            </tr>
            <tr>
                <th>Check Out:</th>
                <td><input type="text" class="input" name="search[departure]" id="depart"
                           value="<?php echo esc_attr($vrp->search->depart); ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="propSearch" class="ButtonView rounded" value="Search">
                </td>
            </tr>
        </table>
    </form>

</div>
