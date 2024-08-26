<?php

namespace Rougin\Credo\Traits;

use Rougin\Credo\Testcase;
use Rougin\SparkPlug\Instance;

/**
 * Validate Trait Test
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ValidateTraitTest extends Testcase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * Sets up the Codeigniter application.
     *
     * @return void
     */
    public function doSetUp()
    {
        $path = (string) __DIR__ . '/Weblog';

        $this->ci = Instance::create($path);

        $this->ci->load->model('post');
    }

    /**
     * Tests ValidateTrait::validate.
     *
     * @return void
     */
    public function testValidateMethod()
    {
        $expected = array('subject' => 'The Subject field is required.');

        $post = new \Post(array());

        $post->validate(array('message' => 'test'));

        $result = (array) $post->errors();

        $this->assertEquals($expected, $result);
    }
}
