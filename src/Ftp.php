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
        'List'            => '/data?action=getData&table=ftps',             //获取FTP信息列表
        'SetUserPassword' => '/ftp?action=SetUserPassword',                 //修改FTP账号密码
        'SetStatus'       => '/ftp?action=SetStatus',                       //启用/禁用FTP
        'DeleteUser'      => '/ftp?action=DeleteUser',                      //删除FTP
    ];

    /**
     * 获取FTP列表
     *
     * @param string $search
     * @param int $limit
     * @param int $page
     *
     * @return mixed|bool
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
     * @param string $username
     * @param string $password
     *
     * @return mixed|bool
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
     * @param int $id
     * @param string $username
     * @param int $status 0禁用，1启用
     *
     * @return mixed|bool
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
     * @return mixed|bool
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
