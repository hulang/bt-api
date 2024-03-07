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
        'GetSystemTotal' => '/system?action=GetSystemTotal',                //获取系统基础统计
        'GetDiskInfo'    => '/system?action=GetDiskInfo',                   //获取磁盘分区信息
        'GetNetWork'     => '/system?action=GetNetWork',                    //获取实时状态信息(CPU、内存、网络、负载)
        'GetTaskCount'   => '/ajax?action=GetTaskCount',                    //检查是否有安装任务
        'UpdatePanel'    => '/ajax?action=UpdatePanel',                     //检查面板更新
    ];

    /**
     * 获取系统基础统计
     *
     * @return false|mixed
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
     * @return false|mixed
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
     * @return false|mixed
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
     * 检查是否有安装任务
     *
     * @return false|mixed
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
     * @return false|mixed
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
