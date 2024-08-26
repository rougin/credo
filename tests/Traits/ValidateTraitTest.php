<?php

namespace Rougin\Credo\Traits;

use Rougin\Credo\Testcase;
use Rougin\SparkPlug\Instance;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ValidateTraitTest extends Testcase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $path = (string) __DIR__ . '/Weblog';

        $this->ci = Instance::create($path);

        $this->ci->load->model('post');
    }

    /**
     * @return void
     */
    public function test_validation_errors()
    {
        $expected = array('subject' => 'The Subject field is required.');

        $post = new \Post;

        $post->validate(array('message' => 'test'));

        $result = (array) $post->errors();

        $this->assertEquals($expected, $result);
    }
}
