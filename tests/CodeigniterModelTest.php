<?php

namespace Rougin\Wildfire;

class CodeigniterModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @var integer
     */
    protected $expectedRows = 10;

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
        $appPath = __DIR__ . '/TestApp';

        $this->ci = \Rougin\SparkPlug\Instance::create($appPath);

        $this->ci->load->helper('inflector');

        $this->ci->load->model(singular($this->table), '', true);
    }

    /**
     * Tests CodeigniterModel::get method.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $this->assertCount($this->expectedRows, $this->ci->post->all());
    }

    /**
     * Tests CodeigniterModel::find method.
     *
     * @return void
     */
    public function testFindMethod()
    {
        $expectedId   = 2;
        $expectedName = 'viG iJOzO';

        $post = $this->ci->post->find($expectedId);

        $this->assertEquals($expectedName, $post->get_subject());
    }

    /**
     * Tests CodeigniterModel::delete method.
     *
     * @return void
     */
    public function testDeleteMethod()
    {
        $data = [ 'subject' => 'test', 'message' => 'test' ];

        $id = $this->ci->post->insert($data);

        $this->ci->post->delete($id);

        $post = $this->ci->post->find($id);

        $this->assertTrue(empty($post));
    }

    /**
     * Tests CodeigniterModel::update method.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $expectedId = 3;

        $data = [ 'subject' => 'test', 'message' => 'test' ];

        $this->ci->post->update($expectedId, $data);

        $post = $this->ci->post->find($expectedId);

        $this->assertEquals($data['subject'], $post->get_subject());
    }

    /**
     * Tests CodeigniterModel::validation method.
     *
     * @return void
     */
    public function testValidateMethod()
    {
        $expected  = [ 'subject' => 'The Subject field is required.' ];
        $validated = $this->ci->post->validate([ 'message' => 'test' ]);

        $this->assertEquals($expected, $this->ci->post->validation_errors());
    }

    /**
     * Tests CodeigniterModel::paginate method.
     *
     * @return void
     */
    public function testPaginateMethod()
    {
        $expectedRows = 5;

        $configuration = [
            'page_query_string' => true,
            'use_page_numbers'  => true,
        ];

        $_GET['per_page'] = 1;

        list($items, $links) = $this->ci->post->paginate($expectedRows, $configuration);

        $this->assertCount($expectedRows, $items);
    }
}
