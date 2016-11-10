<?php
date_default_timezone_set( 'UTC' );
/**
 * @file CalendarTest.php
 * @project VRPConnector
 * @author Josh Houghtelin <josh@findsomehelp.com>
 * @created 2/19/15 5:30 PM
 */
class CalendarTest extends PHPUnit_Framework_TestCase {

	public function testEmptyConstructor() {
		$calendar = new \Gueststream\Calendar();

		// The date should be today's date (ex: 2015-01-01)
		$this->assertSame( date( 'Y-m-d' ),$calendar->date );

		// The year should be this year (ex: 2015)
		$this->assertSame( date( 'Y' ),$calendar->year );

		// The month should be this month (ex: 01)
		$this->assertSame( date( 'm' ),$calendar->month );

		// The day should be today's day (ex. 01)
		$this->assertSame( date( 'd' ),$calendar->day );
	}

	/**
	 * @dataProvider dateProvider
	 */
	public function testFullDateConstructor( $unixTime ) {
		$date = date( 'Y-m-d',$unixTime );
		$calendar = new \Gueststream\Calendar( $date );

		// The full date should match
		$this->assertSame( date( 'Y-m-d',$unixTime ),$calendar->date );

		// The year should Match
		$this->assertSame( date( 'Y',$unixTime ),$calendar->year );

		// The month should Match
		$this->assertSame( date( 'm',$unixTime ),$calendar->month );

		// The day should Match
		$this->assertSame( date( 'd',$unixTime ),$calendar->day );
	}

	/**
	 * @dataProvider dateProvider
	 */
	public function testYearMonthConstructor( $unixTime ) {
		$calendar = new \Gueststream\Calendar( null,date( 'Y',$unixTime ),date( 'm',$unixTime ) );

		// The year should Match
		$this->assertSame( date( 'Y',$unixTime ),$calendar->year );

		// The month should Match
		$this->assertSame( date( 'm',$unixTime ),$calendar->month );
	}

	/**
	 * @dataProvider dateProvider
	 */
	public function testSetGetDatePartsFromDate( $unixTime ) {
		$calendar = new \Gueststream\Calendar();
		$calendar->set_date_parts_from_date( date( 'Y-m-d',$unixTime ) );

		// The year should Match
		$this->assertSame( date( 'Y',$unixTime ),$calendar->year );

		// The month should Match
		$this->assertSame( date( 'm',$unixTime ),$calendar->month );

		// The day should Match
		$this->assertSame( date( 'd',$unixTime ),$calendar->day );
	}

	/**
	 * @dataProvider dateProvider
	 */
	public function testDayOfWeek( $unixTime ) {
		$calendar = new \Gueststream\Calendar();
		$dayOfWeek = $calendar->day_of_week( $unixTime );
		$this->assertSame( date( 'N',$unixTime ),$dayOfWeek );
	}

	/**
	 * @dataProvider dateProvider
	 */
	public function testOutputCalendar( $unixTime ) {
		$calendar = new \Gueststream\Calendar( date( 'Y-m-d',$unixTime ) );
		$output = $calendar->output_calendar();
		$this->assertFalse( empty( $output ) );
	}

	public function dateProvider() {
		$unixTimes = [];
		// 4 Years + 1 day which should include every possible date to start with.
		for ( $i = 0;$i < 1461 ;$i++ ) {
			$unixTimes[] = strtotime( $i . ' days ago.' );
		}
		return [ $unixTimes ];
	}
}
