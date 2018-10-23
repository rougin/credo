<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * Validate Trait Test
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ValidateTraitTest extends \PHPUnit_Framework_TestCase
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
    public function setUp()
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
