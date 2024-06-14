<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class Ftp extends Base
{
    /**
     * 系统状态相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取FTP信息列表
        'List'              => '/data?action=getData&table=ftps',
        // 修改FTP账号密码
        'SetUserPassword'   => '/ftp?action=SetUserPassword',
        // 启用/禁用FTP
        'SetStatus'         => '/ftp?action=SetStatus',
        // 删除FTP
        'DeleteUser'        => '/ftp?action=DeleteUser',
    ];

    /**
     * 获取FTP列表
     *
     * @param string $search 搜索
     * @param int $limit 每页条数
     * @param int $page 页码
     *
     * @return mixed|array|bool
     */
    public function getList($search = '', $page = 1, $limit = 20)
    {
        $data = [
            'search' => $search,
            'limit'  => $limit,
            'p'      => $page,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('List'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改FTP账号密码
     *
     * @param int $id
     * @param string $username 用户名
     * @param string $password 密码
     *
     * @return mixed|array|bool
     */
    public function setUserPwd($id, $username, $password)
    {
        $data = [
            'id'           => $id,
            'ftp_username' => $username,
            'new_password' => $password,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetUserPassword'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 禁用启用FTP
     *
     * @param int $id ftp用户id
     * @param string $username ftp用户名
     * @param int $status 0禁用，1启用
     *
     * @return mixed|array|bool
     */
    public function setStatus($id, $username, $status)
    {
        $data = [
            'id'       => $id,
            'username' => $username,
            'status'   => $status,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetStatus'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除
     *
     * @param int $id
     * @param string $username
     *
     * @return mixed|array|bool
     */
    public function delete($id, $username)
    {
        $data = [
            'id'       => $id,
            'username' => $username,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('DeleteUser'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
