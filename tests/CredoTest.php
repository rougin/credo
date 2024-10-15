<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CredoTest extends Testcase
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
     * @return void
     */
    public function doSetUp()
    {
        $app = __DIR__ . '/Weblog';

        $ci = Instance::create($app);

        $ci->load->database();

        $ci->load->model($this->table);

        $ci->load->model('user');

        $this->ci = $ci;
    }

    /**
     * @return void
     */
    public function test_loading_of_repository()
    {
        $this->ci->load->repository(array('post', 'user'));

        $post = class_exists('Post_repository');

        $user = class_exists('User_repository');

        $this->assertTrue($post && $user === true);
    }

    /**
     * @return void
     */
    public function test_repository_instance()
    {
        $credo = new Credo($this->ci->db);

        /** @var \User_repository */
        $user = $credo->get_repository('User');

        $result = (array) $user->find_all();

        $this->assertCount($this->rows, $result);
    }
}
