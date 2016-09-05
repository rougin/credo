<?php

namespace Rougin\Credo;

use Rougin\Credo\Credo;
use Rougin\SparkPlug\Instance;

use PHPUnit_Framework_TestCase;

class CredoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @var integer
     */
    protected $expectedRows = 2;

    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * Sets up the CodeIgniter application.
     *
     * @return void
     */
    public function setUp()
    {
        $appPath = __DIR__ . '/TestApp';

        $this->ci = Instance::create($appPath);

        $this->ci->load->database();
        $this->ci->load->model($this->table);
        $this->ci->load->model('user');
    }

    /**
     * Tests the $this->load->repository functionality.
     *
     * @return void
     */
    public function testLoadRepository()
    {
        $this->ci->load->repository(['post', 'user']);

        $this->assertTrue(class_exists('Post_repository'));
        $this->assertTrue(class_exists('User_repository'));
    }

    public function testCredo()
    {
        $credo = new Credo;

        $repository = $credo->get_repository('User');
        $users = $repository->find_all();

        $this->assertCount($this->expectedRows, $users);
    }

    /**
     * Tests EntityManager methods in underscore case.
     *
     * @return void
     */
    public function testUnderscoreMethods()
    {
        $credo = new Credo($this->ci->db);

        $repository = $credo->get_repository('User');
        $users = $repository->find_all();

        $this->assertInstanceOf('User_repository', $repository);
        $this->assertCount($this->expectedRows, $users);
    }

    /**
     * Tests methods that does not belong to EntityManager.
     *
     * @return void
     */
    public function testMethodNotFound()
    {
        $credo = new Credo($this->ci->db);

        $repository = $credo->get_repository('User');
        $users = $repository->find_all_foo();

        $this->assertInstanceOf('User_repository', $repository);
    }
}
