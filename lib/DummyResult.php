<?php
/**
 * Dummy Result Class
 *
 * This is a dummy result passed back as a WP_POST.
 *
 * @package VRPConnector
 * @todo Make this class extend \WP_POST
 */

namespace Gueststream;

/**
 * Class DummyResult
 *
 * @package VRPConnector
 */
class DummyResult {

	public $ID;
	/**
	 * @var
	 */
	public $post_title;
	/**
	 * @var
	 */
	public $post_content;
	/**
	 * @var string
	 */
	public $post_name;
	/**
	 * @var string
	 */
	public $post_author;
	/**
	 * @var string
	 */
	public $comment_status = 'closed';
	/**
	 * @var string
	 */
	public $post_status = 'publish';
	/**
	 * @var string
	 */
	public $ping_status = 'closed';
	/**
	 * @var string
	 */
	public $post_type = 'page';
	/**
	 * @var string
	 */
	public $post_date = '';
	/**
	 * @var int
	 */
	public $comment_count = 0;
	/**
	 * @var int
	 */
	public $post_parent = 450;
	/**
	 * @var string
	 */
	public $post_excerpt;

	/**
	 * DummyResult constructor.
	 *
	 * @param $ID
	 * @param $title
	 * @param $content
	 * @param $description
	 */
	public function __construct( $ID, $title, $content, $description ) {
		$this->ID           = $ID;
		$this->post_title   = $title;
		$this->post_content = $content;
		$this->post_excerpt = $description;
		$this->post_author  = 'admin';
	}
}
