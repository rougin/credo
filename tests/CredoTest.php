<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * Credo Test
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CredoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @var integer
     */
    protected $rows = 2;

    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * Sets up the Codeigniter application.
     *
     * @return void
     */
    public function setUp()
    {
        $app = __DIR__ . '/Weblog';

        $ci = Instance::create($app);

        $ci->load->database();

        $ci->load->model($this->table);

        $ci->load->model('user');

        $this->ci = $ci;
    }

    /**
     * Tests Loader::repository.
     *
     * @return void
     */
    public function testLoadRepository()
    {
        $this->ci->load->repository(array('post', 'user'));

        $post = class_exists('Post_repository');

        $user = class_exists('User_repository');

        $this->assertTrue($post && $user === true);
    }

    /**
     * Tests Credo::getRepository.
     *
     * @return void
     */
    public function testCredo()
    {
        $credo = new Credo($this->ci->db);

        $user = $credo->get_repository('User');

        $result = (array) $user->find_all();

        $this->assertCount($this->rows, $result);
    }
}
