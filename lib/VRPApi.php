<?php

namespace Gueststream;

/**
 * VRPApi Class
 */

class VRPApi
{
    public $apiKey;                                // Gueststream.net API Key
    public $available;
    public $apiURL = "https://www.gueststream.net/api/v1/";     // Gueststream.net API Endpoint
    public $debug = [];                       // Container for debug data

    /**
     * Class Construct
     */
    public function __construct()
    {
        $this->apiKey = get_option('vrpAPI');

        if ($this->apiKey !== '') {
            $apiAvailable = (json_decode($this->call("testAPI"))->Status === 'Online' ? true : false);
            $this->available = $apiAvailable;
            return $this->status;
        }

        $this->available = false;

        return false;
    }

    public function setAPIKey($apiKey)
    {
        $this->apiKey = $apiKey;
        $apiAvailable = (json_decode($this->call("testAPI"))->Status === 'Online' ? true : false);
        $this->status = (object) ['apiAvailable' => $apiAvailable];
    }

    /* VRPConnector Plugin API Call methods
     *
     *
     */

    /**
     * Make a call to the VRPc API
     *
     * @param $call
     * @param array $params
     *
     * @return string
     */
    public function call($call, $params = [])
    {
        $cache_key = md5($call . json_encode($params));
        $results = wp_cache_get($cache_key, 'vrp');
        if (false == $results) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiURL . $this->apiKey . "/" . $call);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $results = curl_exec($ch);
            curl_close($ch);
            wp_cache_set($cache_key, $results, 'vrp', 300); // 5 Minutes.
        }

        return $results;
    }

    public function customcall($call)
    {
        echo wp_kses($this->call("customcall/$call"));
    }

    public function custompost($call)
    {
        $obj = new \stdClass();
        foreach ($_POST['obj'] as $k => $v) {
            $obj->$k = $v;
        }

        $search['search'] = json_encode($obj);
        $results = $this->call($call, $search);
        $this->debug['results'] = $results;
        echo wp_kses($results);
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
     * List out property names. Useful in listing names for propery select box.
     */
    function proplist()
    {
        $data = $this->call("namelist");

        return json_decode($data);
    }

    public function complexsearch()
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
        if (isset($_GET['show'])) {
            $obj->limit = (int) $_GET['show'];
        } else {
            $obj->limit = 10;
        }
        if ($obj->arrival == 'Not Sure') {
            $obj->arrival = '';
            $obj->depart = '';
        }

        $search['search'] = json_encode($obj);
        $results = $this->api->call('complexsearch3', $search);

        return $results;
    }

    /**
     * Get a featured unit
     * @ajax
     */
    public function featuredunit()
    {
        if (isset($_GET['featuredunit'])) {
            $featured_unit = json_decode($this->call("featuredunit"));
            wp_send_json($featured_unit);
            exit;
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
        $id = $_GET['slug'];
        $call = "getflipkey/?unit_id=$id";
        $data = $this->customcall($call);
        echo "<!DOCTYPE html><html>";
        echo "<body>";
        echo wp_kses_post($data);
        echo "</body></html>";
        exit;
    }

    /**
     * Class Destruct w/basic debugging.
     */
    public function __destruct()
    {
    }

}
