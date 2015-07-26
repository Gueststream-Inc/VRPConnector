<?php

namespace Gueststream;

/**
 * VRPConnector Class
 */

class VRPConnector
{
    public $api;
    public $themes;
    public $shortCodes;
    public $pages;
    public $otheractions = [];                //
    public $time;                                // Time (in seconds?) spent making calls to the API
    public $debug = [];                       // Container for debug data
    public $action = false; // VRP Action
    public $favorites;
    public $search;
    private $pagetitle;
    private $pagedescription;
    private $pluginNotification = ['type' => 'default', 'prettyType' => "",'message' => ""];

    /**
     * Class Construct
     */
    public function __construct()
    {
        $this->api = new VRPApi;
        $this->themes = new VRPThemes;
        $this->shortCodes = new VRPShortCodes($this->api, $this->themes);
        $this->pages = new VRPPages($this->api, $this->themes);
        if(!$this->api) {
            $this->setPluginNotification('warning', 'Warning', 'To connect to the VRPc API, please provide a valid production key.');
        }
        $this->initializeActions();
        //Prepare theme...
        $this->themes->set(get_option('vrpTheme'));
        $this->themes->initializeThemeActions();
    }

    /* Plugin security, initialization, helper & notification methods */

    /**
     * init WordPress Actions, Filters & shortcodes
     */
    public function initializeActions()
    {
        if (is_admin()) {
            add_action('admin_menu', [$this, 'setupPage']);
            add_action('admin_init', [$this, 'registerSettings']);
            add_filter('plugin_action_links',[$this, 'add_action_links'], 10, 2);
        }

        // Actions
        add_action('init', [$this, 'ajax']);
        add_action('init', [$this, 'sitemap']);
        add_action('init', [$this->api, 'featuredunit']);
        add_action('init', [$this, 'otheractions']);
        add_action('init', [$this, 'rewrite']);
        add_action('init', [$this, 'villafilter']);
        add_action('parse_request', [$this, 'router']);
        add_action('update_option_vrpApiKey', [$this, 'flush_rewrites'], 10, 2);
        add_action('update_option_vrpAPI', [$this, 'flush_rewrites'], 10, 2);
        add_action('wp', [$this, 'remove_filters']);
        add_action('pre_get_posts', [$this, 'query_template']);

        // Filters
        add_filter('robots_txt', [$this, 'robots_mod'], 10, 2);
        remove_filter('template_redirect', 'redirect_canonical');
    }

    /**
     * Validates nonce token for wordpress security
     *
     * @return bool
     */
    private function validateNonce()
    {
        if (
            ! isset($_GET['vrpUpdateSection'])
            || ! isset( $_POST['nonceField'] )
            || ! wp_verify_nonce( $_POST['nonceField'], $_GET['vrpUpdateSection'] )
        ) {
            $this->setPluginNotification('warning', 'Warning', 'Your none token did not verify.');
            return false;
        }

        return true;
    }

    /**
     * Sets plugin notification
     *
     * @param $type
     * @param $prettyType
     * @param $message
     *
     * @return bool
     */
    private function setPluginNotification($type, $prettyType, $message)
    {

        return $this->pluginNotification = [
            'type' => $type,
            'prettyType' => $prettyType,
            'message' => $message
        ];

    }

    /**
     * Alters WP_Query to tell it to load the page template instead of home.
     *
     * @param WP_Query $query
     *
     * @return WP_Query
     */
    public function query_template($query)
    {
        if (!isset($query->query_vars['action'])) {
            return $query;
        }
        $query->is_page = true;
        $query->is_home = false;

        return $query;
    }

    public function otheractions()
    {
        if (isset($_GET['otherslug']) && $_GET['otherslug'] != '') {
            $theme = $this->themes->theme;
            $theme = new $theme;
            $func = $theme->otheractions;
            $func2 = $func[$_GET['otherslug']];
            call_user_method($func2, $theme);
        }
    }

    /**
     * Uses built-in rewrite rules to get pretty URL. (/vrp/)
     */
    public function rewrite()
    {
        add_rewrite_tag('%action%', '([^&]+)');
        add_rewrite_tag('%slug%', '([^&]+)');
        add_rewrite_rule('^vrp/([^/]*)/([^/]*)/?', 'index.php?action=$matches[1]&slug=$matches[2]', 'top');

    }

    /**
     * Only on activation.
     */
    static function rewrite_activate()
    {
        add_rewrite_tag('%action%', '([^&]+)');
        add_rewrite_tag('%slug%', '([^&]+)');
        add_rewrite_rule('^vrp/([^/]*)/([^/]*)/?', 'index.php?action=$matches[1]&slug=$matches[2]', 'top');

    }

    function flush_rewrites($old, $new)
    {
        flush_rewrite_rules();
    }

    /**
     * Sets up action and slug as query variable.
     *
     * @param $vars [] $vars Query String Variables.
     *
     * @return $vars[]
     */
    public function query_vars($vars)
    {
        array_push($vars, 'action', 'slug', 'other');

        return $vars;
    }

    /**
     * Checks to see if VRP slug is active, if so, sets up a page.
     *
     * @return bool
     */
    public function router($query)
    {

        if (!isset($query->query_vars['action'])) {
            return false;
        }
        if ($query->query_vars['action'] == 'xml') {
            $this->xmlexport();
        }

        if ($query->query_vars['action'] == 'flipkey') {
            $this->api->getflipkey();
        }
        add_filter('the_posts', [$this->pages, "route"], 1, 2);
    }



    public function villafilter()
    {
        if (!$this->pages->isVRPPage()) {
            return;
        }

        if ('complexsearch' == $this->action) {
            if ($_GET['search']['type'] == 'Villa') {
                $this->action = 'search';
                global $wp_query;
                $wp_query->query_vars['action'] = $this->action;
            }
        }
    }

    //@TODO: this needs to go somewhere.. VRPAjax class maybe?
    public function searchjax()
    {
        if (isset($_GET['search']['arrival'])) {
            $_SESSION['arrival'] = $_GET['search']['arrival'];
        }

        if (isset($_GET['search']['departure'])) {
            $_SESSION['depart'] = $_GET['search']['departure'];
        }

        ob_start();
        $results = json_decode($this->pages->search());

        $units = $results->results;

        include TEMPLATEPATH . "/vrp/unitsresults.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo wp_kses_post($content);
    }

    //@TODO: this needs to go somewhere.. VRPAjax class maybe?
    // looks like the refactors are going to break this, we might need to loop through $this->pages ?  I think that
    // is right..
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
        exit;
    }

    public function processbooking($par = false, $ret = false)
    {
        if (isset($_POST['booking']['comments'])) {
            $_POST['booking']['comments'] = urlencode($_POST['booking']['comments']);
        }

        $fields_string = "obj=" . json_encode($_POST['booking']);
        $results = $this->api->call('processbooking', $fields_string);
        $res = json_decode($results);
        if (isset($res->Results)) {
            $_SESSION['bresults'] = json_encode($res->Results);
        }
        echo wp_kses_post($results);
    }

    public function addtopackage()
    {
        $TotalCost = $_GET['TotalCost'];
        if (!isset($_GET['package'])) {
            unset($_SESSION['package']);
            $obj = new \stdClass();
            $obj->packagecost = "$0.00";

            $obj->TotalCost = "$" . number_format($TotalCost, 2);
            echo json_encode($obj);

            return false;
        }

        $currentpackage = new \stdClass();
        $currentpackage->items = [];
        $grandtotal = 0;
        // ID & QTY
        $package = $_GET['package'];
        $qty = $_GET['qty'];
        $cost = $_GET['cost'];
        $name = $_GET['name'];
        foreach ($package as $v):
            $amount = $qty[$v]; // Qty of item.
            $obj = new \stdClass();
            $obj->name = $name[$v];
            $obj->qty = $amount;
            $obj->total = $cost[$v] * $amount;
            $grandtotal = $grandtotal + $obj->total;
            $currentpackage->items[$v] = $obj;
        endforeach;

        $TotalCost = $TotalCost + $grandtotal;
        $obj = new \stdClass();
        $obj->packagecost = "$" . number_format($grandtotal, 2);

        $obj->TotalCost = "$" . number_format($TotalCost, 2);
        echo json_encode($obj);
        $currentpackage->packagecost = $grandtotal;
        $currentpackage->TotalCost = $TotalCost;
        $_SESSION['package'] = $currentpackage;
    }

//@TODO: depreciated??
//    public function getspecial()
//    {
//        return json_decode($this->api->call("getonespecial"));
//    }

//@TODO: depreciated??
//    public function getTheSpecial($id)
//    {
//        $data = json_decode($this->api->call("getspecialbyid/" . $id));
//
//        return $data;
//    }

    public function sitemap()
    {
        if (!isset($_GET['vrpsitemap'])) {
            return false;
        }
        $data = json_decode($this->api->call("allvrppages"));
        ob_start();
        include "xml.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo wp_kses_post($content);
        exit;
    }

    public function xmlexport()
    {
        header("Content-type: text/xml");
        echo wp_kses($this->api->customcall("generatexml"));
        exit;
    }

    public function robots_mod($output, $public)
    {
        $siteurl = get_option("siteurl");
        $output .= "Sitemap: " . $siteurl . "/?vrpsitemap=1 \n";

        return $output;
    }

    public function add_action_links($links, $file)
    {
        if( $file == 'vrpconnector/VRPConnector.php' && function_exists( "admin_url" ) ) {
            $settings_link = '<a href="' . admin_url( 'options-general.php?page=VRPConnector' ) . '">' . __('Settings') . '</a>';
            array_unshift( $links, $settings_link ); // before other links
        }
        return $links;
    }

    public function savecompare()
    {
        $obj = new \stdClass();
        $obj->compare = $_SESSION['compare'];
        $obj->arrival = $_SESSION['arrival'];
        $obj->depart = $_SESSION['depart'];
        $search['search'] = json_encode($obj);
        $results = $this->api->call('savecompare', $search);

        return $results;
    }

    public function remove_filters()
    {
        if ($this->pages->isVRPPage()) {
            remove_filter('the_content', 'wptexturize');
            remove_filter('the_content', 'wpautop');
        }
    }

    /* VRPConnector Plugin Administration Methods */

    /** @TODO: remove, depreciated?
     * Displays the 'VRP Login' admin page.
     */
//    public function loadVRP()
//    {
//        include VRP_PATH . 'views/login.php';
//    }

    /**
     * Admin nav menu items
     */
    public function setupPage()
    {
        add_options_page(
            "Settings Admin",
            'VRPConnector',
            'activate_plugins',
            "VRPConnector",
            [$this, 'settingsPage']
        );
    }

    public function registerSettings()
    {
        register_setting('VRPConnector', 'vrpAPI');
        register_setting('VRPConnector', 'vrpTheme');
        register_setting('VRPConnector', 'vrpPluginMode');
    }

    /**
     * Displays the 'VRP API Code Entry' admin page
     */
    public function settingsPage()
    {
        if(!empty($_POST) && $this->validateNonce() !== false) {
            $this->processVRPAPIUpdates();
            $this->processVRPThemeUpdates();
        }

        wp_enqueue_script('vrp-bootstrap-js', plugins_url('vrpconnector/resources/bower/bootstrap/dist/js/bootstrap.min.js'), false, null, false);
        wp_enqueue_script('vrp-bootstrap-fix', plugins_url('vrpconnector/resources/js/bootstrap-fix.js'), false, null, false);
        wp_enqueue_script('vrp-settings-js', plugins_url('vrpconnector/resources/js/settings.js'), false, null, false);
        include VRP_PATH . 'views/settings.php';
    }

    /**
     * Checks if VRP Theme settings are being updated
     *
     * @return bool
     */
    private function processVRPThemeUpdates()
    {
        if(
        isset($_POST['vrpTheme'])
        ) {
            if(!in_array($_POST['vrpTheme'], array_keys($this->themes->availableThemes))) {
                $this->setPluginNotification('danger', 'Error', 'The theme you\'ve selected is not available!');
                return false;
            }

            update_option('vrpTheme', $_POST['vrpTheme']);
            $this->setPluginNotification('success', 'Success', 'Your settings have been updated!');
            $this->themes->theme = $_POST['vrpTheme'];
            return true;
        }

        return false;
    }

    /**
     * Checks if VRP API credentials are being updated
     *
     * @return bool
     */
    private function processVRPAPIUpdates()
    {
        if(
            isset($_POST['vrpAPI']) && isset($_POST['vrpPluginMode'])
        ) {

            update_option('vrpPluginMode', trim($_POST['vrpPluginMode']));
            update_option('vrpAPI', trim($_POST['vrpAPI']));
            $this->api->setAPIKey(trim($_POST['vrpAPI']));
            $this->setPluginNotification('success', 'Success', 'Your settings have been updated!');

            return true;
        }
        return false;
    }

    /* VRPConnector Plugin magic methods
     *
     *
     */

    /**
     * Class Destruct w/basic debugging.
     */
    public function __destruct()
    {
        if (!isset($_GET['showdebug'])) {
            return false;
        }

        if (!$this->pages->isVRPPage()) {
            return false;
        }

        echo "<div style='position:absolute;left:0;width:100%;background:white;color:black;'>";
        echo "API Time Spent: " . esc_html($this->time) . "<br/>";
        echo "GET VARIABLES:<br><pre>";
        print_r($_GET);
        echo "</pre>";
        echo "Debug VARIABLES:<br><pre>";
        print_r($this->debug);
        echo "</pre>";
        echo "Post Type: " . esc_html($wp->query_vars["post_type"]);
        echo "</div>";
    }

}
