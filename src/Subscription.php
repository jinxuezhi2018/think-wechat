<?php

use Util\Curl;
class Subscription
{
    private $curl = null;
    protected $config = [
        'appid' => '',
        'secret' => '',
        'grant_type' => 'client_credential'
    ];

    protected $result = [
        'status'=>false,
        'msg'=>'',
        'data'=>[]
    ];

    public function __construct( $config=[] )
    {
        $this->config = array_merge($this->config,$config);
        $this->curl = new Curl();
    }

    /**
     * 获取 Access token
     */
    public function getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->config['appid'].'&secret='.$this->config['secret'];
        return json_decode($this->curl->getInfo($url,'GET','',''),true);
    }

    /**
     * 小程序 - 获取关联服务号素材列表
     * type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
     * offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
     * count 返回素材的数量，取值在1到20之间
     * no_content 1 表示不返回 content 字段，0 表示正常返回，默认为 0
     */
    public function getFreepublish($access_token,$offset=0,$count=20,$no_content=0){

        $url = 'https://api.weixin.qq.com/cgi-bin/freepublish/batchget?access_token='.$access_token;
        $data = [
            'offset'=>$offset,
            'count'=>$count,
            'no_content'=>$no_content
        ];
        return json_decode($this->curl->getInfo($url,'POST','',json_encode($data)),true);
    }

}
