<?php

namespace Gueststream;

/**
 * VRPThemes Class
 */

class VRPThemes
{
    public $theme;
    public $defaultTheme = "mountainsunset"; // Default plugin theme name.
    public $themePath;
    public $availableThemes = [
        'mountainsunset'        => 'Mountain Sunset',
        'oceanbreeze'           => 'Ocean Breeze',
        'relaxation'            => 'Relaxation'
    ];
    public $debug = [];

    /**
     * Class Construct
     */
    public function __construct()
    {
    }


    /* VRPConnector Plugin Theme Methods */

    /**
     * Set the plugin theme used & include the theme functions file.
     */
    public function set($theme = false)
    {
        $themesPath = VRP_PATH . 'themes/'; // this should be a constant in loader.php
        if($theme === false) {
            $this->theme = $this->defaultTheme;
            $this->themePath = $themesPath . $this->defaultTheme;
        } else {
            $this->theme = $theme;
            $this->themePath = $themesPath . $theme;
        }

        if (file_exists(get_stylesheet_directory() . "/vrp/functions.php")) {
            include get_stylesheet_directory() . "/vrp/functions.php";
        } else {
            include $this->themePath . "/functions.php";
        }
    }

    /**
     * Loads the VRP Theme.
     *
     * @param string $section
     * @param        $data [] $data
     *
     * @return string
     */
    public function load($section, $data = [])
    {
        $wptheme = get_stylesheet_directory() . "/vrp/$section.php";

        if (file_exists($wptheme)) {
            $load = $wptheme;
        } else {
            $load = $this->themePath . "/" . $section . ".php";
        }

        if (isset($_GET['printme'])) {
            include $this->themePath . "/print.php";
            exit;
        }

        $this->debug['data'] = $data;
        $this->debug['theme_file'] = $load;

        ob_start();
        include $load;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function initializeThemeActions()
    {
        $theme = new $this->theme;
        if (method_exists($theme, "actions")) {
            $theme->actions();
        }
    }


    /**
     * Class Destruct w/basic debugging.
     */
    public function __destruct()
    {
    }

}
