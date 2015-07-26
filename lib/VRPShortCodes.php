<?php

namespace Gueststream;

/**
 * VRPApi Class
 */

class VRPShortCodes
{
    private $themes;
    private $api;
    /**
     * Class Construct
     */
    public function __construct($api, $themes)
    {

        $this->api = $api;
        $this->themes = $themes;
        // Shortcodes
        add_shortcode("vrpUnits", [$this, "vrpUnits"]);
        add_shortcode("vrpSearch", [$this, "vrpSearch"]);
        add_shortcode("vrpSearchForm", [$this, "vrpSearchForm"]);
        add_shortcode("vrpAdvancedSearchForm", [$this, "vrpAdvancedSearchForm"]);
        add_shortcode("vrpComplexes", [$this, "vrpComplexes"]);
        add_shortcode("vrpComplexSearch", [$this, "vrpComplexSearch"]);
        add_shortcode("vrpshort", [$this, "vrpShort"]);
        add_shortcode("vrpFeaturedUnit", [$this, "vrpFeaturedUnit"]);
        add_filter('widget_text', 'do_shortcode');

//        $this->apiKey = get_option('vrpAPI');

    }


    /* VRPConnector Plugin Shortcode Methods
     *
     *
     */

    /**
     * [vrpComplexes] Shortcode
     *
     * @param array $items
     *
     * @return string
     */
    public function vrpComplexes($items = [])
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

        $obj = new \stdClass();
        $obj->okay = 1;
        if (count($items) != 0) {
            foreach ($items as $k => $v) {
                $obj->$k = $v;
            }
        }

        $search['search'] = json_encode($obj);
        $results = $this->api->call('allcomplexes', $search);
        $results = json_decode($results);
        $content = $this->themes->load('vrpComplexes', $results);

        return $content;
    }

    /**
     * [vrpUnits] Shortcode
     *
     * @param array $items
     *
     * @return string
     */
    public function vrpUnits($items = [])
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

        $obj = new \stdClass();
        $obj->okay = 1;
        if (count($items) != 0) {
            foreach ($items as $k => $v) {
                $obj->$k = $v;
            }
        }

        $search['search'] = json_encode($obj);
        $results = $this->api->call('allunits', $search);
        $results = json_decode($results);
        $content = $this->themes->load('vrpUnits', $results);

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
        $page = $this->themes->load("vrpSearchForm", $data);

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
        $page = $this->themes->load("vrpAdvancedSearchForm", $data);

        return $page;
    }

    /**
     * [vrpSearch] Shortcode
     *
     * @param array $arr
     *
     * @return string
     */
    public function vrpSearch($arr = [])
    {
        $_GET['search'] = $arr;
        $_GET['search']['showall'] = 1;
        $data = $this->search();
        $data = json_decode($data);

        if ($data->count > 0) {
            $data = $this->prepareSearchResults($data);
        }

        if (isset($data->type)) {
            $content = $this->themes->load($data->type, $data);
        } else {
            $content = $this->themes->load("results", $data);
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
    public function vrpComplexSearch($arr = [])
    {
        foreach ($arr as $k => $v):
            if (stristr($v, "|")) {
                $arr[$k] = explode("|", $v);
            }
        endforeach;
        $_GET['search'] = $arr;
        $_GET['search']['showall'] = 1;

        $this->time = microtime(true);
        $data = $this->api->complexsearch();

        $this->time = round((microtime(true) - $this->time), 4);
        $data = json_decode($data);
        if (isset($data->type)) {
            $content = $this->themes->load($data->type, $data);
        } else {
            $content = $this->themes->load("complexresults", $data);
        }

        return $content;
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
            $items['aname'] = $params['type'];
            $items['value'] = $params['value'];
        } else {
            $items[$params['type']] = $params['value'];
        }

        $items['sort'] = "Name";
        $items['order'] = "low";

        return $this->themes->load('vrpShort', $items);
    }

    public function vrpFeaturedUnit($params = [])
    {
        if (empty($params)) {
            // No Params = Get one random featured unit
            $data = json_decode($this->api->call("featuredunit"));

            return $this->themes->load("vrpFeaturedUnit", $data);
        }

        if (count($params) == 1 && isset($params['show'])) {
            // 'show' param = get multiple random featured units
            $data = json_decode($this->api->call("getfeaturedunits/" . $params['show']));

            return $this->themes->load("vrpFeaturedUnits", $data);
        }

        if (isset($params['field']) && isset($params['value'])) {
            // if Field AND Value exist find a custom featured unit
            if (isset($params['show'])) {
                // Returning Multiple units
                $params['num'] = $params['show'];
                unset($params['show']);
                $data = json_decode($this->api->call("getfeaturedbyoption", $params));

                return $this->themes->load("vrpFeaturedUnits", $data);
            }
            // Returning a single unit
            $params['num'] = 1;
            $data = json_decode($this->api->call("getfeaturedbyoption", $params));

            return $this->themes->load("vrpFeaturedUnit", $data);
        }

    }


    /**
     * Class Destruct w/basic debugging.
     */
    public function __destruct()
    {
    }

}
