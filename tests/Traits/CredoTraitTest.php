<?php

namespace Rougin\Credo\Traits;

use Rougin\SparkPlug\Instance;
use Rougin\Credo\Testcase;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CredoTraitTest extends Testcase
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
     * @return void
     */
    public function doSetUp()
    {
        $path = (string) __DIR__ . '/Weblog';

        $this->ci = Instance::create($path);

        $this->ci->load->database();

        $this->ci->load->model('post');
    }

    /**
     * @return void
     */
    public function test_find_from_controller()
    {
        list($id, $expected) = array(2, 'viG iJOzO');

        $post = $this->ci->post->find((int) $id);

        $result = (string) $post->get_subject();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function test_findBy_from_controller()
    {
        $this->assertCount($this->rows, $this->ci->post->findBy());
    }

    /**
     * @return void
     */
    public function test_get_from_controller()
    {
        $this->assertCount($this->rows, $this->ci->post->get());
    }
}
