<?php
/**
 * Desert Sunrise Theme functions file
 *
 * @package VRPConnector
 * @since 1.3.5
 */

/**
 * Class desertsunrise
 *
 * Desert Sunrise theme class
 */

class desertsunrise  {

	/**
	 * Theme actions - Enqueue scripts and styles.
	 */
	function actions() {
		add_action( 'wp_enqueue_scripts', [ $this, 'my_scripts_method' ] );
		add_action( 'wp_print_styles', [ $this, 'add_my_stylesheet' ] );
	}

	/**
	 * Enqueuing Scripts.
	 */
	function my_scripts_method() {
        if (file_exists(get_stylesheet_directory() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.js')) {
			wp_register_script(
				'VRPjQueryUI',
				get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.js',
				[ 'jquery' ]
			);
		} else {
			wp_register_script(
				'VRPjQueryUI',
				plugins_url( '/desertsunrise/css/jquery-ui-1.12.1.custom/jquery-ui.js', dirname( __FILE__ ) ),
				[ 'jquery' ]
			);
		}
		wp_enqueue_script( 'VRPjQueryUI' );

		$this->enqueue_theme_script('vrpNamespace','vrp.namespace.js',['jquery']);
		$this->enqueue_theme_script( 'vrpMRespondModule', 'vrp.mRespond.js', [ 'jquery' ] );
		$this->enqueue_theme_script( 'vrpUIModule', 'vrp.ui.js', [ 'jquery' ] );
		$this->enqueue_theme_script( 'vrpQueryStringModule', 'vrp.queryString.js', [ 'jquery' ] );

        //Google Map Key must be replaced with generated key
		$vrpMapKey_default='';
        $vrpMapKey=get_option( 'vrpMapKey', $vrpMapKey_default );

        wp_enqueue_script( 'googleMap', 'https://maps.googleapis.com/maps/api/js?key='.$vrpMapKey);

		$this->enqueue_theme_script( 'VRPthemeJS', 'js.js', [ 'jquery' ] );

		// Result List Map
		$this->enqueue_theme_script( 'VRPResultMap', 'vrp.resultListMap.js', [ 'jquery', 'googleMap' ] );
        // Results JS
        $this->enqueue_theme_script( 'VRPResults', 'vrp.results.js', [ 'jquery' ] );

		// Unit Page
		$this->enqueue_theme_script( 'VRPUnitPage', 'vrp.unit.js', [ 'jquery', 'googleMap' ] );

        $this->enqueue_theme_script( 'LightSlider', 'lightslider.min.js', [ 'jquery'] );

		$this->enqueue_theme_script( 'VRPCheckoutBarefoot', 'vrp.checkout.barefoot.js', [ 'jquery' ] );

		$script_vars = [
			'site_url'           => site_url(),
			'stylesheet_dir_url' => get_stylesheet_directory_uri(),
			'plugin_url'         => plugins_url( '', dirname( dirname( __FILE__ ) ) ),
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'nonce'              => wp_create_nonce( 'vrp-xsrf-prevention' ),
		];
		wp_localize_script( 'VRPthemeJS', 'url_paths', $script_vars );
	}

	/**
	 * Local theme script enqueue helper.
	 *
	 * @param $handle
	 * @param $script
	 * @param $deps
	 */
	private function enqueue_theme_script( $handle, $script, $deps ) {
		if ( file_exists( get_stylesheet_directory() . '/vrp/js/' . $script ) ) {
			wp_enqueue_script(
				$handle,
				get_stylesheet_directory_uri() . '/vrp/js/' . $script,
				$deps
			);
		} else {
			wp_enqueue_script(
				$handle,
				plugins_url( '/desertsunrise/js/' . $script, dirname( __FILE__ ) ),
				$deps
			);
		}
	}

	/**
	 * Enqueuing Stylesheets.
	 */
	public function add_my_stylesheet() {
		if ( file_exists( get_stylesheet_directory() . '/vrp/css/font-awesome.css' ) ) {
			wp_enqueue_style( 'FontAwesome', get_stylesheet_directory_uri() . '/vrp/css/font-awesome.css' );
		} else {
			wp_enqueue_style( 'FontAwesome',
				plugins_url( '/desertsunrise/css/font-awesome.css', dirname( __FILE__ ) ) );
		}
       
        if ( file_exists( get_stylesheet_directory() . '/vrp/css/lightslider.min.css' ) ) {
            wp_enqueue_style( 'LightSlider', get_stylesheet_directory_uri() . '/vrp/css/lightslider.min.css' );
        } else {
            wp_enqueue_style( 'LightSlider',
                plugins_url( '/desertsunrise/css/lightslider.min.css', dirname( __FILE__ ) ) );
        }

		if ( file_exists( get_stylesheet_directory() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.css' ) ) {
			wp_enqueue_style( 'VRPjQueryUISmoothness',
				get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.css' );
		} else {
			wp_enqueue_style( 'VRPjQueryUISmoothness',
				plugins_url( '/desertsunrise/css/jquery-ui-1.12.1.custom/jquery-ui.css', dirname( __FILE__ ) ) );
		}

		if ( ! file_exists( get_stylesheet_directory() . '/vrp/css/css.css' ) ) {
			$myStyleUrl = plugins_url(
				'/desertsunrise/css/css.css', dirname( __FILE__ )
			);
		} else {
			$myStyleUrl = get_stylesheet_directory_uri() . '/vrp/css/css.css';
		}

            if ( file_exists( get_stylesheet_directory() . '/vrp/css/booking.custom.css' ) ) {
                wp_enqueue_style( 'BookingCSS',
                    get_stylesheet_directory_uri() . '/vrp/css/booking.custom.css' );
            } else {
                wp_enqueue_style( 'BookingCSS',
                    plugins_url( '/vrp/css/booking.custom.css', dirname( __FILE__ ) ) );
            }



		wp_register_style( 'themeCSS', $myStyleUrl );
		wp_enqueue_style( 'themeCSS' );
	}
}

function generateList( $list, $options = [] ) {

	$configured_options = [ 'attr' => '', 'child' => 'children' ];

	if ( ! empty( $options['child'] ) ) {
		$configured_options['child'] = $options['child'];
	}
	if ( ! empty( $options['attr'] ) ) {
		$configured_options['attr'] = $options['attr'];
	}

	$options = (object) $configured_options;

	$recursive = function ( $dataset, $child = false, $options ) use ( &$recursive ) {

		$html = "<ul $options->attr>"; // Open the menu container.

		foreach ( $dataset as $title => $properties ) {

			$sub_menu = '';

			$children = ( ! empty( $properties[ $options->child ] ) ? true : false );

			if ( $children ) {
				$sub_menu = $recursive( $properties[ $options->children ], true, $options );
			}

			$html .= '<li class="' . ( ! empty( $properties['class'] ) ? $properties['class'] : '' ) . '"><a class="'
			         . ( ! empty( $properties['disabled'] ) && true === $properties['disabled'] ? ' disabled ' : '' )
			         . ( ! empty( $properties['selected'] ) ? ' current ' : '' ) . '" href="?'
			         . $properties['pageurl']
			         . '&show=' . $properties['show']
			         . '&page=' . $properties['page']
			         . '">' . $title . '</a>'
			         . $sub_menu . '</li>';

			unset( $children, $sub_menu );

		}

		return $html . '</ul>';
	};

	return $recursive( $list, false, $options );

}

function generateSearchQueryString() {

	$field_string = '';

	foreach ( $_GET['search'] as $key => $value ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $v ) :
				$field_string .= 'search[' . $key . '][]=' . $v . '&';
			endforeach;
		} else {
			$field_string .= 'search[' . $key . ']=' . $value . '&';
		}
	}

	return rtrim( $field_string, '&' );
}

function vrp_pagination( $total_pages, $cur_page = 1 ) {
	$_SESSION['pageurl'] = $pageurl = generateSearchQueryString();
	$cur_page            = (int) esc_attr( $cur_page );
	$pageurl             = esc_attr( $pageurl );
	$show                = ( ! empty( $_GET['show'] ) ? esc_attr( $_GET['show'] ) : 10 );

	$total_range = (int) ( $total_pages > 5 ? $cur_page + 4 : $total_pages );
	$start_range = (int) ( $cur_page > 5 ? $cur_page - 4 : 1 );

	if ( $total_range > $total_pages ) {
		$total_range = $total_pages;
	}

	$list = [];

	$list['Prev'] = [
		'pageurl'  => $pageurl,
		'show'     => $show,
		'page'     => ( $cur_page - 1 ),
		'class'    => 'vrp-pagination-btn',
		'disabled' => ( $cur_page !== 1 ? false : true )
	];

	foreach ( range( $start_range, $total_range ) as $inc_page ) {

		$inc_page = (int) esc_attr( $inc_page );

		if ( $cur_page === $inc_page ) {
			$list[ $cur_page ] = [ 'pageurl' => $pageurl, 'show' => $show, 'page' => $cur_page, 'selected' => true ];
			continue;
		}

		$list[ $inc_page ] = [ 'pageurl' => $pageurl, 'show' => $show, 'page' => $inc_page ];

	}

	$list['Last'] = [
		'active'   => false,
		'pageurl'  => $pageurl,
		'show'     => $show,
		'page'     => $total_pages,
		'class'    => 'vrp-pagination-btn',
		'disabled' => ( $total_pages > 5 ? false : true )
	];
	$list['Next'] = [
		'active'   => false,
		'pageurl'  => $pageurl,
		'show'     => $show,
		'page'     => ( $cur_page + 1 ),
		'class'    => 'vrp-pagination-btn',
		'disabled' => ( $cur_page < $total_pages ? false : true )
	];

	return generateList( $list, [ 'attr' => 'class="vrp-cd-pagination"' ] );
}

function vrpsortlinks( $unit ) {

	if ( isset( $_GET['search']['order'] ) ) {
		$order = $_GET['search']['order'];
	} else {
		$order = 'low';
	}

	$fields_string = '';
	foreach ( $_GET['search'] as $key => $value ) {
		if ( $key == 'sort' ) {
			continue;
		}
		if ( $key == 'order' ) {
			continue;
		}
		$fields_string .= 'search[' . $key . ']=' . $value . '&';
	}
	rtrim( $fields_string, '&' );
	$pageurl = $fields_string;

	$sortoptions = [ 'Bedrooms' ];

	if ( isset( $unit->Rate ) ) {
		$sortoptions[] = 'Rate';
	}

	echo "<select class='vrpsorter'>";
	echo "<option value=''>Sort By</option>";

	if ( isset( $_GET['search']['sort'] ) ) {
		$sort = $_GET['search']['sort'];
	} else {
		$sort = '';
	}
	$show = ( ! empty( $_GET['show'] ) ? esc_attr( $_GET['show'] ) : 10 );
	foreach ( $sortoptions as $s ) {

		$pageurl = esc_attr( $pageurl );
		$order   = esc_attr( $order );

		if ( $sort == $s ) {
			if ( $order == 'low' ) {
				$order = 'high';
				$other = 'low';
			} else {
				$order = 'low';
				$other = 'high';
			}

			echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=' . $order . '">' . $s . '(' . $other . ' to ' . $order . ')</option>';
			echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=' . $order . '">' . $s . '(' . $order . 'to' . $other . ')</option>';
			continue;
		}

		echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=low">' . $s . '(low to high)</option>';
		echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=high">' . $s . '(high to low)</option>';
	}
	echo '</select>';
}

/**
 * Display drop down to select how many results per page to display.
 */
function vrp_resultsperpage() {
	$fields_string = '';
	foreach ( $_GET['search'] as $key => $value ) {
		$fields_string .= 'search[' . $key . ']=' . $value . '&';
	}

	$fields_string = rtrim( $fields_string, '&' );
	$pageurl       = $fields_string;

	if ( isset( $_GET['show'] ) ) {
		$show = (int) $_GET['show'];
	} else {
		$show = 10;
	}
	echo "<select autocomplete='off' name='resultCount' class='vrpshowing'>";
	echo "<option value=''>Show</option>";
	foreach ( [ 10, 20, 30 ] as $v ) {
		echo '<option ' . ( ! empty( $_GET['show'] ) && (int) $_GET['show'] == $v ? 'selected="selected"' : '' ) . ' value="?' . esc_attr( $pageurl ) . '&show=' . esc_attr( $v ) . '">' . esc_attr( $v ) . '</option>';
	}
	echo '</select>';
}

/**
 * @param string $start_date Start date in series.
 * @param int $num Number of dates in series.
 *
 * @return array
 */
function date_series( $start_date, $num ) {
	$dates = [];

	$dates[0] = $start_date;
	for ( $i = 0; $i < $num; $i ++ ) {
		$start   = strtotime( end( $dates ) );
		$day     = mktime( 0, 0, 0, date( 'm', $start ), date( 'd', $start ) + 1, date( 'Y', $start ) );
		$dates[] = date( 'Y-m-d', $day );
	}

	return $dates;
}

/**
 * @param int $from Unix time start date.
 * @param int $to Unit time end date.
 * @param bool $round Whether or not to round to the next day.
 *
 * @return float
 */
function days_to( $from, $to, $round = true ) {
	$from = strtotime( $from );
	$to   = strtotime( $to );
	$diff = $to - $from;
	$days = $diff / 86400;

	return (true === $round) ? floor( $days ) : round( $days, 2 );
}

/**
 * Generate HTML Calendar for unit page.
 *
 * @param array $r Calendar array.
 * @param int   $total_months Total Months to display.
 *
 * @return string
 */
function vrp_calendar( $r, $total_months = 5 ) {

	$datelist = [];
	$arrivals = [];
	$departs  = [];

	foreach ( $r as $v ) {
		$from_date  = $v->start_date;
		$arrivals[] = $from_date;
		$to_date    = $v->end_date;
		$departs[]  = $to_date;
		$num        = days_to( $from_date, $to_date );
		$datelist[] = date_series( $from_date, $num );
	}

	$final_date = [];

	foreach ( $datelist as $v ) {
		foreach ( $v as $v2 ) {
			$final_date[] = $v2;
		}
	}

	$today                       = strtotime( date( 'Y' ) . '-' . date( 'm' ) . '-01' );
	$calendar                    = new \Gueststream\Calendar( date( 'Y-m-d' ) );
	$calendar->highlighted_dates = $final_date;
	$calendar->arrival_dates     = $arrivals;
	$calendar->depart_dates      = $departs;
	$the_key                     = "<div class=\"calkey\" style='clear:both'><span style=\"float:left;display:block;width:15px;height:15px;border:1px solid #404040;\" class=\"isavailable\"> &nbsp;</span> <span style=\"float:left;\">&nbsp; Available</span> <span style=\"float:left;display:block;width:15px;height:15px;;margin-left:10px;border:1px solid #404040;\" class=\"notavailable highlighted\"> &nbsp;</span> <span style=\"float:left;\">&nbsp; Unavailable</span><span style=\"margin-left:10px;float:left;display:block;width:15px;height:15px;border:1px solid #404040;\" class=\"isavailable dDate\"></span><span style=\"float:left;\">&nbsp; Check-In Only</span><span style=\"margin-left:10px;float:left;display:block;width:15px;height:15px;border:1px solid #404040;\" class=\"isavailable aDate\"></span><span style=\"float:left;\">&nbsp; Check-Out Only</span><br style=\"clear:both;\" /></div><br style=\"clear:both;\" />";
	$ret                         = '';
	$x                           = 0;

	for ( $i = 0; $i <= $total_months; $i ++ ) {

		$nextyear  = date( 'Y', mktime( 0, 0, 0, date( 'm', $today ) + $i, date( 'd', $today ), date( 'Y', $today ) ) );
		$nextmonth = date( 'm', mktime( 0, 0, 0, date( 'm', $today ) + $i, date( 'd', $today ), date( 'Y', $today ) ) );

		$ret .= $calendar->output_calendar( $nextyear, $nextmonth );
		if ( 3 === $x ) {
			$ret .= '';
			$x = - 1;
		}
		$x ++;
	}

	return '' . $ret . $the_key;
}
/**
 * @param $string - Input string to convert to array
 * @param string $separator - Separator to separate by (default: ,)
 *
 * @return array
 */
function comma_separated_to_array($string, $separator = ',')
{
    //Explode on comma
    $vals = explode($separator, $string);

    //Trim whitespace
    foreach($vals as $key => $val) {
        $vals[$key] = trim($val);
    }
    //Return empty array if no items found
    //http://php.net/manual/en/function.explode.php#114273
    return array_diff($vals, array(""));
}

function vrpResultsSearchForm() {
    ob_start(); ?>
    <?php include STYLESHEETPATH . "/vrp/vrpResultsSearchForm.php"; ?>
    <?php return ob_get_clean();
}

add_shortcode("vrpResultsSearchForm","vrpResultsSearchForm");