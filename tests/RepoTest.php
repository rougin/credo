<?php

namespace Rougin\Credo;

use Rougin\SparkPlug\Instance;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RepoTest extends Testcase
{
    /**
     * @var \Item_repository
     */
    protected $item;

    /**
     * @var \User_repository
     */
    protected $user;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $app = __DIR__ . '/Weblog';

        $ci = Instance::create($app);

        $ci->load->database();

        $ci->load->model('item');

        $ci->load->repository('item');

        $credo = new Credo($ci->db);

        /** @var \Item_repository */
        $item = $credo->get_repository('Item');
        $this->item = $item;

        /** @var \User_repository */
        $user = $credo->get_repository('User');
        $this->user = $user;
    }

    /**
     * @return void
     */
    public function test_create_method()
    {
        $data = array('name' => 'Credo');

        $expected = $data['name'];

        $this->item->create($data, new \Item);

        $this->item->flush();

        /** @var \Item */
        $model = $this->item->find(1);

        $actual = $model->get_name();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @depends test_update_method
     *
     * @return void
     */
    public function test_delete_method()
    {
        /** @var \Item */
        $result = $this->item->find(1);

        $this->item->delete($result);

        $this->item->flush();

        $result = $this->item->find(1);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function test_dropdown_method()
    {
        $expected = array();
        $expected[1] = 'dQj T pHom';
        $expected[2] = 'TrunNxXQPl';

        $actual = $this->user->dropdown('name');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_total_method()
    {
        $expected = 2;

        $actual = $this->user->total();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @depends test_create_method
     *
     * @return void
     */
    public function test_update_method()
    {
        $data = array('name' => 'Wildfire');

        $expected = $data['name'];

        /** @var \Item */
        $item = $this->item->find(1);

        $this->item->update($item, $data);

        $this->item->flush();

        /** @var \Item */
        $model = $this->item->find(1);

        $actual = $model->get_name();

        $this->assertEquals($expected, $actual);
    }
}
