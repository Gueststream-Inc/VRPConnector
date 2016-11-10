<?php
/**
 * Calendar Generator
 *
 * This class is used to generate HTML availability calendars for on unit pages.
 *
 * @package VRPConnector
 */

namespace Gueststream;

/**
 * Calendar Generation Class
 *
 * This class provides a simple reusable means to produce month calendars in valid html
 *
 * @version 2.8
 * @author Jim Mayes <jim.mayes@gmail.com>
 * @link http://style-vs-substance.com
 * @copyright Copyright (c) 2008, Jim Mayes
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPL v2.0
 */
class Calendar {
	/**
	 * Calendar start date.
	 *
	 * @var false|string
	 */
	var $date;
	/**
	 * Calendar Start Year
	 *
	 * @var null|string
	 */
	var $year;
	/**
	 * Calendar Start Month
	 *
	 * @var string
	 */
	var $month;
	/**
	 * Calendar Start Day
	 *
	 * @var string
	 */
	var $day;
	/**
	 * Week start on date.
	 *
	 * @var bool
	 * @depreciated
	 */
	var $week_start_on = false;
	/**
	 * Week start on date. 7 = Sunday.
	 *
	 * @var int
	 */
	var $week_start = 7;
	/**
	 * Link Days
	 *
	 * @var bool
	 * @depreciated
	 */
	var $link_days = true;
	/**
	 * Link days to
	 *
	 * @var string
	 * @depreciated
	 */
	var $link_to;
	/**
	 * Date Format to link to.
	 *
	 * @var string
	 */
	var $formatted_link_to;
	/**
	 * Add today_date_class to current date on calendar to highlight it
	 *
	 * @var bool
	 */
	var $mark_today = true;
	/**
	 * When mark_today is true, add this to todays calendar date to highlight it.
	 *
	 * @var string
	 */
	var $today_date_class = 'today';
	/**
	 * Add selected_date_class to selected dates.
	 *
	 * @var bool
	 */
	var $mark_selected = true;
	/**
	 * Selected date class to add to selected dates when mark_selected is true.
	 *
	 * @var string
	 */
	var $selected_date_class = 'selected';
	/**
	 * Add passed_date_class to dates on calendar prior to today.
	 *
	 * @var bool
	 */
	var $mark_passed = true;
	/**
	 * Class to add to dates that are before todays date.
	 *
	 * @var string
	 */
	var $passed_date_class = 'passed';
	/**
	 * Array of dates to be highlighted.
	 *
	 * @var array
	 */
	var $highlighted_dates;
	/**
	 * CSS Class to apply to higlighted dates.
	 *
	 * @var string
	 */
	var $default_highlighted_class = 'highlighted';
	/**
	 * CSS Class to apply to arrival dates.
	 *
	 * @var string
	 */
	var $arrival_class = 'aDate';
	/**
	 * CSS Class to apply to departure dates.
	 *
	 * @var string
	 */
	var $depart_class = 'dDate';
	/**
	 * Array of arrival dates.
	 *
	 * @var array
	 */
	var $arrival_dates;
	/**
	 * Array of departure dates.
	 *
	 * @var array
	 */
	var $depart_dates;

	/**
	 * Calendar constructor.
	 *
	 * @param null $date Start date.
	 * @param null $year Start year (if start date not present).
	 * @param null $month Start month (if start date not present).
	 */
	function __construct( $date = null, $year = null, $month = null ) {
		if ( is_null( $year ) || is_null( $month ) ) {
			if ( ! is_null( $date ) ) {
				// -------- strtotime the submitted date to ensure correct format
				$this->date = date( 'Y-m-d', strtotime( $date ) );
			} else {
				// -------------------------- no date submitted, use today's date
				$this->date = date( 'Y-m-d' );
			}
			$this->set_date_parts_from_date( $this->date );
		} else {
			$this->year  = $year;
			$this->month = str_pad( $month, 2, '0', STR_PAD_LEFT );
		}
	}

	/**
	 * Establish Calendar start day, month & year from date.
	 *
	 * @param string $date Calendar Start Date.
	 */
	function set_date_parts_from_date( $date ) {
		$this->year  = date( 'Y', strtotime( $date ) );
		$this->month = date( 'm', strtotime( $date ) );
		$this->day   = date( 'd', strtotime( $date ) );
	}

	/**
	 * Day of the week
	 *
	 * @param string $date Date.
	 *
	 * @return false|int|string
	 */
	function day_of_week( $date ) {
		$day_of_week = date( 'N', $date );
		if ( ! is_numeric( $day_of_week ) ) {
			$day_of_week = date( 'w', $date );
			if ( 0 === $day_of_week ) {
				$day_of_week = 7;
			}
		}

		return $day_of_week;
	}

	/**
	 * Output Calendar
	 *
	 * @param null   $year Output Calendar Year.
	 * @param null   $month Output Calendar Month.
	 * @param string $calendar_class CSS Calendar Class.
	 *
	 * @return string
	 */
	function output_calendar( $year = null, $month = null, $calendar_class = 'calendar' ) {
		if ( false !== $this->week_start_on ) {
			echo 'The property week_start_on is replaced due to a bug present in version before 2.6. of this class! Use the property week_start instead!';
			exit;
		}

		// Override class methods if values passed directly.
		$year  = ( is_null( $year ) ) ? $this->year : $year;
		$month = ( is_null( $month ) ) ? $this->month : str_pad( $month, 2, '0', STR_PAD_LEFT );

		// Create first date of month.
		$month_start_date = strtotime( $year . '-' . $month . '-01' );
		// First day of month falls on what day of week.
		$first_day_falls_on = $this->day_of_week( $month_start_date );
		// Find number of days in month.
		$days_in_month = date( 't', $month_start_date );
		// -------------------------------------------- create last date of month
		$month_end_date = strtotime( $year . '-' . $month . '-' . $days_in_month );
		// ----------------------- calc offset to find number of cells to prepend
		$start_week_offset = $first_day_falls_on - $this->week_start;
		$prepend           = ( $start_week_offset < 0 ) ? 7 - abs( $start_week_offset ) : $first_day_falls_on - $this->week_start;
		// -------------------------- last day of month falls on what day of week
		$last_day_falls_on = $this->day_of_week( $month_end_date );

		// ------------------------------------------------- start table, caption
		$output = '<table class="' . $calendar_class . "\">\n";
		$output .= '<caption>' . ucfirst( strftime( '%B %Y', $month_start_date ) ) . "</caption>\n";

		$col = '';
		$th  = '';
		for ( $i = 1, $j = $this->week_start, $t = ( 3 + $this->week_start ) * 86400; $i <= 7; $i ++, $j ++, $t += 86400 ) {
			$localized_day_name = gmstrftime( '%A', $t );
			$col .= '<col class="' . strtolower( $localized_day_name ) . "\" />\n";
			$th .= "\t<th title=\"" . ucfirst( $localized_day_name ) . '">' . strtoupper( $localized_day_name{0} ) . "</th>\n";
			$j = ( 7 === $j ) ? 0 : $j;
		}

		// ------------------------------------------------------- markup columns
		$output .= $col;

		// ----------------------------------------------------------- table head
		$output .= "<thead>\n";
		$output .= "<tr>\n";

		$output .= $th;

		$output .= "</tr>\n";
		$output .= "</thead>\n";

		// ---------------------------------------------------------- start tbody
		$output .= "<tbody>\n";
		$output .= "<tr>\n";

		// ---------------------------------------------- initialize week counter
		$weeks = 1;

		// --------------------------------------------------- pad start of month
		// ------------------------------------ adjust for week start on saturday
		for ( $i = 1; $i <= $prepend; $i ++ ) {
			$output .= "\t<td class=\"pad\">&nbsp;</td>\n";
		}

		// --------------------------------------------------- loop days of month
		for ( $day = 1, $cell = $prepend + 1; $day <= $days_in_month; $day ++, $cell ++ ) {

			// If this is first cell and not also the first day, end previous row.
			if ( 1 === $cell && 1 !== $day ) {
				$output .= "<tr>\n";
			}

			// Zero pad day and create date string for comparisons.
			$day      = str_pad( $day, 2, '0', STR_PAD_LEFT );
			$day_date = $year . '-' . $month . '-' . $day;

			// Compare day and add classes for matches.
			if ( true === $this->mark_today && date( 'Y-m-d' ) === $day_date ) {
				$classes[] = $this->today_date_class;
			}

			if ( true === $this->mark_selected && $day_date === $this->date ) {
				$classes[] = $this->selected_date_class;
			}

			if ( true === $this->mark_passed && date( 'Y-m-d' ) > $day_date ) {
				$classes[] = $this->passed_date_class;
			}

			if ( is_array( $this->highlighted_dates ) ) {
				if ( in_array( $day_date, $this->highlighted_dates, true ) ) {
					$classes[] = $this->default_highlighted_class;
					if ( in_array( $day_date, $this->arrival_dates, true ) ) {
						$classes[] .= $this->arrival_class;
					}

					if ( in_array( $day_date, $this->depart_dates, true ) ) {
						$classes[] .= $this->depart_class;
					}
				}
			}

			// Loop matching class conditions, format as string.
			if ( isset( $classes ) ) {
				$day_class = ' class="';
				foreach ( $classes as $value ) {
					$day_class .= $value . ' ';
				}
				$day_class = substr( $day_class, 0, - 1 ) . '"';
			} else {
				$day_class = '';
			}

			// Start table cell, apply classes.
			$output .= "\t<td" . $day_class . ' title="'
			           . ucwords( strftime( '%A, %B %e, %Y', strtotime( $day_date ) )
			           ) . '">';

			// Unset to keep loop clean.
			unset( $day_class, $classes );

			$output .= $day;

			// ------------------------------------------------- close table cell
			$output .= "</td>\n";

			// If this is the last cell, end the row and reset cell count.
			if ( 7 === $cell ) {
				$output .= "</tr>\n";
				$cell = 0;
			}
		}

		// ----------------------------------------------------- pad end of month
		if ( $cell > 1 ) {
			for ( $i = $cell; $i <= 7; $i ++ ) {
				$output .= "\t<td class=\"pad\">&nbsp;</td>\n";
			}
			$output .= "</tr>\n";
		}

		// --------------------------------------------- close last row and table
		$output .= "</tbody>\n";
		$output .= "</table>\n";

		// --------------------------------------------------------------- return
		return $output;
	}
}
