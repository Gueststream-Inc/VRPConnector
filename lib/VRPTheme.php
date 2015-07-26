<?php

namespace Gueststream;

/**
 * VRPApi Class
 */

class VRPThemesa
{
    /**
     * Class Construct
     */
    public function __construct()
    {
        $this->initializeThemeActions();
//        $this->apiKey = get_option('vrpAPI');

    }


    /* VRPConnector Plugin Theme Methods */

    /**
     * Set the plugin theme used & include the theme functions file.
     */
    public function setTheme()
    {
        $plugin_theme_Folder = VRP_PATH . 'themes/';
        $theme = get_option('vrpTheme');
        if (!$theme) {
            $theme = $this->default_theme_name;
            $this->themename = $this->default_theme_name;
            $this->theme = $plugin_theme_Folder . $this->default_theme_name;
        } else {
            $this->theme = $plugin_theme_Folder . $theme;
            $this->themename = $theme;
        }
        $this->themename = $theme;

        if (file_exists(get_stylesheet_directory() . "/vrp/functions.php")) {
            include get_stylesheet_directory() . "/vrp/functions.php";
        } else {
            include $this->theme . "/functions.php";
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
    public function loadTheme($section, $data = [])
    {
        $wptheme = get_stylesheet_directory() . "/vrp/$section.php";

        if (file_exists($wptheme)) {
            $load = $wptheme;
        } else {
            $load = $this->theme . "/" . $section . ".php";
        }

        if (isset($_GET['printme'])) {
            include $this->theme . "/print.php";
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
        $theme = new $this->themename;
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
