<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 2019/4/1
 */

class WxXcxTest extends TestCase
{
    protected $xcx;
    protected $app_id;
    protected $code;

    public function setUp(): void
    {
        parent::setUp(); //
        $config = [];
        $app_id = 'XXX';

        $this->app_id = $app_id;
        $this->cod = '';
        $config['xcx_wx'] = [
            'app_id' => $app_id,
            'secret' => 'XXX',
        ];
        $this->xcx = new \Uilewis\WxXcx\WxXcx($config);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }




}