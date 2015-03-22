<?php

class mountainsunset
{
    function actions()
    {
        add_action('wp_enqueue_scripts', array($this, 'my_scripts_method'));
        add_action('wp_print_styles', array($this, 'add_my_stylesheet'));
    }

    function my_scripts_method()
    {
        if (file_exists(get_stylesheet_directory() . '/vrp/css/jquery-ui-1.11.2.custom/jquery-ui.js')) {
            wp_register_script('VRPjQueryUI', get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.11.2.custom/jquery-ui.js');
        } else {
            wp_register_script(
                'VRPjQueryUI',
                plugins_url('/mountainsunset/css/jquery-ui-1.11.2.custom/jquery-ui.js', dirname(__FILE__)),
                array('jquery')
            );
        }

        wp_enqueue_script('VRPjQueryUI');

        if (file_exists(get_stylesheet_directory() . '/vrp/js/js.js')) {
            wp_enqueue_script('VRPthemeJS', get_stylesheet_directory_uri() . '/vrp/js/js.js');
        } else {
            wp_enqueue_script('VRPthemeJS', plugins_url('/mountainsunset/js/js.js', dirname(__FILE__)));
        }
		global $wp_query;

        wp_register_script('vrpMapModule', plugins_url('/mountainsunset/js/vrp.map.js', dirname(__FILE__)));
        wp_enqueue_script('vrpMapModule');
        wp_register_script('vrpMRespondModule', plugins_url('/mountainsunset/js/vrp.mRespond.js', dirname(__FILE__)));
        wp_enqueue_script('vrpMRespondModule');

        wp_register_script('googleMap', 'https://maps.googleapis.com/maps/api/js?v=3.exp');
        wp_enqueue_script('googleMap');
//		if (isset($wp_query->query_vars['action'])) {
//			if ('unit' == $wp_query->query_vars['action']){
//			}
//		}

        $script_vars = [
            'site_url' => site_url(),
            'stylesheet_dir_url' => get_stylesheet_directory_uri(),
            'plugin_url' => plugins_url('',dirname(dirname(__FILE__)))
        ];
        wp_localize_script('VRPthemeJS','url_paths',$script_vars);

    }

    function add_my_stylesheet()
    {


        wp_enqueue_style('FontAwesome',
            plugins_url('/mountainsunset/css/font-awesome.css', dirname(__FILE__)));

        if (file_exists(get_stylesheet_directory() . '/vrp/css/jquery-ui-1.11.2.custom/jquery-ui.css')) {
            wp_enqueue_style('VRPjQueryUISmoothness', get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.11.2.custom/jquery-ui.css');
        } else {
            wp_enqueue_style('VRPjQueryUISmoothness',
                plugins_url('/mountainsunset/css/jquery-ui-1.11.2.custom/jquery-ui.css', dirname(__FILE__)));
        }

        if (!file_exists(get_stylesheet_directory() . '/vrp/css/css.css')) {
            $myStyleUrl = plugins_url(
                '/mountainsunset/css/css.css', dirname(__FILE__)
            );
        } else {
            $myStyleUrl = get_stylesheet_directory_uri() . '/vrp/css/css.css';
        }

        wp_register_style('themeCSS', $myStyleUrl);
        wp_enqueue_style('themeCSS');
    }
}

function generateList($list, $options = [])
{

    $configuredOptions = ['attr' => '', 'child' => 'children'];

    if(!empty($options['child'])) {
        $configuredOptions['child'] = $options['child'];
    }
    if(!empty($options['attr'])) {
        $configuredOptions['attr'] = $options['attr'];
    }

    $options = (object) $configuredOptions;

    $recursive = function ($dataset, $child = FALSE, $options) use ( &$recursive ) {

        $html = "<ul $options->attr>"; // Open the menu container

        foreach($dataset as $title => $properties) {

            $subMenu = '';

            $children = (!empty($properties[$options->child]) ? true : false);

            if($children)
                $subMenu = $recursive($properties[$options->children], TRUE, $options);

            $html .= '<li class="' . (!empty($properties['class']) ? $properties['class'] : '') . '"><a class="'
                . (!empty($properties['disabled']) && $properties['disabled'] === true ? ' disabled ' : '')
                . (!empty($properties['selected']) ? ' current ' : '') . '" href="?'
                . $properties['pageurl']
                . 'show=' . $properties['show']
                . '&page=' . $properties['page']
                . '">' . $title . '</a>'
                . $subMenu . '</li>';

            unset($children, $subMenu);

        }
        return $html . "</ul>";
    };

    return $recursive($list, FALSE, $options);

}

function generateSearchQueryString() {

    $fieldString = '';

    foreach ($_GET['search'] as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $v):
                $fieldString .= 'search[' . $key . '][]=' . $v . '&';
            endforeach;
        } else {
            $fieldString .= 'search[' . $key . ']=' . $value . '&';
        }
    }

    return rtrim($fieldString, '&');
}

function vrp_pagination($totalPages, $curPage = 1)
{

    $_SESSION['pageurl'] = $pageurl = generateSearchQueryString();
    $curPage = (int) esc_attr($curPage);
    $pageurl = esc_attr($pageurl);
    $show = ( !empty($_GET['show']) ? esc_attr($_GET['show']) : 10 );

    $totalRange = (int) ( $totalPages > 5 ? $curPage + 4 : $totalPages );
    $startRange = (int) ( $curPage > 5 ? $curPage - 4 : 1 );

    $list = [];

    $list['Prev'] = ['pageurl' => $pageurl, 'show' => $show, 'page' => ($curPage - 1), 'class' => 'button', 'disabled' => ($curPage !== 1 ? false : true)];

    $list[$curPage] = ['pageurl' => $pageurl, 'show' => $show, 'page' => $curPage];


    foreach (range($startRange, $totalRange) as $incPage) {

        $incPage = (int) esc_attr($incPage);

        if($curPage === $incPage) {
            $list[$incPage]['selected'] = ($curPage === $incPage ? true : false);
            continue;
        }

        $list[$incPage] = ['pageurl' => $pageurl, 'show' => $show, 'page' => $incPage];

    }

    $list['Last'] = ['active' => false, 'pageurl' => $pageurl, 'show' => $show, 'page' => ($curPage - 1), 'class' => 'button', 'disabled' => ($totalPages > 5 ? false : true)];
    $list['Next'] = ['active' => false, 'pageurl' => $pageurl, 'show' => $show, 'page' => ($curPage + 1), 'class' => 'button', 'disabled' => ($curPage < $totalPages ? false : true)];

    return generateList($list, ['attr' => 'class="vrp-cd-pagination"']);
}

function vrp_paginationmobile($totalpages, $page = 1)
{
    $fields_string = "";
    foreach ($_GET['search'] as $key => $value) {
        $fields_string .= 'search[' . $key . ']=' . $value . '&';
    }
    rtrim($fields_string, '&');
    $pageurl = $fields_string;
    $_SESSION['pageurl'] = $pageurl;
    if (isset($_GET['show'])) {
        $show = $_GET['show'];
    } else {
        $show = 5;
    }
    if ($totalpages == 1) {
        return;
    }

    if ($page > 1) {
        $p = $page - 1;
        echo '<a href="?' . esc_attr($pageurl) . 'show=' . esc_attr($show) . '&page=' . esc_attr($p) .'" data-icon="arrow-l" data-role="button">Prev</a>';
    }

    if ($page < $totalpages) {
        $p = $page + 1;
        echo '<a href="?' . esc_attr($pageurl) . 'show=' . esc_attr($show) . '&page=' . esc_attr($p) .'" data-icon="arrow-r" data-role="button">Next</a>';
    }
}

function vrp_pagination2($totalpages, $page = 1)
{
    /* foreach ($_GET['search'] as $key => $value) {
      $fields_string .= 'search[' . $key . ']=' . $value . '&';
      }
      rtrim($fields_string, '&'); */
    $beds = "";
    if (isset($_GET['beds'])) {
        $beds = (int) $_GET['beds'];
        $beds = "&beds=" . $beds;
    }

    if (isset($_GET['minbed'])) {
        $minbed = $_GET['minbed'];
        $maxbed = $_GET['maxbed'];
        $beds = "&minbed=" . $minbed . "&maxbed=" . $maxbed;
    }
    $pageurl = "";
    if (isset($_GET['search'])) {
        foreach ($_GET['search'] as $k => $v):
            $pageurl .= "search[$k]=$v&";
        endforeach;
    }
    if ($totalpages == 1) {
        return;
    }
    echo "<ul class='vrp-pagination'>";
    if ($page > 1) {
        $p = $page - 1;
        echo '<li><a href="?' . esc_attr($pageurl) . 'page=' . esc_attr($p) . esc_attr($beds) . '">Prev</a></li>';
    }
    foreach (range(1, $totalpages) as $p) {
        if ($page == $p) {
            echo '<li role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text"><b class="chosenone">' . esc_attr($p) . '</b></span></li>';
        } else {
            echo '<li><a href="?' . esc_attr($pageurl) . 'page=' . esc_attr($p) . esc_attr($beds) . '">' . esc_attr($p) . '</a></li>';
        }
    }
    if ($page < $totalpages) {
        $p = $page + 1;
        echo '<li><a href="? ' . esc_attr($pageurl) . 'page=' . esc_attr($p) . esc_attr($beds) . '">Next</a></li>';
    }
    echo "</ul>";
}

function vrpsortlinks($unit)
{

    if (isset($_GET['search']['order'])) {
        $order = $_GET['search']['order'];
    } else {
        $order = "low";
    }

    $fields_string = "";
    foreach ($_GET['search'] as $key => $value) {
        if ($key == 'sort') {
            continue;
        }
        if ($key == 'order') {
            continue;
        }
        $fields_string .= 'search[' . $key . ']=' . $value . '&';
    }
    rtrim($fields_string, '&');
    $pageurl = $fields_string;


    $sortoptions = array("Bedrooms");

    if (isset($unit->Rate)) {
        $sortoptions[] = "Rate";
    }

    echo "<select class='vrpsorter'>";
    echo "<option value=''>Sort By</option>";

    if (isset($_GET['search']['sort'])) {
        $sort = $_GET['search']['sort'];
    } else {
        $sort = "";
    }
    $show = ( !empty($_GET['show']) ? esc_attr($_GET['show']) : 10 );
    foreach ($sortoptions as $s) {

        $s = $show;
        $pageurl = esc_attr($pageurl);
        $order = esc_attr($order);

        if ($sort == $s) {
            if ($order == "low") {
                $order = "high";
                $other = "low";
            } else {
                $order = "low";
                $other = "high";
            }

            echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=' . $order . '">' . $s . '(' . $other . ' to ' . $order . ')</option>';
            echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=' . $order .'">' . $s . '(' . $order . 'to' . $other . ')</option>';
            continue;
        }

        echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=low">' . $s . '(low to high)</option>';
        echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=high">' . $s . '(high to low)</option>';
    }
     echo "</select>";
}

function vrpsortlinks2($unit)
{

    if (isset($_GET['search']['order'])) {
        $order = $_GET['search']['order'];
    } else {
        $order = "low";
    }

    $fields_string = "";
    foreach ($_GET['search'] as $key => $value) {
        if ($key == 'sort') {
            continue;
        }
        if ($key == 'order') {
            continue;
        }
        $fields_string .= 'search[' . $key . ']=' . $value . '&';
    }
    rtrim($fields_string, '&');
    $pageurl = $fields_string;
    if (isset($_GET['beds'])) {
        $pageurl .= "beds=" . $_GET['beds'] . "&";
    }

    if (isset($_GET['minbed'])) {
        $pageurl .= "minbed=" . $_GET['minbed'] . "&maxbed=" . $_GET['maxbed'] . "&";
    }
    $sortoptions = array("Bedrooms" => "Bedrooms", "minrate" => "Minimum Rate", "maxrate" => "Maximum Rate");

    if (isset($unit->Rate)) {
        $sortoptions[] = "Rate";
    }
    echo "<select class='vrpsorter ui-widget ui-state-default' style='font-size:11px;'>";
    if (isset($_GET['search']['sort'])) {
        $sort = $_GET['search']['sort'];
    } else {
        $sort = "";
    }
    if (isset($_GET['show'])) {
        $show = $_GET['show'];
    } else {
        $show = 10;
    }
    foreach ($sortoptions as $s => $val) {

        if ($sort == $s) {
            if ($order == "low") {
                $order = "high";
                $other = "low";
            } else {
                $order = "low";
                $other = "high";
            }

            echo '<option value="?' . esc_attr($pageurl) . 'search[sort]=' . esc_attr($s) . '&show=' . esc_attr($show) . '&search[order]=' . esc_attr($order) . '" selected="selected">' . esc_attr($val) . '(' . esc_attr($other) . ' to ' .  esc_attr($order) . ')</option>';
            echo '<option value="?' . esc_attr($pageurl) . 'search[sort]=' . esc_attr($s) . '&show=' . esc_attr($show) . '&search[order]=' . esc_attr($order) .'">' . esc_attr($val) . '(' . esc_attr($order) . ' to ' . esc_attr($other) . ')</option>';
            continue;
        }

        echo '<option value="?' . esc_attr($pageurl) . 'search[sort]=' . esc_attr($s) . '&show=' . esc_attr($show) . '&search[order]=low">' . esc_attr($val) . '(low to high)</option>';
        echo '<option value="?' . esc_attr($pageurl) . 'search[sort]=' . esc_attr($s) . '&show=' . esc_attr($show) . '&search[order]=high">' . esc_attr($val) . '(high to low)</option>';
    }
    echo "</select>";
}

function vrp_resultsperpage()
{
    $fields_string = "";
    foreach ($_GET['search'] as $key => $value) {
        $fields_string .= 'search[' . $key . ']=' . $value . '&';
    }

    rtrim($fields_string, '&');
    $pageurl = $fields_string;

    if (isset($_GET['show'])) {
        $show = (int) $_GET['show'];
    } else {
        $show = 10;
    }
    echo "<select name='resultCount' class='vrpshowing'>";
    echo "<option value=''>Show</option>";
    foreach (array(10, 20, 30) as $v) {
        echo '<option ' . (!empty($_GET['show']) && (int) $_GET['show'] == $v ? 'selected="selected"' : '') . ' value="?' . esc_attr($pageurl) . '&show=' . esc_attr($v) . '">' . esc_attr($v) . '</option>';
    }
    echo "</select>";
}

function dateSeries($start_date, $num)
{
    $dates = array();

    $dates[0] = $start_date;
    for ($i = 0; $i < $num; $i ++) {
        $start = strtotime(end($dates));
        $day = mktime(0, 0, 0, date("m", $start), date("d", $start) + 1, date("Y", $start));
        $dates[] = date('Y-m-d', $day);
    }
    return $dates;
}

function daysTo($from, $to, $round = true)
{
    $from = strtotime($from);
    $to = strtotime($to);
    $diff = $to - $from;
    $days = $diff / 86400;
    return $round == true ? floor($days) : round($days, 2);
}

function vrpCalendar($r, $totalMonths = 3)
{

    $datelist = array();
    $arrivals = array();
    $departs = array();
    foreach ($r as $v) {
        $from_date = $v->start_date;
        $arrivals[] = $from_date;
        $to_date = $v->end_date;
        $departs[] = $to_date;
        $num = daysTo($from_date, $to_date);
        $datelist[] = dateSeries($from_date, $num);
    }

    $final_date = array();
    foreach ($datelist as $v) {
        foreach ($v as $v2) {
            $final_date[] = $v2;
        }
    }
    //echo "<pre>";
    //print_r($final_date);
    //echo "</pre>";
    $today = strtotime(date("Y") . "-" . date("m") . "-01");
    $calendar = new \Gueststream\Calendar(date('Y-m-d'));
    $calendar->link_days = 0;
    $calendar->highlighted_dates = $final_date;
    $calendar->arrival_dates = $arrivals;
    $calendar->depart_dates = $departs;
    if (isset($_GET["debug"])) {
    }
    /*  $nextyear = date("Y", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
      $nextmonth = date("m", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
      $nextyear2 = date("Y", mktime(0, 0, 0, date("m") + 2, date("d"), date("Y")));
      $nextmonth2 = date("m", mktime(0, 0, 0, date("m") + 2, date("d"), date("Y")));
     *
     */
    $theKey = "<br style=\"clear:both;\" /><br/><div id=\"calKey\"><div style=\"float:left;\"><span style=\"float:left;display:block;width:15px;height:15px;background:#ffffff;border:1px solid #404040;\"> &nbsp;</span> <span style=\"float:left;\">&nbsp; Available</span> <span style=\"float:left;display:block;width:15px;height:15px;background:#BDBDBD;margin-left:10px;border:1px solid #404040;\"> &nbsp;</span> <span style=\"float:left;\">&nbsp; Unavailable</span><br style=\"clear:both;\" /></div><br style=\"clear:both;\" /></div>";
    $ret = "";
    $x = 0;
    $curYear = date('Y');
    for ($i = 0; $i < $totalMonths; $i ++) {

        $nextyear = date("Y", mktime(0, 0, 0, date("m", $today) + $i, date("d", $today), date("Y", $today)));
        $nextmonth = date("m", mktime(0, 0, 0, date("m", $today) + $i, date("d", $today), date("Y", $today)));

        $ret .= $calendar->output_calendar($nextyear, $nextmonth);
        if ($x == 3) {
            // $ret.="<br style=\"clear:both;\" /><br style=\"clear:both;\" />";
            $x = - 1;
        }
        $x ++;
    }


    return "" . $ret . $theKey;
}