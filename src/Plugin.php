<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class Plugin extends Base
{
    protected $config = [
        'Deployment'   => '/deployment?action=GetList',                            //宝塔一键部署列表
        'SetupPackage' => '/plugin?action=a&name=deployment&s=SetupPackage',       //部署任务
        'GetSpeed'     => '/deployment?action=GetSpeed',
    ];

    /**
     * 获取一键部署列表
     *
     * @return bool|mixed
     */
    public function deployment()
    {
        $data = [
            'type' => 1,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Deployment'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 一键部署执行
     *
     * @param  string  $sourceName
     * @param  string  $siteName
     * @param  string  $phpVersion
     *
     * @return bool|mixed
     */
    public function setupPackage($sourceName, $siteName, $phpVersion)
    {
        $data = [
            'dname'       => $sourceName,
            'site_name'   => $siteName,
            'php_version' => $phpVersion,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetupPackage'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取部署进度
     *
     * @return bool|mixed
     */
    public function getSpeed()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetSpeed'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
