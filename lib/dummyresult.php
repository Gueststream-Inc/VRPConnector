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
	/**
	 * Post ID
	 *
	 * @var int
	 */
	public $ID;
	/**
	 * Post Title
	 *
	 * @var string
	 */
	public $post_title;
	/**
	 * Post Content
	 *
	 * @var string
	 */
	public $post_content;
	/**
	 * Post Name
	 *
	 * @var string
	 */
	public $post_name;
	/**
	 * Post Author
	 *
	 * @var string
	 */
	public $post_author;
	/**
	 * Comment Status
	 *
	 * @var string
	 */
	public $comment_status = 'closed';
	/**
	 * Publish Status
	 *
	 * @var string
	 */
	public $post_status = 'publish';
	/**
	 * Ping Status
	 *
	 * @var string
	 */
	public $ping_status = 'closed';
	/**
	 * Post Type
	 *
	 * @var string
	 */
	public $post_type = 'page';
	/**
	 * Post Date
	 *
	 * @var string
	 */
	public $post_date = '';
	/**
	 * Comment Count
	 *
	 * @var int
	 */
	public $comment_count = 0;
	/**
	 * Post Parent
	 *
	 * @var int
	 */
	public $post_parent = 450;
	/**
	 * Post Excerpt
	 *
	 * @var string
	 */
	public $post_excerpt;

	/**
	 * DummyResult constructor.
	 *
	 * @param int    $ID Post ID.
	 * @param string $title Post Title.
	 * @param string $content Post Content.
	 * @param string $description Post Description.
	 */
	public function __construct( $ID, $title, $content, $description ) {
		$this->ID           = $ID;
		$this->post_title   = $title;
		$this->post_content = $content;
		$this->post_excerpt = $description;
		$this->post_author  = 'admin';
	}
}
