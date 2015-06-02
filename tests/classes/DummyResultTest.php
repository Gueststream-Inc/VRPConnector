<?php
date_default_timezone_set('UTC');
/**
 * @file DummyResultTest.php
 * @project VRPConnector
 * @author Josh Houghtelin <josh@findsomehelp.com>
 * @created 2/19/15 5:11 PM
 */

class DummyResultTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $id = 1;
        $title = "Dummy Result";
        $content = "All the worlds content is here!";
        $description = "some description";
        $dummyresult = new \Gueststream\DummyResult($id,$title,$content,$description);

        //ID should be what we set it to
        $this->assertSame($id,$dummyresult->ID);

        //Post title should be what we set it do
        $this->assertSame($title,$dummyresult->post_title);

        //Content should be what we set it to.
        $this->assertSame($content,$dummyresult->post_content);
    }

    public function testDefaultPropertyValues()
    {
        $dummyresult = new \Gueststream\DummyResult(0,'some title','some content','some description');

        // Comment Status should be 'closed'
        $this->assertSame('closed',$dummyresult->comment_status);

        // Post Status should be 'publish'
        $this->assertSame('publish',$dummyresult->post_status);

        // Ping Status should be 'closed'
        $this->assertSame('closed',$dummyresult->ping_status);

        // Post Type should be 'page'
        $this->assertSame('page',$dummyresult->post_type);

        // Comment Count should be 0
        $this->assertSame(0,$dummyresult->comment_count);

        // Post Parent should be 450
        $this->assertSame(450,$dummyresult->post_parent);

        // Post Author should be 'admin'
        $this->assertSame('admin',$dummyresult->post_author);
    }
}
