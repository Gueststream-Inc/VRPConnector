<?php

namespace Gueststream;

/**
 * VRPThemes Class
 */

class VRPPages
{
    public $api;
    public $themes;
    public $search;
    public $wpQuery;
    public $favorites = [];
    public $debug = [];

    /**
     * Class Construct
     *
     * @param $api
     * @param $themes
     */
    public function __construct($api, $themes)
    {
        $this->api = $api;
        $this->themes = $themes;

        $this->setFavorites();
        $this->prepareSearchData();
    }

    /**
     * @param $posts
     * @param $query
     *
     * @return array
     */
    public function route($posts, $query)
    {
        if (!isset($query->query_vars['action'])) {
            return false;
        }

        $this->wpQuery = $query;
        $action = $this->wpQuery->query_vars['action'];
        $slug = $this->wpQuery->query_vars['slug'];
        $page = false;

        switch ($action) {
            case "unit":
                $page = $this->doUnitPage($slug);
                break;

            case "complex":
                $page = $this->doComplexPage($slug);
                break;

            case "favorites":
                $page = $this->doFavoritePage($slug);
                break;

            case "specials":
                $page = $this->doSpecialsPage($slug);
                break;

            case "search":
                $page = $this->doSearchPage($slug);
                break;

            case "complexsearch":
                $page = $this->doComplexSearchPage($slug);
                break;

            case "book":
                $page = $this->doBookPage($slug);
                break;

            case "xml":
                $page = $this->doXMLPage($slug);
                break;
        }

        if(!$page) {
            die('?');
        }

        return [new DummyResult(0, $page['title'], $page['content'], $page['description'])];
    }

    public function doUnitPage($slug) // set to private?
    {
        $data = json_decode($this->api->call("getunit/" . $slug));

        if (isset($data->SEOTitle)) {
            $title = $data->SEOTitle;
        } else {
            $title = $data->Name;
        }

        $description = $data->SEODescription;

        if (!isset($data->id)) {
            global $wp_query;
            $wp_query->is_404 = true;
        }

        if (isset($data->Error)) {
            $content = $this->themes->load("error", $data);
        } else {
            $content = $this->themes->load("unit", $data);
        }

        return [
            'title' => $title,
            'description' => $description,
            'content' => $content
        ];
    }

    public function doComplexPage($slug)
    {
        $data = json_decode($this->api->call("getcomplex/" . $slug));

        if (isset($data->Error)) {
            $content = $this->themes->load("error", $data);
        } else {
            $content = $this->themes->load("complex", $data);
        }
        $title = $data->name;

        return [
            'title' => $title,
            'description' => "",
            'content' => $content
        ];
    }

    public function doSearchPage($slug)
    {
        $data = json_decode($this->search());

        if ($data->count > 0) {
            $data = $this->prepareSearchResults($data);
        }

        if (isset($_GET['json'])) {
            echo json_encode($data, JSON_PRETTY_PRINT);
            exit;
        }

        if (isset($data->type)) {
            $content = $this->themes->load($data->type, $data);
        } else {
            $content = $this->themes->load("results", $data);
        }

        $title = "Search Results";

        return [
            'title' => $title,
            'description' => "",
            'content' => $content
        ];
    }

    public function doComplexSearchPage($slug)
    {

        $data = json_decode($this->api->complexsearch());
        if (isset($data->type)) {
            $content = $this->themes->load($data->type, $data);
        } else {
            $content = $this->themes->load("complexresults", $data);
        }
        $title = "Search Results";

        return [
            'title' => $title,
            'description' => "",
            'content' => $content
        ];
    }

    public function doBookPage($slug)
    {
        if ($slug == 'dobooking') {
            if (isset($_SESSION['package'])) {
                $_POST['booking']['packages'] = $_SESSION['package'];
            }
        }

        if (isset($_POST['email'])) {
            $userinfo = $this->api->doLogin($_POST['email'], $_POST['password']);
            $_SESSION['userinfo'] = $userinfo;
            if (!isset($userinfo->Error)) {
                $this->wpQuery->query_vars['slug'] = "step3";
            }
        }

        if (isset($_POST['booking'])) {
            $_SESSION['userinfo'] = $_POST['booking'];
        }

        $data = json_decode($_SESSION['bookingresults']);
        if ($data->ID != $_GET['obj']['PropID']) {
            $data = json_decode($this->checkAvailability(false, true));
            $data->new = true;
        }

        if ($slug != 'confirm') {
            $data = json_decode($this->checkAvailability(false, true));
            $data->new = true;
        }

        $data->PropID = $_GET['obj']['PropID'];
        $data->booksettings = $this->api->bookSettings($data->PropID);

        if ($slug == 'step1') {
            unset($_SESSION['package']);
        }

        $data->package = new \stdClass;
        $data->package->packagecost = "0.00";
        $data->package->items = [];

        if (isset($_SESSION['package'])) {
            $data->package = $_SESSION['package'];
        }

        if ($slug == 'step1a') {
            if (isset($data->booksettings->HasPackages)) {
                $a = date("Y-m-d", strtotime($data->Arrival));
                $d = date("Y-m-d", strtotime($data->Departure));
                $data->packages = json_decode($this->api->call("getpackages/$a/$d/"));
            } else {
                $this->wpQuery->query_vars['slug'] = 'step2';
            }
        }

        if ($slug == 'step3') {
            $data->form = json_decode($this->api->call("bookingform/"));
        }

        if ($slug == 'confirm') {
            $data->thebooking = json_decode($_SESSION['bresults']);
            $title = "Reservations";
            $content = $this->themes->load("confirm", $data);
        } else {
            $title = "Reservations";
            $content = $this->themes->load("booking", $data);
        }

        return [
            'title' => $title,
            'description' => "",
            'content' => $content
        ];
    }

    public function doXMLPage($slug)
    {
        $content = "";
        $title = "";
        return [
            'title' => $title,
            'description' => "",
            'content' => $content
        ];
    }

    public function doFavoritePage($slug)
    {
        $content = "hi";
        switch ($slug) {
            case "add":
                $this->addFavorite();
                break;
            case "remove":
                $this->removeFavorite();
                break;
            case "json":
                echo json_encode($this->favorites);
                exit;
                break;
            default:
                $content = $this->showFavorites();
                $title = "Favorites";
                break;
        }

        return [
            'title' => $title,
            'description' => "",
            'content' => $content
        ];
    }

    public function doSpecialsPage($slug)
    {
        $render = $this->specialPage($slug);
        $title = $render['title']; //

        return [
            'title' => $title,
            'description' => "",
            'content' => $render['content']
        ];
    }

    private function specialPage($slug)
    {
        if ($slug == "list") {
            // Special by Category
            $data = json_decode($this->api->call("getspecialsbycat/1"));
            $title = "Specials";

            return $this->themes->load("specials", $data);
        }

        if (is_numeric($slug)) {
            // Special by ID
            $data = json_decode($this->api->call("getspecialbyid/" . $slug));
            $title = $data->title;

            return $this->themes->load("special", $data);
        }

        if (is_string($slug)) {
            // Special by slug
            $data = json_decode($this->api->call("getspecial/" . $slug));
            $title = $data->title;

            return ['title' => $title, 'content' => $this->themes->load("special", $data)];
        }
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

        if (!isset($obj->limit)) {
            $obj->limit = 10;
            if (isset($_GET['show'])) {
                $obj->limit = (int) $_GET['show'];
            }
        }

        if (isset($obj->arrival)) {
            if ($obj->arrival == 'Not Sure') {
                $obj->arrival = '';
                $obj->depart = '';
            } else {
                $obj->arrival = date("m/d/Y", strtotime($obj->arrival));
            }
        }

        $search['search'] = json_encode($obj);

        if (isset($_GET['specialsearch'])) {
            // This might only be used by suite-paradise.com but is available
            // To all ISILink based PMS softwares.
            return $this->api->call('specialsearch', $search);
        }

        return $this->api->call('search', $search);
    }

    public function checkAvailability($par = false, $ret = false)
    {
        set_time_limit(50);

        $fields_string = "obj=" . json_encode($_GET['obj']);
        $results = $this->api->call('checkavail', $fields_string);

        if ($ret == true) {
            $_SESSION['bookingresults'] = $results;

            return $results;
        }

        if ($par != false) {
            $_SESSION['bookingresults'] = $results;
            echo wp_kses_post($results);

            return false;
        }

        $res = json_decode($results);

        if (isset($res->Error)) {
            echo esc_html($res->Error);
        } else {
            $_SESSION['bookingresults'] = $results;
            echo "1";
        }
    }

    public function setFavorites()
    {
        if (isset($_SESSION['favorites'])) {
            foreach ($_SESSION['favorites'] as $unit_id) {
                $this->favorites[] = (int) $unit_id;
            }

            return;
        }

        $this->favorites = [];

        return;
    }

    public function showFavorites()
    {
        if (isset($_GET['shared'])) {
            $_SESSION['cp'] = 1;
            $id = (int) $_GET['shared'];
            $source = "";
            if (isset($_GET['source'])) {
                $source = $_GET['source'];
            }
            $data = json_decode($this->api->call("getshared/" . $id . "/" . $source));
            $_SESSION['compare'] = $data->compare;
            $_SESSION['arrival'] = $data->arrival;
            $_SESSION['depart'] = $data->depart;
        }

        $obj = new \stdClass();

        if (!isset($_GET['favorites'])) {
            if (count($this->favorites) == 0) {
                return $this->themes->load('vrpFavoritesEmpty');
            }

            $url_string = site_url() . "/vrp/favorites/show?";
            foreach ($this->favorites as $unit_id) {
                $url_string .= "&favorites[]=" . $unit_id;
            }
            header("Location: " . $url_string);
        }

        $compare = $_GET['favorites'];
        $_SESSION['favorites'] = $compare;

        if (isset($_GET['arrival'])) {
            $obj->arrival = $_GET['arrival'];
            $obj->departure = $_GET['depart'];
            $_SESSION['arrival'] = $obj->arrival;
            $_SESSION['depart'] = $obj->departure;
        } else {
            if (isset($_SESSION['arrival'])) {
                $obj->arrival = $_SESSION['arrival'];
                $obj->departure = $_SESSION['depart'];
            }
        }

        $obj->items = $compare;
        sort($obj->items);
        $search['search'] = json_encode($obj);
        $results = json_decode($this->api->call('compare', $search));
        if (count($results->results) == 0) {
            return $this->themes->load('vrpFavoritesEmpty');
        }

        $results = $this->prepareSearchResults($results);

        return $this->themes->load('vrpFavorites', $results);
    }

    private function addFavorite()
    {
        if (!isset($_GET['unit'])) {
            return false;
        }

        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }

        $unit_id = $_GET['unit'];
        if (!in_array($unit_id, $_SESSION['favorites'])) {
            array_push($_SESSION['favorites'], $unit_id);
        }

        exit;
    }

    private function removeFavorite()
    {
        if (!isset($_GET['unit'])) {
            return false;
        }
        if (!isset($_SESSION['favorites'])) {
            return false;
        }
        $unit = $_GET['unit'];
        foreach ($this->favorites as $key => $unit_id) {
            if ($unit == $unit_id) {
                unset($this->favorites[$key]);
            }
        }
        $_SESSION['favorites'] = $this->favorites;
        exit;
    }

    private function prepareSearchResults($data)
    {
        foreach ($data->results as $key => $unit) {
            if (strlen($unit->Thumb) == 0) {
                // Replacing non-existent thumbnails w/full size Photo URL
                $unit->Thumb = $unit->Photo;
            }
            $data->results[$key] = $unit;
        }

        return $data;
    }

    private function prepareSearchData()
    {
        $this->search = new \stdClass();

        // Arrival
        if (isset($_GET['search']['arrival'])) {
            $_SESSION['arrival'] = $_GET['search']['arrival'];
        }

        if (isset($_SESSION['arrival'])) {
            $this->search->arrival = date('m/d/Y', strtotime($_SESSION['arrival']));
        } else {
            $this->search->arrival = date('m/d/Y', strtotime("+1 Days"));
        }

        // Departure
        if (isset($_GET['search']['departure'])) {
            $_SESSION['depart'] = $_GET['search']['departure'];
        }

        if (isset($_SESSION['depart'])) {
            $this->search->depart = date('m/d/Y', strtotime($_SESSION['depart']));
        } else {
            $this->search->depart = date('m/d/Y', strtotime("+4 Days"));
        }

        // Nights
        if (isset($_GET['search']['nights'])) {
            $_SESSION['nights'] = $_GET['search']['nights'];
        }

        if (isset($_SESSION['nights'])) {
            $this->search->nights = $_SESSION['nights'];
        } else {
            $this->search->nights = (strtotime($this->search->depart) - strtotime($this->search->arrival)) / 60 / 60 / 24;
        }

        $this->search->type = "";
        if (isset($_GET['search']['type'])) {
            $_SESSION['type'] = $_GET['search']['type'];
        }

        if (isset($_SESSION['type'])) {
            $this->search->type = $_SESSION['type'];
            $this->search->complex = $_SESSION['type'];
        }

        // Sleeps
        $this->search->sleeps = "";
        if (isset($_GET['search']['sleeps'])) {
            $_SESSION['sleeps'] = $_GET['search']['sleeps'];
        }

        if (isset($_SESSION['sleeps'])) {
            $this->search->sleeps = $_SESSION['sleeps'];
        } else {
            $this->search->sleeps = false;
        }

        // Location
        $this->search->location = "";
        if (isset($_GET['search']['location'])) {
            $_SESSION['location'] = $_GET['search']['location'];
        }

        if (isset($_SESSION['location'])) {
            $this->search->location = $_SESSION['location'];
        } else {
            $this->search->location = false;
        }

        // Bedrooms
        $this->search->bedrooms = "";
        if (isset($_GET['search']['bedrooms'])) {
            $_SESSION['bedrooms'] = $_GET['search']['bedrooms'];
        }

        if (isset($_SESSION['bedrooms'])) {
            $this->search->bedrooms = $_SESSION['bedrooms'];
        } else {
            $this->search->bedrooms = false;
        }

        // Adults
        if (isset($_GET['search']['adults'])) {
            $_SESSION['adults'] = (int) $_GET['search']['adults'];
        }

        if (isset($_GET['obj']['Adults'])) {
            $_SESSION['adults'] = (int) $_GET['obj']['Adults'];
        }

        if (isset($_SESSION['adults'])) {
            $this->search->adults = $_SESSION['adults'];
        } else {
            $this->search->adults = 2;
        }

        // Children
        if (isset($_GET['search']['children'])) {
            $_SESSION['children'] = $_GET['search']['children'];
        }

        if (isset($_SESSION['children'])) {
            $this->search->children = $_SESSION['children'];
        } else {
            $this->search->children = 0;
        }

    }

    /**
     * Checks to see if the page loaded is a VRP page.
     * Formally $_GET['action'].
     * @global WP_Query $wp_query
     * @return bool
     */
    public function isVRPPage()
    {
        global $wp_query;
        if (isset($wp_query->query_vars['action'])) { // Is VRP page.
            $this->action = $wp_query->query_vars['action'];

            return true;
        }

        return false;
    }
    /**
     * Class Destruct w/basic debugging.
     */
    public function __destruct()
    {
    }

}
