<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class Database extends Base
{
    /**
     * 数据库相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取数据库列表
        'List'          => '/data?action=getData&table=databases',
        // 添加数据库
        'Add'           => '/database?action=AddDatabase',
        // 修改数据库账号密码
        'setPassword'   => '/database?action=ResDatabasePassword',
        // 删除数据库
        'Delete'        => '/database?action=DeleteDatabase',
        // 数据库备份列表
        'Backup'        => '/data?action=getData&table=backup',
        // 创建数据库备份
        'ToBackup'      => '/database?action=ToBackup',
        // 删除数据库备份
        'DelBackup'     => '/database?action=DelBackup',
        // 从备份还原数据库
        'InputSql'      => '/database?action=InputSql'
    ];

    /**
     * 列表
     *
     * @param string $search 搜索
     * @param int $limit 每页数量
     * @param int $page 页码
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
     * 添加
     * @param string $name
     * @param string $username
     * @param string $password
     * @param string $ps
     * @param string $access
     * @param string $address
     * @param string $coding
     * @param string $type
     * @return mixed|bool
     */
    public function add(
        $name,
        $username,
        $password,
        $ps,
        $access = '127.0.0.1',
        $address = '127.0.0.1',
        $coding = 'utf8',
        $type = 'MySQL'
    ) {
        $data = [
            'name'       => $name,
            'codeing'    => $coding,
            'db_user'    => $username,
            'password'   => $password,
            'dtype'      => $type,
            'dataAccess' => $access,
            'address'    => $address,
            'ps'         => $ps,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Add'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改账号密码
     *
     * @param int|string $id
     * @param string $name
     * @param string $password
     *
     * @return mixed|bool
     */
    public function setPwd($id, $name, $password)
    {
        $data = [
            'id'       => $id,
            'name'     => $name,
            'password' => $password,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('setPassword'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除
     *
     * @param int|string $id
     * @param string $name
     *
     * @return mixed|bool
     */
    public function delete($id, $name)
    {
        $data = [
            'id'   => $id,
            'name' => $name,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Delete'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取数据库备份列表
     *
     * @param int $limit 分页条数
     * @param int $page 页码
     * @param string $search 搜索,数据库ID
     *
     * @return mixed|bool
     */
    public function getBackups($search = '', $page = 1, $limit = 5)
    {
        $data = [
            'type'   => 1,
            'limit'  => $limit,
            'p'      => $page,
            'search' => $search,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Backup'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建数据库备份
     *
     * @param int $id 数据库ID
     *
     * @return mixed|bool
     */
    public function backupAdd($id)
    {
        try {
            return $this->httpPostCookie($this->getUrl('ToBackup'), ['id' => $id]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建数据库备份
     *
     * @param int $id 备份ID
     *
     * @return mixed|bool
     */
    public function backupDel($id)
    {
        try {
            return $this->httpPostCookie($this->getUrl('DelBackup'), ['id' => $id]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 从备份还原数据库/导入数据库
     *
     * @param string $filePath 备份文件路径
     * @param string $databaseName 数据库名称
     *
     * @return mixed|array|bool
     */
    public function inputSql($filePath, $databaseName)
    {
        try {
            return $this->httpPostCookie($this->getUrl('InputSql'), [
                'file' => $filePath,
                'name' => $databaseName,
            ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
