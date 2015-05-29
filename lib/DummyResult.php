<?php

namespace Gueststream;

class DummyResult
{
    public $ID;
    public $post_title;
    public $post_content;
    public $post_name;
    public $post_author;
    public $comment_status = "closed";
    public $post_status = "publish";
    public $ping_status = "closed";
    public $post_type = "page";
    public $post_date = "";
    public $comment_count = 0;
    public $post_parent = 450;
    public $post_excerpt;

    public function __construct($ID, $title, $content, $description)
    {
        $this->ID = $ID;
        $this->post_title = $title;
        $this->post_content = $content;
        $this->post_excerpt = $description;
        $this->post_author = "admin"; // implement this function
    }
}
