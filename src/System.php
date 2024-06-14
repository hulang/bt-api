<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class System extends Base
{
    /**
     * 系统状态相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取系统基础统计
        'GetSystemTotal'    => '/system?action=GetSystemTotal',
        // 获取磁盘分区信息
        'GetDiskInfo'       => '/system?action=GetDiskInfo',
        // 获取实时状态信息(CPU、内存、网络、负载)
        'GetNetWork'        => '/ajax?action=GetTaskCount',
        // 检查是否有安装任务
        'GetTaskCount'      => '/ajax?action=GetTaskCount',
        // 检查面板更新
        'UpdatePanel'       => '/ajax?action=UpdatePanel',
        // 获取全局配置
        'GetConfig'         => '/config?action=get_config',
    ];

    /**
     * 获取系统基础统计
     *
     * @return mixed|array|bool
     */
    public function getSystemTotal()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetSystemTotal'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取磁盘分区信息
     *
     * @return mixed|array|bool
     */
    public function getDiskInfo()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetDiskInfo'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取实时状态信息(CPU、内存、网络、负载)
     *
     * @return mixed|array|bool
     */
    public function getNetWork()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetNetWork'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取全局配置
     *
     * @return mixed|array|bool
     */
    public function GetConfig()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetConfig'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 检查是否有安装任务
     *
     * @return mixed|array|bool
     */
    public function getTaskCount()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetTaskCount'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 检查面板更新
     *
     * @return mixed|array|bool
     */
    public function checkUpdate()
    {
        try {
            return $this->httpPostCookie($this->getUrl('UpdatePanel'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
