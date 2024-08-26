<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ModelTest extends Testcase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @var integer
     */
    protected $rows = 10;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @return void
     */
    public function doSetUp()
    {
        $ci = Instance::create(__DIR__ . '/Weblog');

        $ci->load->helper('inflector');

        $table = (string) singular($this->table);

        $ci->load->model($table, '', true);

        $ci->post->credo(new Credo($ci->db));

        $this->ci = $ci;
    }

    /**
     * @return void
     */
    public function test_delete_from_controller()
    {
        $data = array('subject' => 'test', 'message' => 'test');

        $id = $this->ci->post->insert($data);

        $this->ci->post->delete((int) $id);

        $post = $this->ci->post->find($id);

        $this->assertTrue(empty($post));
    }

    /**
     * @return void
     */
    public function test_get_with_filter()
    {
        $this->ci->post->where('description', 'hdcgXrOKUD');

        $this->assertCount(1, $this->ci->post->get());
    }

    /**
     * @return void
     */
    public function test_get_with_filter_as_array()
    {
        $where = array('description' => 'hdcgXrOKUD');

        $this->ci->post->where((array) $where);

        $this->assertCount(1, $this->ci->post->get());
    }

    /**
     * @return void
     */
    public function test_update_from_controller()
    {
        $data = array('subject' => 'test', 'message' => 'test');

        $this->ci->post->update(3, $data);

        $post = $this->ci->post->find(3);

        $expected = (string) $data['subject'];

        $result = (string) $post->get_subject();

        $this->assertEquals($expected, $result);
    }
}
