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
            wp_register_script('VRPjQueryUI', get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.11.2.custom/jquery-ui.js', array( 'jquery' ) );
        } else {
            wp_register_script( 'VRPjQueryUI', plugins_url('/mountainsunset/css/jquery-ui-1.11.2.custom/jquery-ui.js', dirname(__FILE__)), array('jquery') );
        }
        wp_enqueue_script('VRPjQueryUI');

        if (file_exists(get_stylesheet_directory() . '/vrp/js/vrp.namespace.js')) {
            wp_register_script('vrpNamespace', get_stylesheet_directory_uri() . '/vrp/js/vrp.namespace.js', array( 'jquery' ) );
        } else {
            wp_register_script('vrpNamespace', plugins_url('/mountainsunset/js/vrp.namespace.js', dirname(__FILE__)), array( 'jquery' ) );
        }
        wp_enqueue_script('vrpNamespace');


        if (file_exists(get_stylesheet_directory() . '/vrp/js/vrp.mRespond.js')) {
            wp_register_script('vrpMRespondModule', get_stylesheet_directory_uri() . '/vrp/js/vrp.mRespond.js', array( 'jquery' ) );
        } else {
            wp_register_script('vrpMRespondModule', plugins_url('/mountainsunset/js/vrp.mRespond.js', dirname(__FILE__)), array( 'jquery' ) );
        }
        wp_enqueue_script('vrpMRespondModule');


        if (file_exists(get_stylesheet_directory() . '/vrp/js/vrp.ui.js')) {
            wp_register_script('vrpUIModule', get_stylesheet_directory_uri() . '/vrp/js/vrp.ui.js', array( 'jquery' ) );
        } else {
            wp_register_script('vrpUIModule', plugins_url('/mountainsunset/js/vrp.ui.js', dirname(__FILE__)), array( 'jquery' ) );
        }
        wp_enqueue_script('vrpUIModule');


        if (file_exists(get_stylesheet_directory() . '/vrp/js/vrp.queryString.js')) {
            wp_register_script('vrpQueryStringModule', get_stylesheet_directory_uri() . '/vrp/js/vrp.queryString.js', array( 'jquery' ) );
        } else {
            wp_register_script('vrpQueryStringModule', plugins_url('/mountainsunset/js/vrp.queryString.js', dirname(__FILE__)), array( 'jquery' ));
        }
        wp_enqueue_script('vrpQueryStringModule');


        wp_register_script('googleMap', 'https://maps.googleapis.com/maps/api/js?v=3.exp');
        wp_enqueue_script('googleMap');


        if (file_exists(get_stylesheet_directory() . '/vrp/js/js.js')) {
            wp_enqueue_script('VRPthemeJS', get_stylesheet_directory_uri() . '/vrp/js/js.js', array( 'jquery' ) );
        } else {
            wp_enqueue_script('VRPthemeJS', plugins_url('/mountainsunset/js/js.js', dirname(__FILE__)), array( 'jquery' ) );
        }

        // Result List Map
        if (file_exists(get_stylesheet_directory() . '/vrp/js/vrp.resultListMap.js')) {
            wp_enqueue_script('VRPResultMap', get_stylesheet_directory_uri() . '/vrp/js/vrp.resultListMap.js', array( 'jquery','googleMap' ) );
        } else {
            wp_enqueue_script('VRPResultMap', plugins_url('/mountainsunset/js/vrp.resultListMap.js', dirname(__FILE__)), array( 'jquery','googleMap' ) );
        }

        // Unit Page
        if (file_exists(get_stylesheet_directory() . '/vrp/js/vrp.unit.js')) {
            wp_enqueue_script('VRPUnitPage', get_stylesheet_directory_uri() . '/vrp/js/vrp.unit.js', array( 'jquery','googleMap' ) );
        } else {
            wp_enqueue_script('VRPUnitPage', plugins_url('/mountainsunset/js/vrp.unit.js', dirname(__FILE__)), array( 'jquery','googleMap' ) );
        }

        $script_vars = [
            'site_url' => site_url(),
            'stylesheet_dir_url' => get_stylesheet_directory_uri(),
            'plugin_url' => plugins_url('',dirname(dirname(__FILE__)))
        ];
        wp_localize_script('VRPthemeJS','url_paths',$script_vars);

    }

    function add_my_stylesheet()
    {
         if (file_exists(get_stylesheet_directory() . '/vrp/css/font-awesome.css')) {
            wp_enqueue_style('FontAwesome', get_stylesheet_directory_uri() . '/vrp/css/font-awesome.css');
        } else {
            wp_enqueue_style('FontAwesome', plugins_url('/mountainsunset/css/font-awesome.css', dirname(__FILE__)));
        }


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
                . '&show=' . $properties['show']
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

    foreach (range($startRange, $totalRange) as $incPage) {

        $incPage = (int) esc_attr($incPage);

        if($curPage === $incPage) {
            $list[$curPage] = ['pageurl' => $pageurl, 'show' => $show, 'page' => $curPage, 'selected' => true];
            continue;
        }

        $list[$incPage] = ['pageurl' => $pageurl, 'show' => $show, 'page' => $incPage];

    }

    $list['Last'] = ['active' => false, 'pageurl' => $pageurl, 'show' => $show, 'page' => $totalPages, 'class' => 'button', 'disabled' => ($totalPages > 5 ? false : true)];
    $list['Next'] = ['active' => false, 'pageurl' => $pageurl, 'show' => $show, 'page' => ($curPage + 1), 'class' => 'button', 'disabled' => ($curPage < $totalPages ? false : true)];

    return generateList($list, ['attr' => 'class="vrp-cd-pagination"']);
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

function vrp_resultsperpage()
{
    $fields_string = "";
    foreach ($_GET['search'] as $key => $value) {
        $fields_string .= 'search[' . $key . ']=' . $value . '&';
    }

    $fields_string = rtrim($fields_string, '&');
    $pageurl = $fields_string;

    if (isset($_GET['show'])) {
        $show = (int) $_GET['show'];
    } else {
        $show = 10;
    }
    echo "<select autocomplete='off' name='resultCount' class='vrpshowing'>";
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

function vrpCalendar($r, $totalMonths = 3) {

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

    $today = strtotime(date("Y") . "-" . date("m") . "-01");
    $calendar = new \Gueststream\Calendar(date('Y-m-d'));
    $calendar->link_days = 0;
    $calendar->highlighted_dates = $final_date;
    $calendar->arrival_dates=$arrivals;
    $calendar->depart_dates=$departs;
    $theKey = "<div class=\"calkey\" style=\"float:left;\"><span style=\"float:left;display:block;width:15px;height:15px;border:1px solid #404040;\" class=\"isavailable\"> &nbsp;</span> <span style=\"float:left;\">&nbsp; Available</span> <span style=\"float:left;display:block;width:15px;height:15px;;margin-left:10px;border:1px solid #404040;\" class=\"notavailable highlighted\"> &nbsp;</span> <span style=\"float:left;\">&nbsp; Unavailable</span><span style=\"margin-left:10px;float:left;display:block;width:15px;height:15px;border:1px solid #404040;\" class=\"isavailable dDate\"></span><span style=\"float:left;\">&nbsp; Check-In Only</span><span style=\"margin-left:10px;float:left;display:block;width:15px;height:15px;border:1px solid #404040;\" class=\"isavailable aDate\"></span><span style=\"float:left;\">&nbsp; Check-Out Only</span><br style=\"clear:both;\" /></div><br style=\"clear:both;\" />";
    $ret = "";
    $x = 0;
    $curYear = date('Y');
    for ($i = 0; $i <= $totalMonths; $i++) {

        $nextyear = date("Y", mktime(0, 0, 0, date("m", $today) + $i, date("d", $today), date("Y", $today)));
        $nextmonth = date("m", mktime(0, 0, 0, date("m", $today) + $i, date("d", $today), date("Y", $today)));

        $ret.=$calendar->output_calendar($nextyear, $nextmonth);
        if ($x == 3) {
            $ret.="";
            $x = -1;
        }
        $x++;
    }

    return "" . $ret . $theKey;
}