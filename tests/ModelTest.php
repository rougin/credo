<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * Model Test
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ModelTest extends \PHPUnit_Framework_TestCase
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
    public function setUp()
    {
        $app = (string) __DIR__ . '/Weblog';

        $ci = Instance::create($app);

        $ci->load->helper('inflector');

        $table = (string) singular($this->table);

        $ci->load->model($table, '', true);

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
     * Tests Model::find.
     *
     * @return void
     */
    public function testFindMethod()
    {
        list($id, $expected) = array(2, 'viG iJOzO');

        $post = $this->ci->post->find((integer) $id);

        $result = (string) $post->get_subject();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Model::get.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $this->assertCount($this->rows, $this->ci->post->all());
    }

    /**
     * Tests Model::paginate.
     *
     * @return void
     */
    public function testPaginateMethod()
    {
        $config = array();

        $expected = 5;

        $_GET['per_page'] = 1;

        $config['page_query_string'] = true;

        $config['use_page_numbers'] = true;

        $result = $this->ci->post->paginate($expected, $config);

        $this->assertCount($expected, $result[0]);
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
     * Tests Model::validation.
     *
     * @return void
     */
    public function testValidateMethod()
    {
        $message = 'The Subject field is required.';

        $expected = array('subject' => $message);

        $this->ci->post->validate(array('message' => 'test'));

        $result = $this->ci->post->validation_errors();

        $this->assertEquals($expected, (array) $result);
    }
}
