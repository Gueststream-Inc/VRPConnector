<?php

namespace Gueststream;

/**
 * VRPConnector Class
 */

class VRPConnector
{
    private $apiKey;                                // Gueststream.net API Key
    private $apiURL = "https://www.gueststream.net/api/v1/";     // Gueststream.net API Endpoint
    private $allowCache = true;                     // @todo - Remove this.
    public $theme = "";                            // Full path to plugin theme folder
    public $themename = "";                        // Plugin theme name.
    public $default_theme_name = "mountainsunset"; // Default plugin theme name.
    public $available_themes = [
                                'mountainsunset' => 'Mountain Sunset',
                                 'oceanbreeze' => 'Ocean Breeze'
                                ];
    public $otheractions = array();                //
    public $time;                                  // Time (in seconds?) spent making calls to the API
    public $debug = array();                       // Container for debug data

    /**
     * Class Construct
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->apiKey = get_option('vrpAPI');

        if ($this->apiKey == '') {
            add_action('admin_notices', array($this, 'notice'));
        }

        $this->setTheme();
        $this->actions();
        $this->themeActions();
    }

    /**
     * Class Destruct w/basic debugging.
     */
    public function __destruct()
    {
        if (!isset($_GET['showdebug'])) {
            return false;
        }

        if (!isset($_GET['action'])) {
            return false;
        }

        echo "<div style='position:absolute;left:0;width:100%;background:white;color:black;'>";
        echo "API Time Spent: " . $this->time . "<br/>";
        echo "GET VARIABLES:<br><pre>";
        print_r($_GET);
        echo "</pre>";
        echo "Debug VARIABLES:<br><pre>";
        print_r($this->debug);
        echo "</pre>";
        echo "Post Type: " . $wp->query_vars["post_type"];
        echo "</div>";
    }

    /**
     * init WordPress Actions, Filters & shortcodes
     */
    public function actions()
    {
        if(is_admin()){
            add_action('admin_menu', array($this, 'setupPage'));
            add_action('admin_init', array($this, 'registerSettings'));
        }

        // Actions
        add_action("init", array($this, "ajax"));
        add_action("init", array($this, "sitemap"));
        add_action('init', array($this, "featuredunit"));
        add_action("init", array($this, "otheractions"));
        add_action('init', array($this, "do_rewrite11"));
        add_action('init', array($this, "villafilter"));
        add_action('cacheClear', array($this, "clearCache"), 1, 3);
        add_action('parse_request', array($this, 'router'));

        // Filters
        add_filter('robots_txt', array($this, 'robots_mod'), 10, 2);
        add_filter('query_vars', array($this, 'wp_insertMyRewriteQueryVars'));
        remove_filter('template_redirect', 'redirect_canonical');

        if (isset($_GET['action'])) {
            remove_filter('the_content', 'wptexturize');
            remove_filter('the_content', 'wpautop');
        }

        // Shortcodes

        add_shortcode("vrpUnits", array($this, "vrpUnits"));
        add_shortcode("vrpSearch", array($this, "vrpSearch"));
        add_shortcode("vrpSearchForm", array($this, "vrpSearchForm"));
        add_shortcode("vrpAdvancedSearchForm", array($this, "vrpAdvancedSearchForm"));
        add_shortcode("vrpComplexes", array($this, "vrpComplexes"));
        add_shortcode("vrpComplexSearch", array($this, "vrpComplexSearch"));
        //add_shortcode("vrpAreaList", array($this, "vrpAreaList"));
        add_shortcode("vrpSpecials", array($this, "vrpSpecials"));
        //add_shortcode("vrpLinks", array($this, "vrpLinks"));
        add_shortcode("vrpCompare", array($this, "vrpCompare"));
        add_shortcode("vrpshort", array($this, "vrpShort"));
        add_shortcode("vrpFeaturedUnit", array($this, "vrpFeaturedUnit"));
    }

    /**
     * Set the plugin theme used & include the theme functions file.
     */
    public function setTheme()
    {
        $plugin_theme_Folder = VRP_PATH . 'themes/';
        $theme               = get_option('vrpTheme');

        if (!$theme) {
            $theme       = $this->default_theme_name;
            $this->themename = $this->default_theme_name;
            $this->theme = $plugin_theme_Folder . $this->default_theme_name;
        } else {
            $this->theme     = $plugin_theme_Folder . $theme;
            $this->themename = $theme;
        }
        $this->themename = $theme;

        if (file_exists(get_stylesheet_directory() . "/vrp/functions.php")) {
            include get_stylesheet_directory() . "/vrp/functions.php";
        } else {
            include $this->theme . "/functions.php";
        }
    }

    public function themeActions()
    {
        $theme = new $this->themename;
        if (method_exists($theme, "actions")) {
            $theme->actions();
        }
    }

    public function otheractions()
    {
        if (isset($_GET['otherslug']) && $_GET['otherslug'] != '') {
            $theme = $this->themename;
            $theme = new $theme;
            $func  = $theme->otheractions;
            $func2 = $func[$_GET['otherslug']];
            call_user_method($func2, $theme);
        }
    }

    /**
     * Uses built-in rewrite rules to get pretty URL. (/vrp/)
     */
    public function do_rewrite11()
    {
        add_rewrite_rule('vrp/([^/]+)/?([^/]+)/?$', '?action=$1&slug=$2', 'top');
        //add_rewrite_rule('^vrp/([^/]*)/([^/]*)/?','index.php?action=$matches[1]&slug=$matches[2]','top');
    }

    /**
     * Sets up action and slug as query variable.
     *
     * @param $vars [] $vars Query String Variables.
     *
     * @return $vars[]
     */
    public function wp_insertMyRewriteQueryVars($vars)
    {
        array_push($vars, 'action', 'slug', 'other');
        return $vars;
    }

    /**
     * Checks to see if dws_slug is active, if so, sets up a page.
     *
     * @return bool
     */
    public function router()
    {

        if (!isset($_GET['action'])) {
            return false;
        }

        if ($_GET['action'] == 'xml') {
            $this->xmlexport();
        }

        if ($_GET['action'] == 'flipkey') {
            $this->getflipkey();
        }

        add_filter('the_posts', array($this, "filterPosts"));
    }

    /**
     * @param $posts
     *
     * @return array
     */
    public function filterPosts($posts)
    {
        if (!isset($_GET['action'])) {
            return false;
        }
        $pagetitle = "";
        $action    = $_GET['action'];

        switch ($action) {
            case "unit": // If Unit Page.
                $this->time = microtime(true);
                $slug       = $_GET['slug'];
                $data2      = $this->call("getunit/" . $slug);
                $data       = json_decode($data2);

                if (!isset($data->id)) {
                    global $wp_query;
                    $wp_query->is_404 = true;
                }
                $_GET['API'] = "YES";

                $this->time = round((microtime(true) - $this->time), 4);
                $pagetitle  = $data->Name;

                if (isset($data->Error)) {
                    $content = $this->loadTheme("error", $data);
                } else {
                    $content = $this->loadTheme("unit", $data);
                }
                break;
            case "complex": // If Complex Page.
                $this->time = microtime(true);
                $slug       = $_GET['slug'];
                $data2      = $this->call("getcomplex/" . $slug);
                $data       = json_decode($data2);

                $_GET['API'] = "YES";

                $this->time = round((microtime(true) - $this->time), 4);
                $pagetitle  = $data->name;

                if (isset($data->Error)) {
                    $content = $this->loadTheme("error", $data);
                } else {
                    $content = $this->loadTheme("complex", $data);
                }
                break;
            case "special": // If Special Page.

                $slug = $_GET['slug'];

                $data2 = $this->call("getspecial/" . $slug);
                $data  = json_decode($data2);
                if (!isset($data->Error)) {
                    $this->cache($action, $slug, $data2);

                    $_GET['API'] = "YES";
                }

                $pagetitle = $data->title;
                $content   = $this->loadTheme("specials", $data);

                break;
            case "search": // If Search Page.

                $this->time = microtime(true);
                $data       = $this->search();
                //print_r($data);
                $this->time = round((microtime(true) - $this->time), 4);
                $time1      = microtime(true);
                $data       = json_decode($data);
                //print_r($data);
                $time2 = round((microtime(true) - $time1), 4);
                if (isset($_GET['showdebug'])) {
                    /* echo "<pre>";
                      print_r($data->results);
                      echo "</pre>"; */
                    echo " <!-- Vacation Rental Platform : $time2 -->. ";
                }

                if (isset($data->type)) {
                    $content = $this->loadTheme($data->type, $data);
                } else {
                    $content = $this->loadTheme("results", $data);

                }

                $pagetitle = "Search Results";
                break;

            case "complexsearch": // If Search Page.
                $this->time = microtime(true);
                $data       = $this->complexsearch();

                $this->time = round((microtime(true) - $this->time), 4);
                $data       = json_decode($data);
                if (isset($data->type)) {
                    $content = $this->loadTheme($data->type, $data);
                } else {
                    $content = $this->loadTheme("complexresults", $data);
                }
                $pagetitle = "Search Results";
                break;

            case "book":

                if ($_GET['slug'] == 'dobooking') {
                    if (isset($_SESSION['package'])) {
                        $_POST['booking']['packages'] = $_SESSION['package'];
                    }
                }

                if (isset($_POST['email'])) {
                    $userinfo             = $this->doLogin($_POST['email'], $_POST['password']);
                    $_SESSION['userinfo'] = $userinfo;
                    if (!isset($userinfo->Error)) {
                        $_GET['slug'] = "step3";
                    }
                }

                if (isset($_POST['booking'])) {
                    $_SESSION['userinfo'] = $_POST['booking'];
                }

                $data = json_decode($_SESSION['bookingresults']);
                if ($data->ID != $_GET['obj']['PropID']) {
                    $data      = json_decode($this->checkavailability(false, true));
                    $data->new = true;
                }

                if ($_GET['slug'] != 'confirm') {
                    $data      = json_decode($this->checkavailability(false, true));
                    $data->new = true;
                }

                $data->PropID = $_GET['obj']['PropID'];
                //if ($_GET['slug']=='step2'){
                $data->booksettings = $this->bookSettings($data->PropID);

                if ($_GET['slug'] == 'step1') {
                    unset($_SESSION['package']);
                }

                $data->package              = new \stdClass;
                $data->package->packagecost = "0.00";
                $data->package->items       = array();

                if (isset($_SESSION['package'])) {
                    $data->package = $_SESSION['package'];
                }

                if ($_GET['slug'] == 'step1a') {
                    if (isset($data->booksettings->HasPackages)) {
                        $a              = date("Y-m-d", strtotime($data->Arrival));
                        $d              = date("Y-m-d", strtotime($data->Departure));
                        $data->packages = json_decode($this->call("getpackages/$a/$d/"));
                    } else {
                        $_GET['slug'] = 'step2';
                    }
                }

                if ($_GET['slug'] == 'step3') {
                    $data->form = json_decode($this->call("bookingform/"));
                }

                if ($_GET['slug'] == 'confirm') {
                    $data->thebooking = json_decode($_SESSION['bresults']);
                    $pagetitle        = "Reservations";
                    $content          = $this->loadTheme("confirm", $data);
                } else {
                    $pagetitle = "Reservations";
                    $content   = $this->loadTheme("booking", $data);
                }
                break;

            case "xml":
                $content   = "";
                $pagetitle = "";
                break;
        }

        return [new DummyResult(0, $pagetitle, $content)];
    }

    public function villafilter()
    {
        if (!isset($_GET['action'])) {
            return;
        }

        if ($_GET['action'] == 'complexsearch') {
            if ($_GET['search']['type'] == 'Villa') {
                $_GET['action'] = 'search';
            }
        }
    }

    public function searchjax()
    {
        if (isset($_GET['search']['arrival'])) {
            $_SESSION['arrival'] = $_GET['search']['arrival'];
        }

        if (isset($_GET['search']['departure'])) {
            $_SESSION['depart'] = $_GET['search']['departure'];
        }

        ob_start();
        $results = json_decode($this->search());

        $units = $results->results;

        include TEMPLATEPATH . "/vrp/unitsresults.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function search()
    {
        $obj = new \stdClass();

        foreach ($_GET['search'] as $k => $v) {
            $obj->$k = $v;
        }

        if (isset($_GET['page'])) {
            $obj->page = (int) $_GET['page'];
        } else {
            $obj->page = 1;
        }

        if(!isset($obj->limit)) {
            $obj->limit = 10;
            if (isset($_GET['show'])) {
                $obj->limit = (int) $_GET['show'];
            }
        }

        if (isset($obj->arrival)) {
            if ($obj->arrival == 'Not Sure') {
                $obj->arrival = '';
                $obj->depart  = '';
            } else {
                $obj->arrival = date("m/d/Y", strtotime($obj->arrival));
            }
        }

        $search['search'] = json_encode($obj);

        if (isset($_GET['specialsearch'])) {
            // This might only be used by suite-paradise.com but is available
            // To all ISILink based PMS softwares.
            return $this->call('specialsearch', $search);
        }

        return $this->call('search', $search);
    }

    public function complexsearch()
    {
        $url = $this->apiURL . $this->apiKey . "/complexsearch3/";

        $obj = new \stdClass();
        foreach ($_GET['search'] as $k => $v) {
            $obj->$k = $v;
        }
        if (isset($_GET['page'])) {
            $obj->page = (int) $_GET['page'];
        } else {
            $obj->page = 1;
        }
        if (isset($_GET['show'])) {
            $obj->limit = (int) $_GET['show'];
        } else {
            $obj->limit = 10;
        }
        if ($obj->arrival == 'Not Sure') {
            $obj->arrival = '';
            $obj->depart  = '';
        }

        $search['search'] = json_encode($obj);
        $results          = $this->call('complexsearch3', $search);
        return $results;
    }

    public function savecompare()
    {
        $obj              = new \stdClass();
        $obj->compare     = $_SESSION['compare'];
        $obj->arrival     = $_SESSION['arrival'];
        $obj->depart      = $_SESSION['depart'];
        $search['search'] = json_encode($obj);
        $results          = $this->call('savecompare', $search);
        return $results;
    }

    public function compare()
    {
        if (isset($_GET['shared'])) {
            $_SESSION['cp'] = 1;
            $id             = (int) $_GET['shared'];
            $source         = "";
            if (isset($_GET['source'])) {
                $source = $_GET['source'];
            }
            $data                = json_decode($this->call("getshared/" . $id . "/" . $source));
            $_SESSION['compare'] = $data->compare;
            $_SESSION['arrival'] = $data->arrival;
            $_SESSION['depart']  = $data->depart;
        }

        $obj = new \stdClass();

        if (isset($_GET['c']['compare'])) {
            $compare             = $_GET['c']['compare'];
            $_SESSION['compare'] = $compare;
            if (!is_array($compare)) {
                return;
            }
        } else {
            $compare = $_SESSION['compare'];
            if (!is_array($compare)) {
                return;
            }
        }

        if (isset($_GET['c']['arrival'])) {
            $obj->arrival        = $_GET['c']['arrival'];
            $obj->departure      = $_GET['c']['depart'];
            $_SESSION['arrival'] = $obj->arrival;
            $_SESSION['depart']  = $obj->departure;
        } else {
            if (isset($_SESSION['arrival'])) {
                $obj->arrival   = $_SESSION['arrival'];
                $obj->departure = $_SESSION['depart'];
            }
        }
        $obj->items = $compare;
        sort($obj->items);

        $url = $this->apiURL . $this->apiKey . "/compare/";

        $search['search'] = json_encode($obj);
        $ch               = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $search);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $results = curl_exec($ch);

        $results  = json_decode($results);
        $contents = $this->loadTheme('vrpCompare', $results);

        return $contents;
    }

    public function loadcompare()
    {

        $obj = new \stdClass();

        if (isset($_GET['c']['compare'])) {

            $compare = $_GET['c']['compare'];

            if (!is_array($compare)) {
                return;
            }
        } else {

            $compare = $_SESSION['compare'];
            if (!is_array($compare)) {
                return;
            }
        }


        if (isset($_GET['c']['arrival'])) {
            $obj->arrival        = $_GET['c']['arrival'];
            $obj->departure      = $_GET['c']['depart'];
            $_SESSION['arrival'] = $obj->arrival;
            $_SESSION['depart']  = $obj->departure;
        } else {
            if (isset($_SESSION['arrival'])) {
                $obj->arrival   = $_SESSION['arrival'];
                $obj->departure = $_SESSION['depart'];
            }
        }
        $obj->arrival   = date("Y-m-d", strtotime($obj->arrival));
        $obj->departure = date("Y-m-d", strtotime($obj->departure));
        foreach ($compare as $v):
            $arr[] = $v;
        endforeach;
        $obj->items = $arr;


        $url              = $this->apiURL . $this->apiKey . "/compare/";
        $search['search'] = json_encode($obj);
        $ch               = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $search);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $results = curl_exec($ch);

        $results = json_decode($results);

        return $results;
    }

    /**
     * Loads the VRP Theme.
     *
     * @param string $section
     * @param        $data [] $data
     *
     * @return string
     */
    public function loadTheme($section, $data)
    {
        $wptheme = get_stylesheet_directory() . "/vrp/$section.php";

        if (file_exists($wptheme)) {
            $load = $wptheme;
        } else {
            $load = $this->theme . "/" . $section . ".php";
        }

        if (isset($_GET['printme'])) {
            include $this->theme . "/print.php";
            die();
        }

        $this->debug['data']       = $data;
        $this->debug['theme_file'] = $load;

        ob_start();
        include $load;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function ajax()
    {
        if (!isset($_GET['vrpjax'])) {
            return false;
        }
        $act = $_GET['act'];
        $par = $_GET['par'];
        if (method_exists($this, $act)) {
            $this->$act($par);
        }
        die();
    }

    public function checkavailability($par = false, $ret = false)
    {
        set_time_limit(50);

        $fields_string = "obj=" . json_encode($_GET['obj']);
        $results       = $this->call('checkavail', $fields_string);

        if ($ret == true) {
            $_SESSION['bookingresults'] = $results;
            return $results;
        }

        if ($par != false) {
            $_SESSION['bookingresults'] = $results;
            echo $results;
            return false;
        }

        $res = json_decode($results);

        if (isset($res->Error)) {
            echo $res->Error;
        } else {
            $_SESSION['bookingresults'] = $results;
            echo "1";
        }
    }

    public function processbooking($par = false, $ret = false)
    {
        if (isset($_POST['booking']['comments'])) {
            $_POST['booking']['comments'] = urlencode($_POST['booking']['comments']);
        }

        $fields_string = "obj=" . json_encode($_POST['booking']);
        $results       = $this->call('processbooking', $fields_string);
        $res           = json_decode($results);
        if (isset($res->Results)) {
            $_SESSION['bresults'] = json_encode($res->Results);
        }
        echo $results;
    }

    public function addtopackage()
    {
        $TotalCost = $_GET['TotalCost'];
        if (!isset($_GET['package'])) {
            unset($_SESSION['package']);
            $obj              = new \stdClass();
            $obj->packagecost = "$0.00";

            $obj->TotalCost = "$" . number_format($TotalCost, 2);
            echo json_encode($obj);
            return false;
        }

        $currentpackage        = new \stdClass();
        $currentpackage->items = array();
        $grandtotal            = 0;
        // ID & QTY
        $package = $_GET['package'];
        $qty     = $_GET['qty'];
        $cost    = $_GET['cost'];
        $name    = $_GET['name'];
        foreach ($package as $v):
            $amount                    = $qty[$v]; // Qty of item.
            $obj                       = new \stdClass();
            $obj->name                 = $name[$v];
            $obj->qty                  = $amount;
            $obj->total                = $cost[$v] * $amount;
            $grandtotal                = $grandtotal + $obj->total;
            $currentpackage->items[$v] = $obj;
        endforeach;

        $TotalCost        = $TotalCost + $grandtotal;
        $obj              = new \stdClass();
        $obj->packagecost = "$" . number_format($grandtotal, 2);

        $obj->TotalCost = "$" . number_format($TotalCost, 2);
        echo json_encode($obj);
        $currentpackage->packagecost = $grandtotal;
        $currentpackage->TotalCost   = $TotalCost;
        $_SESSION['package']         = $currentpackage;
    }

    public function getspecial()
    {
        return json_decode($this->call("getonespecial"));
    }

    public function getTheSpecial($id)
    {
        $data = json_decode($this->call("getspecialbyid/" . $id));
        return $data;
    }

    public function sitemap()
    {
        if (!isset($_GET['vrpsitemap'])) {
            return false;
        }
        $data = json_decode($this->call("allvrppages"));
        ob_start();
        include "xml.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
        die();
    }

    public function xmlexport()
    {
        header("Content-type: text/xml");
        echo $this->customcall("generatexml");
        die();
    }

    public function robots_mod($output, $public)
    {
        $siteurl = get_option("siteurl");
        $output .= "Sitemap: " . $siteurl . "/?vrpsitemap=1 \n";
        return $output;
    }

    //
    //  API Calls
    //

    /**
     * Make a call to the VRPc API
     *
     * @param $call
     * @param array $params
     *
     * @return string
     */
    public function call($call, $params = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiURL . $this->apiKey . "/" . $call);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $results = curl_exec($ch);
        curl_close($ch);
        return $results;
    }

    public function customcall($call)
    {
        echo $this->call("customcall/$call");
    }

    public function custompost($call)
    {
        $obj = new \stdClass();
        foreach ($_POST['obj'] as $k => $v) {
            $obj->$k = $v;
        }

        $search['search']       = json_encode($obj);
        $results                = $this->call($call, $search);
        $this->debug['results'] = $results;
        echo $results;
    }

    public function bookSettings($propID)
    {
        return json_decode($this->call("booksettings/" . $propID));
    }

    /**
     * Get available search options.
     *
     * Example: minbeds, maxbeds, minbaths, maxbaths, minsleeps, maxsleeps, types (hotel, villa), cities, areas, views, attributes, locations
     *
     * @return mixed
     */
    public function searchoptions()
    {
        return json_decode($this->call("searchoptions"));
    }

    /**
     * Get a featured unit
     * @ajax
     */
    public function featuredunit()
    {
        if (isset($_GET['featuredunit'])) {
            echo $this->call("featuredunit");
            die();
        }
    }

    public function allSpecials()
    {
        return json_decode($this->call("allspecials"));
    }

    /**
     * Get flipkey reviews for a given unit.
     *
     * @ajax
     */
    public function getflipkey()
    {
        $id   = $_GET['slug'];
        $call = "getflipkey/?unit_id=$id";
        $data = $this->customcall($call);
        echo "<!DOCTYPE html><html>";
        echo "<body>";
        echo $data;
        echo "</body></html>";
        die();
    }

    //
    //  Shortcode methods
    //

    /**
     * [vrpComplexes] Shortcode
     *
     * @param array $items
     *
     * @return string
     */
    public function vrpComplexes($items = array())
    {
        $items['page'] = 1;

        if (isset($_GET['page'])) {
            $items['page'] = (int) $_GET['page'];
        }

        if (isset($_GET['beds'])) {
            $items['beds'] = (int) $_GET['beds'];
        }
        if (isset($_GET['minbed'])) {
            $items['minbed'] = (int) $_GET['minbed'];
            $items['maxbed'] = (int) $_GET['maxbed'];
        }

        $obj       = new \stdClass();
        $obj->okay = 1;
        if (count($items) != 0) {
            foreach ($items as $k => $v) {
                $obj->$k = $v;
            }
        }

        $search['search'] = json_encode($obj);
        $results          = $this->call('allcomplexes', $search);
        $results          = json_decode($results);
        $content          = $this->loadTheme('vrpComplexes', $results);

        return $content;
    }

    /**
     * [vrpUnits] Shortcode
     *
     * @param array $items
     *
     * @return string
     */
    public function vrpUnits($items = array())
    {
        $items['showall'] = 1;
        if (isset($_GET['page'])) {
            $items['page'] = (int) $_GET['page'];
        }

        if (isset($_GET['beds'])) {
            $items['beds'] = (int) $_GET['beds'];
        }

        if (isset($_GET['search'])) {
            foreach ($_GET['search'] as $k => $v):
                $items[$k] = $v;
            endforeach;
        }

        if (isset($_GET['minbed'])) {
            $items['minbed'] = (int) $_GET['minbed'];
            $items['maxbed'] = (int) $_GET['maxbed'];
        }

        $obj       = new \stdClass();
        $obj->okay = 1;
        if (count($items) != 0) {
            foreach ($items as $k => $v) {
                $obj->$k = $v;
            }
        }

        $search['search'] = json_encode($obj);
        $results          = $this->call('allunits', $search);
        $results          = json_decode($results);
        $content          = $this->loadTheme('vrpUnits', $results);
        return $content;
    }

    /**
     * [vrpSearchForm] Shortcode
     *
     * @return string
     */
    public function vrpSearchForm()
    {
        $data = "";
        $page = $this->loadTheme("vrpSearchForm", $data);
        return $page;
    }

    /**
     * [vrpAdvancedSearch] Shortcode
     *
     * @return string
     */
    public function vrpAdvancedSearchForm()
    {
        $data = "";
        $page = $this->loadTheme("vrpAdvancedSearchForm", $data);
        return $page;
    }

    /**
     * [vrpSearch] Shortcode
     *
     * @param array $arr
     *
     * @return string
     */
    public function vrpSearch($arr = array())
    {
        $_GET['search']            = $arr;
        $_GET['search']['showall'] = 1;
        $data                      = $this->search();
        $data                      = json_decode($data);

        if (isset($data->type)) {
            $content = $this->loadTheme($data->type, $data);
        } else {
            $content = $this->loadTheme("results", $data);
        }
        return $content;
    }

    /**
     * [vrpComplexSearch]
     *
     * @param array $arr
     *
     * @return string
     */
    public function vrpcomplexsearch($arr = array())
    {
        foreach ($arr as $k => $v):
            if (stristr($v, "|")) {
                $arr[$k] = explode("|", $v);
            }
        endforeach;
        $_GET['search']            = $arr;
        $_GET['search']['showall'] = 1;

        $this->time = microtime(true);
        $data       = $this->complexsearch();

        $this->time = round((microtime(true) - $this->time), 4);
        $data       = json_decode($data);
        if (isset($data->type)) {
            $content = $this->loadTheme($data->type, $data);
        } else {
            $content = $this->loadTheme("complexresults", $data);
        }
        return $content;
    }

    /**
     * [vrpAreaList] Shortcode
     *
     * @param $arr
     *
     * @return string
     */
    public function vrpAreaList($arr)
    {
        $area    = $arr['area'];
        $r       = $this->call("areabymainlocation/$area");
        $data    = json_decode($r);
        $content = $this->loadTheme("arealist", $data);
        return $content;
    }

    /**
     * [vrpSpecials] Shortcode
     *
     * @param array $items
     *
     * @return string
     *
     * @todo support getOneSpecial
     */
    public function vrpSpecials($items = array())
    {
        if (!isset($items['cat'])) {
            $items['cat'] = 1;
        }

        if (isset($items['special_id'])) {
            $data = json_decode($this->call("getspecialbyid/" . $items['special_id']));
        } else {
            $data = json_decode($this->call("getspecialsbycat/" . $items['cat']));
        }

        return $this->loadTheme("vrpSpecials", $data);
    }

    /**
     * [vrpLinks] Shortcode
     *
     * @param $items
     *
     * @return string
     */
    public function vrpLinks($items)
    {
        $items['showall'] = true;

        switch ($items['type']) {
            case "Condo";
                $call = "/allcomplexes/";
                break;
            case "Villa";
                $call = "/allunits/";
                break;
        }

        $obj       = new \stdClass();
        $obj->okay = 1;
        if (count($items) != 0) {
            foreach ($items as $k => $v) {
                $obj->$k = $v;
            }
        }

        $search['search'] = json_encode($obj);
        $results          = json_decode($this->call($call, $search));

        $ret = "<ul style='list-style:none'>";
        if ($items['type'] == 'Villa') {
            foreach ($results->results as $v):
                $ret .= "<li><a href='/vrp/unit/$v->page_slug'>$v->Name</a></li>";
            endforeach;
        } else {
            foreach ($results as $v):
                $ret .= "<li><a href='/vrp/complex/$v->page_slug'>$v->name</a></li>";
            endforeach;
        }
        $ret .= "</ul>";
        return $ret;
    }

    /**
     * [vrpCompare] Shortcode
     *
     * @return string
     */
    public function vrpCompare()
    {
        return $this->compare();
    }

    /**
     * [vrpShort] Shortcode
     *
     * This is only here for legacy support.
     *  Suite-Paradise.com
     *
     * @param $params
     *
     * @return string
     */
    public function vrpShort($params)
    {
        if ($params['type'] == 'resort') {
            $params['type'] = 'Location';
        }

        if (
            (isset($params['attribute']) && $params['attribute'] == true) ||
            (($params['type'] == 'complex') || $params['type'] == 'View')
        ) {
            $items['attributes'] = true;
            $items['aname']      = $params['type'];
            $items['value']      = $params['value'];
        } else {
            $items[$params['type']] = $params['value'];
        }

        $items['sort']  = "Name";
        $items['order'] = "low";

        return $this->loadTheme('vrpShort', $items);
    }

    public function vrpFeaturedUnit($params = [])
    {
        if(empty($params)) {
            // No Params = Get one random featured unit
            $data = json_decode($this->call("featuredunit"));
            return $this->loadTheme("vrpFeaturedUnit",$data);
        }

        if(count($params) == 1 && isset($params['show'])) {
            // 'show' param = get multiple random featured units
            $data = json_decode($this->call("getfeaturedunits/".$params['show']));
            return $this->loadTheme("vrpFeaturedUnits",$data);
        }

        if(isset($params['field']) && isset($params['value'])) {
            // if Field AND Value exist find a custom featured unit
            if(isset($params['show'])) {
                // Returning Multiple units
                $params['num'] = $params['show'];
                unset($params['show']);
                $data = json_decode($this->call("getfeaturedbyoption",$params));
                return $this->loadTheme("vrpFeaturedUnits",$data);
            }
            // Returning a single unit
            $params['num'] = 1;
            $data = json_decode($this->call("getfeaturedbyoption",$params));
            return $this->loadTheme("vrpFeaturedUnit",$data);
        }

    }

    //
    //  Wordpress Admin Methods
    //

    /**
     * Display notice for user to enter their VRPc API key.
     */
    public function notice()
    {
        $siteurl = admin_url('admin.php?page=VRPConnector');
        echo '<div class="updated fade"><b>Vacation Rental Platform</b>: <a href="' . esc_url($siteurl) . '">Please enter your API key.</a></div>';
    }

    /**
     * Admin nav menu items
     */
    public function setupPage()
    {
        add_options_page(
            "Settings Admin",
            'VRP',
            'activate_plugins',
            "VRPConnector",
            array($this, 'settingsPage')
        );
    }

    public function registerSettings()
    {
        register_setting('VRPConnector','vrpAPI');
        register_setting('VRPConnector','vrpTheme');
        add_settings_section('vrpApiKey','VRP API Key',array($this,'apiKeySettingTitleCallback'),'VRPConnector');
        add_settings_field('vrpApiKey', 'VRP Api Key', array( $this, 'apiKeyCallback' ), 'VRPConnector', 'vrpApiKey');
        add_settings_section('vrpTheme','VRP Theme Selection',array($this,'vrpThemeSettingTitleCallback'),'VRPConnector');
        add_settings_field('vrpTheme', 'VRP Theme', array( $this, 'vrpThemeSettingCallback' ), 'VRPConnector', 'vrpTheme');
    }

    public function apiKeySettingTitleCallback()
    {
        echo "<p>Your API Key can be found in the settings section after
        logging in to <a href='http://www.gueststream.net'>Gueststream.net</a>.</p>
        <p>Demo API Key: <strong>1533020d1121b9fea8c965cd2c978296</strong>
        The Demo API Key does not contain bookable units therfor availability searches
        will not work.
        </p>
        ";
    }

    public function apiKeyCallback()
    {
        echo '<input type="text" name="vrpAPI" value="'.get_option('vrpAPI').'" style="width:400px;"/>';
    }

    public function vrpThemeSettingTitleCallback()
    {

    }

    public function vrpThemeSettingCallback()
    {
        echo '<select name="vrpTheme">';
        foreach ($this->available_themes as $name => $displayname) {
            $sel = "";
            if ($name == $this->themename) {$sel = "SELECTED";}
            echo '<option value="'.$name.'" '.$sel.'>'.$displayname.'</option>';
        }
        echo '</select>';
    }

    /**
     * Displays the 'VRP Login' admin page.
     */
    public function loadVRP()
    {
        include VRP_PATH . 'views/login.php';
    }

    /**
     * Displays the 'VRP API Code Entry' admin page
     */
    public function settingsPage()
    {
        include VRP_PATH . 'views/settings.php';
    }

    /**
     * Checks if API Key is good and API is available.
     *
     * @return mixed
     */
    public function testAPI()
    {
        return json_decode($this->call("testAPI"));
    }

    /**
     * Generates the admin automatic login url.
     *
     * @param $email
     * @param $password
     *
     * @return array|mixed
     */
    public function doLogin($email, $password)
    {
        $url = $this->apiURL . $this->apiKey . "/userlogin/?email=$email&password=$password";
        return json_decode(file_get_contents($url));
    }

    //
    // File Caching Methods
    //

    /**
     * store cache item.
     *
     * @param string $action
     * @param string $slug
     * @param        $object [] $object
     */
    public function cache($action, $slug, $object)
    {
        return; // Removing file cache.
    }

    /**
     * get Cached item
     *
     * @param $action
     * @param $slug
     *
     * @return bool
     */
    public function getCache($action, $slug)
    {
        return false; // Removing file cache.
    }

    /**
     * Removes cached file.
     *
     * @param $param [] $param
     */
    public function clearCache($file, $action, $slug)
    {
       return; // Removing file cache
    }

}
