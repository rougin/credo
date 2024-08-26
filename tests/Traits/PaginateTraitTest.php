<?php

namespace Rougin\Credo\Traits;

use Rougin\Credo\Testcase;
use Rougin\SparkPlug\Instance;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class PaginateTraitTest extends Testcase
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
    public function test_pagination_result()
    {
        $expected = (int) 10;

        $config = array('page_query_string' => true);

        $config['use_page_numbers'] = true;

        $_GET['per_page'] = (int) 3;

        $post = new \Post;

        $result = $post->paginate(5, 20, $config);

        /** @var integer */
        $result = $result[0];

        $this->assertEquals($expected, $result);
    }
}
