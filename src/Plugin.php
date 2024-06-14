<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class Plugin extends Base
{
    protected $config = [
        // 获取一键部署列表
        'Deployment'    => '/deployment?action=GetList',
        // 一键部署执行
        'SetupPackage'  => '/plugin?action=a&name=deployment&s=SetupPackage',
        // 获取部署进度
        'GetSpeed'      => '/deployment?action=GetSpeed',
    ];

    /**
     * 获取一键部署列表
     *
     * @return mixed|array|bool
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
     * @param string $sourceName
     * @param string $siteName
     * @param string $phpVersion
     *
     * @return mixed|array|bool
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
     * @return mixed|array|bool
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
