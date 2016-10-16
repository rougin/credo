<?php

namespace Rougin\Credo;

use Rougin\Credo\Credo;

class CredoTest extends \PHPUnit_Framework_TestCase
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

        $this->ci = \Rougin\SparkPlug\Instance::create($appPath);

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
        $this->ci->load->repository([ 'post', 'user' ]);

        $this->assertTrue(class_exists('Post_repository') && class_exists('User_repository'));
    }

    /**
     * Tests getting entity repository using Credo.
     *
     * @return void
     */
    public function testCredo()
    {
        $repository = (new Credo)->get_repository('User');

        $this->assertCount($this->expectedRows, $repository->find_all());
    }

    /**
     * Tests EntityManager methods in underscore case.
     *
     * @return void
     */
    public function testUnderscoreMethods()
    {
        $repository = (new Credo($this->ci->db))->get_repository('User');

        $this->assertCount($this->expectedRows, $repository->find_all());
    }
}
