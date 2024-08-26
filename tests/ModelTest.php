<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * Model Test
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
     * Sets up the CodeIgniter application.
     *
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
     * Tests Model::delete.
     *
     * @return void
     */
    public function testDeleteMethod()
    {
        $data = array('subject' => 'test', 'message' => 'test');

        $id = $this->ci->post->insert($data);

        $this->ci->post->delete((integer) $id);

        $post = $this->ci->post->find($id);

        $this->assertTrue(empty($post));
    }

    /**
     * Tests Model::update.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $data = array('subject' => 'test', 'message' => 'test');

        $this->ci->post->update(3, $data);

        $post = $this->ci->post->find(3);

        $expected = (string) $data['subject'];

        $result = (string) $post->get_subject();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Model::where.
     *
     * @return void
     */
    public function testWhereMethod()
    {
        $this->ci->post->where('description', 'hdcgXrOKUD');

        $this->assertCount(1, $this->ci->post->get());
    }

    /**
     * Tests Model::where with array as a parameter.
     *
     * @return void
     */
    public function testWhereWithArrayMethod()
    {
        $where = array('description' => 'hdcgXrOKUD');

        $this->ci->post->where((array) $where);

        $this->assertCount(1, $this->ci->post->get());
    }
}
