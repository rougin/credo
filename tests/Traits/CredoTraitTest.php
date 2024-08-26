<?php

namespace Rougin\Credo\Traits;

use Rougin\SparkPlug\Instance;
use Rougin\Credo\Testcase;

/**
 * Credo Trait Test
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
     * Sets up the Codeigniter application.
     *
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
     * Tests CredoTrait::find.
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
     * Tests CredoTrait::findBy.
     *
     * @return void
     */
    public function testFindByMethod()
    {
        $this->assertCount($this->rows, $this->ci->post->findBy());
    }

    /**
     * Tests CredoTrait::get.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $this->assertCount($this->rows, $this->ci->post->get());
    }
}
