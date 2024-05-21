<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class Site extends Base
{
    /**
     * 网站管理相关接口
     *
     * @var string[]
     */
    protected $config = [
        'Websites'          => '/data?action=getData&table=sites',                 //获取网站列表
        'WebTypes'          => '/site?action=get_site_types',                      //获取网站分类
        'GetPHPVersion'     => '/site?action=GetPHPVersion',                       //获取已安装的 PHP 版本列表
        'GetSitePHPVersion' => '/site?action=GetSitePHPVersion',                   //获取指定网站运行的PHP版本
        'SetPHPVersion'     => '/site?action=SetPHPVersion',                       //修改指定网站的PHP版本
        'AddSite'           => '/site?action=AddSite',                             //创建网站
        'DeleteSite'        => '/site?action=DeleteSite',                          //删除网站
        'StopSite'          => '/site?action=SiteStop',                            //停用网站
        'StartSite'         => '/site?action=SiteStart',                           //启用网站
        'SetExpired'        => '/site?action=SetEdate',                            //设置网站有效期
        'SetPs'             => '/data?action=setPs&table=sites',                   //修改网站备注

        'WebBackups' => '/data?action=getData&table=backup',             //获取网站备份列表
        'ToBackup'   => '/site?action=ToBackup',                         //创建网站备份
        'DelBackup'  => '/site?action=DelBackup',                        //删除网站备份

        'DomainList' => '/data?action=getData&table=domain',     //获取网站域名列表
        'AddDomain'  => '/site?action=AddDomain',                //添加网站域名
        'DelDomain'  => '/site?action=DelDomain',                //删除网站域名

        'GetRewriteList' => '/site?action=GetRewriteList',           //获取可选的预定义伪静态列表

        'WebPath' => '/data?action=getKey&table=sites&key=path',    // 获取网站根目录

        'SetHasPwd'     => '/site?action=SetHasPwd',                 //开启并设置网站密码访问
        'CloseHasPwd'   => '/site?action=CloseHasPwd',               //关闭网站密码访问
        'GetDirUserINI' => '/site?action=GetDirUserINI',             //获取网站几项开关（防跨站、日志、密码访问）

        'GetDirBinding' => '/site?action=GetDirBinding',         //获取网站域名绑定二级目录信息
        'AddDirBinding' => '/site?action=AddDirBinding',         //添加网站子目录域名
        'DelDirBinding' => '/site?action=DelDirBinding',         //删除网站绑定子目录
        'GetDirRewrite' => '/site?action=GetDirRewrite',         //获取网站子目录伪静态规则

        'GetSiteLogs'   => '/site?action=GetSiteLogs',                    //获取网站日志
        'GetSecurity'   => '/site?action=GetSecurity',                    //获取网站盗链状态及规则信息
        'SetSecurity'   => '/site?action=SetSecurity',                    //设置网站盗链状态及规则信息
        'GetSSL'        => '/site?action=GetSSL',                         //获取SSL状态及证书详情
        'HttpToHttps'   => '/site?action=HttpToHttps',                    //强制HTTPS
        'CloseToHttps'  => '/site?action=CloseToHttps',                   //关闭强制HTTPS
        'SetSSL'        => '/site?action=SetSSL',                         //设置SSL证书
        'RenewCert'     => '/acme?action=renew_cert',                     //续签SSL证书
        'ApplyCertApi'  => '/acme?action=apply_cert_api',                 //设置 Let's Encrypt 证书
        'CloseSSLConf'  => '/site?action=CloseSSLConf',                   //关闭SSL
        'WebGetIndex'   => '/site?action=GetIndex',                       //获取网站默认文件
        'WebSetIndex'   => '/site?action=SetIndex',                       //设置网站默认文件
        'GetLimitNet'   => '/site?action=GetLimitNet',                    //获取网站流量限制信息
        'SetLimitNet'   => '/site?action=SetLimitNet',                    //设置网站流量限制信息
        'CloseLimitNet' => '/site?action=CloseLimitNet',                  //关闭网站流量限制
        'Get301Status'  => '/site?action=Get301Status',                   //获取网站301重定向信息
        'Set301Status'  => '/site?action=Set301Status',                   //设置网站301重定向信息

        'GetProxyList' => '/site?action=GetProxyList',            //获取网站反代信息及状态
        'CreateProxy'  => '/site?action=CreateProxy',             //添加网站反代信息
        'ModifyProxy'  => '/site?action=ModifyProxy',             //修改网站反代信息

        'GetFileBody'  => '/files?action=GetFileBody',                //获取指定预定义伪静态规则内容(获取文件内容)
        'SaveFileBody' => '/files?action=SaveFileBody',               //保存伪静态规则内容(保存文件内容)
    ];

    /**
     * 获取网站列表
     *
     * @param int $limit 分页条数
     * @param int $page 页码
     * @param string $search 搜索
     * @param string $type 分类标识,-1:全部分类 0:默认分类
     * @param string $order 排序规则 使用 id 降序：id desc
     *
     * @return mixed
     */
    public function getList($search = '', $page = 1, $limit = 200, $type = '-1', $order = 'id desc')
    {
        $data = [
            'search' => $search,
            'p'      => $page,
            'limit'  => $limit,
            'type'   => $type,
            'order'  => $order,
        ];
        try {
            return $this->httpPostCookie($this->getUrl('Websites'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站分类
     *
     * @return mixed
     */
    public function getSiteTypes()
    {
        try {
            return $this->httpPostCookie($this->getUrl('WebTypes'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取已安装的 PHP 版本列表
     *
     * @return mixed
     */
    public function getPHPVersion()
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetPHPVersion'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取指定网站运行的PHP版本
     *
     * @param string $siteName  网站名
     *
     * @return mixed
     */
    public function getSitePHPVersion(string $siteName)
    {
        try {
            return $this->httpPostCookie($this->getUrl('GetSitePHPVersion'), ['siteName' => $siteName]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改指定网站的PHP版本
     *
     * @param $siteName
     * @param $version
     *
     * @return mixed
     */
    public function SetPHPVersion($siteName, $version)
    {
        try {
            return $this->httpPostCookie(
                $this->getUrl('SetPHPVersion'),
                ['siteName' => $siteName, 'version' => $version]
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建网站
     *
     * @param string $webName 网站主域名和域名列表 请传 JSON
     * @param string $path 根目录
     * @param string $ps 备注
     * @param string $version php版本
     * @param bool $ftp 是否创建ftp
     * @param string $ftpUsername ftp用户名
     * @param string $ftpPassword ftp密码
     * @param string $sql 是否创建数据库 MySQL
     * @param string $coding 数据库字符集 utf8|utf8mb4|gbk|big5
     * @param string $dataUser 数据库用户名
     * @param string $dataPassword 数据库密码
     * @param int $type_id 网站分类
     * @param string $port 监听端口
     *
     * @return mixed
     */
    public function add(
        $webName,
        $path,
        $ps = '',
        $version = '',
        $sql = 'MySQL',
        $coding = 'utf8',
        $dataUser = '',
        $dataPassword = '',
        $ftp = false,
        $ftpUsername = '',
        $ftpPassword = '',
        $type_id = 0,
        $port = '80'
    ) {
        $data = [
            'webname'      => json_encode([
                'domain'     => $webName,
                'domainlist' => [],
                'count'      => 0,
            ]),
            'path'         => $path,
            'type_id'      => $type_id,
            'type'         => "PHP",
            'version'      => $version,
            'port'         => $port,
            'ps'           => $ps,
            'ftp'          => $ftp,
            'ftp_username' => $ftpUsername,
            'ftp_password' => $ftpPassword,
            'sql'          => $sql,
            'codeing'      => $coding,
            'datauser'     => $dataUser,
            'datapassword' => $dataPassword,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('AddSite'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站
     *
     * @param int $id 网站ID
     * @param string $webname 网站名称
     * @param int $ftp 删除关联FTP
     * @param int $database 删除关联数据库
     * @param int $path 删除网站目录
     *
     * @return mixed
     */
    public function delete($id, $webname, $ftp = 1, $database = 1, $path = 1)
    {
        $data = compact('id', 'webname');
        $ftp >= 1 && $data['ftp'] = 1;
        $database >= 1 && $data['database'] = 1;
        $path >= 1 && $data['path'] = 1;

        try {
            return $this->httpPostCookie($this->getUrl('DeleteSite'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 停用网站
     *
     * @param int $id 网站ID
     * @param string $name 网站名称
     *
     * @return mixed
     */
    public function stop($id, $name)
    {
        $data = compact('id', 'name');

        try {
            return $this->httpPostCookie($this->getUrl('StopSite'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 启用网站
     *
     * @param int $id 网站ID
     * @param string $name 网站名称
     *
     * @return mixed
     */
    public function start($id, $name)
    {
        $data = compact('id', 'name');

        try {
            return $this->httpPostCookie($this->getUrl('StartSite'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 网站到期时间
     *
     * @param int $id 网站ID
     * @param string $expired 到期时间 永久：0000-00-00
     *
     * @return mixed
     */
    public function setExpired($id, $expired = '0000-00-00')
    {
        $data = [
            'id'    => $id,
            'edate' => $expired,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetExpired'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 网站备注修改
     *
     * @param int $id 网站ID
     * @param string $remark 备注内容
     *
     * @return mixed
     */
    public function setRemark($id, $remark)
    {
        $data = [
            'id' => $id,
            'ps' => $remark,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetPs'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站备份列表
     *
     * @param int $limit 分页条数
     * @param int $page 页码
     * @param string $id 搜索,网站ID
     *
     * @return mixed
     */
    public function getBackupList($id, $page = 1, $limit = 5)
    {
        $data = [
            'type'   => 0,
            'limit'  => $limit,
            'p'      => $page,
            'search' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('WebBackups'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建网站备份
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function addBackup($id)
    {
        try {
            return $this->httpPostCookie($this->getUrl('ToBackup'), ['id' => $id]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建网站备份
     *
     * @param int $id 备份ID
     *
     * @return mixed
     */
    public function deleteBackup($id)
    {
        try {
            return $this->httpPostCookie($this->getUrl('DelBackup'), ['id' => $id]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站域名列表
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function getDomainList($id)
    {
        try {
            return $this->httpPostCookie($this->getUrl('DomainList'), ['search' => $id, 'list' => true]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 添加网站域名
     *
     * @param int $id 网站ID
     * @param string $name 网站名称
     * @param string $domains 域名列表，例：www.123.com:81,多个换行符隔开，默认80端口
     *
     * @return mixed
     */
    public function addDomain($id, $name, $domains)
    {
        $data = [
            'id'      => $id,
            'webname' => $name,
            'domain'  => $domains,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('AddDomain'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站域名
     *
     * @param int $id 网站ID
     * @param string $name 网站名称
     * @param string $domain 域名
     * @param int $port 域名端口
     *
     * @return mixed
     */
    public function deleteDomain($id, $name, $domain, $port = 80)
    {
        $data = [
            'id'      => $id,
            'webname' => $name,
            'domain'  => $domain,
            'port'    => $port,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('DelDomain'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取可选的预定义伪静态列表
     *
     * @param string $siteName 网站名称
     *
     * @return mixed
     */
    public function getRewriteList($siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetRewriteList'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取可选的预定义伪静态列表
     *
     * @param string $name 伪静态名称
     * @param bool $site
     *
     * @return mixed
     */
    public function getRewrite($name, $site = false)
    {
        $dir = $site ? 'vhost/rewrite' : 'rewrite/nginx';

        return $this->getFileBody("/www/server/panel/{$dir}/{$name}.conf");
    }

    /**
     * 获取可选的预定义伪静态列表
     *
     * @param string $name 伪静态名称
     * @param string $content
     * @param bool $site
     *
     * @return mixed
     */
    public function setRewrite(string $name, string $content, $site = false)
    {
        $dir = $site ? 'vhost/rewrite' : 'rewrite/nginx';

        return $this->setFileBody("/www/server/panel/{$dir}/{$name}.conf", $content);
    }

    /**
     * 获取指定网站的根目录
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function getRoot(int $id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('WebPath'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置密码访问网站
     *
     * @param int $id 网站ID
     * @param string $username 用户名
     * @param string $password 密码
     *
     * @return mixed
     */
    public function setHasPwd($id, $username, $password)
    {
        $data = [
            'id'       => $id,
            'username' => $username,
            'password' => $password,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetHasPwd'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭密码访问网站
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function closeHasPwd($id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('CloseHasPwd'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站日志
     *
     * @param string $siteName 网站名
     *
     * @return mixed
     */
    public function getSiteLogs($siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetSiteLogs'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站盗链状态及规则信息
     *
     * @param $id
     * @param $name
     *
     * @return mixed
     */
    public function getSecurity($id, $name)
    {
        $data = [
            'id'   => $id,
            'name' => $name,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetSecurity'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站盗链状态及规则信息
     *
     * @param int $id 网站ID
     * @param string $name 网站名
     * @param string $fix URL后缀
     * @param string $domains 许可域名
     * @param int $status 状态
     *
     * @return mixed
     */
    public function setSecurity($id, $name, $fix, $domains, $status)
    {
        $data = [
            'id'      => $id,
            'name'    => $name,
            'fix'     => $fix,
            'domains' => $domains,
            'status'  => $status,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetSecurity'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站三项配置开关（防跨站、日志、密码访问）
     *
     * @param int $id 网站ID
     * @param string $path 网站运行目录
     *
     * @return mixed
     */
    public function getDirUserINI($id, $path)
    {
        $data = [
            'id'   => $id,
            'path' => $path,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetDirUserINI'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 开启强制HTTPS
     *
     * @param string $siteName 网站域名(纯域名)
     *
     * @return mixed
     */
    public function httpToHttps($siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('HttpToHttps'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭强制HTTPS
     *
     * @param string $siteName 域名(纯域名)
     *
     * @return mixed
     */
    public function closeToHttps($siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('CloseToHttps'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置SSL域名证书
     *
     * @param int $type 类型
     * @param string $siteName 网站名
     * @param string $key 证书key
     * @param string $csr 证书PEM
     *
     * @return mixed
     */
    public function setSSL($type, $siteName, $key, $csr)
    {
        $data = [
            'type'     => $type,
            'siteName' => $siteName,
            'key'      => $key,
            'csr'      => $csr,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetSSL'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     *
     * 续签 SSL 证书
     *
     * @param $index
     *
     * @return bool|mixed
     */
    public function renewCert($index)
    {
        $data = [
            'index' => $index,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('RenewCert'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭SSL
     *
     * @param int $updateOf 修改状态码
     * @param string $siteName 域名(纯域名)
     *
     * @return mixed
     */
    public function closeSSLConf($updateOf, $siteName)
    {
        $data = [
            'updateOf' => $updateOf,
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('CloseSSLConf'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取SSL状态及证书信息
     *
     * @param string $siteName 域名(纯域名)
     *
     * @return mixed
     */
    public function getSSL($siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetSSL'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站默认文件
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function webGetIndex($id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('WebGetIndex'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站默认文件
     *
     * @param int $id 网站ID
     * @param string $index 内容
     *
     * @return mixed
     */
    public function webSetIndex($id, $index)
    {
        $data = [
            'id'    => $id,
            'index' => $index,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('WebSetIndex'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站流量限制信息
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function getLimitNet($id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetLimitNet'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站流量限制信息
     *
     * @param int $id 网站ID
     * @param string $perserver 并发限制
     * @param string $perip 单IP限制
     * @param string $limit_rate 流量限制
     *
     * @return mixed
     */
    public function setLimitNet($id, $perserver, $perip, $limit_rate)
    {
        $data = [
            'id'         => $id,
            'perserver'  => $perserver,
            'perip'      => $perip,
            'limit_rate' => $limit_rate,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SetLimitNet'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭网站流量限制
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function closeLimitNet(int $id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('CloseLimitNet'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站301重定向信息
     *
     * @param string $siteName 网站名
     *
     * @return mixed
     */
    public function get301Status(string $siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Get301Status'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站301重定向信息
     *
     * @param string $siteName 网站名
     * @param string $toDomain 目标Url
     * @param string $srcDomain 来自Url
     * @param int $type 类型
     *
     * @return mixed
     */
    public function set301Status($siteName, $toDomain, $srcDomain, $type)
    {
        $data = [
            'siteName'  => $siteName,
            'toDomain'  => $toDomain,
            'srcDomain' => $srcDomain,
            'type'      => $type,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Set301Status'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站反代信息及状态
     *
     * @param string $siteName 网站名称
     *
     * @return mixed
     */
    public function getProxyList($siteName)
    {
        $data = [
            'siteName' => $siteName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetProxyList'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 添加网站反代信息
     *
     * @param int $cache 是否缓存
     * @param string $proxyname 代理名称
     * @param string $cachetime 缓存时长 /小时
     * @param string $proxydir 代理目录
     * @param string $proxysite 反代URL
     * @param string $todomain 目标域名
     * @param string $advanced 高级功能：开启代理目录
     * @param string $sitename 网站名
     * @param string $subfilter 文本替换json格式[{"sub1":"百度","sub2":"白底"},{"sub1":"","sub2":""}]
     * @param int $type 开启或关闭 0关;1开
     *
     * @return mixed
     */
    public function createProxy(
        $cache,
        $proxyname,
        $cachetime,
        $proxydir,
        $proxysite,
        $todomain,
        $advanced,
        $sitename,
        $subfilter,
        $type
    ) {
        $data = [
            'cache'     => $cache,
            'proxyname' => $proxyname,
            'cachetime' => $cachetime,
            'proxydir'  => $proxydir,
            'proxysite' => $proxysite,
            'todomain'  => $todomain,
            'advanced'  => $advanced,
            'sitename'  => $sitename,
            'subfilter' => $subfilter,
            'type'      => $type,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('CreateProxy'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 添加网站反代信息
     *
     * @param int $cache 是否缓存
     * @param string $proxyname 代理名称
     * @param string $cachetime 缓存时长 /小时
     * @param string $proxydir 代理目录
     * @param string $proxysite 反代URL
     * @param string $todomain 目标域名
     * @param string $advanced 高级功能：开启代理目录
     * @param string $sitename 网站名
     * @param string $subfilter 文本替换json格式[{"sub1":"百度","sub2":"白底"},{"sub1":"","sub2":""}]
     * @param int $type 开启或关闭 0关;1开
     *
     * @return mixed
     */
    public function modifyProxy(
        $cache,
        $proxyname,
        $cachetime,
        $proxydir,
        $proxysite,
        $todomain,
        $advanced,
        $sitename,
        $subfilter,
        $type
    ) {
        $data = [
            'cache'     => $cache,
            'proxyname' => $proxyname,
            'cachetime' => $cachetime,
            'proxydir'  => $proxydir,
            'proxysite' => $proxysite,
            'todomain'  => $todomain,
            'advanced'  => $advanced,
            'sitename'  => $sitename,
            'subfilter' => $subfilter,
            'type'      => $type,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('ModifyProxy'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站域名绑定二级目录信息
     *
     * @param int $id 网站ID
     *
     * @return mixed
     */
    public function getDirBinding($id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetDirBinding'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站域名绑定二级目录
     *
     * @param int $id 网站ID
     * @param string $domain 域名
     * @param string $dirName 目录
     *
     * @return mixed
     */
    public function addDirBinding($id, $domain, $dirName)
    {
        $data = [
            'id'      => $id,
            'domain'  => $domain,
            'dirName' => $dirName,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('AddDirBinding'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站域名绑定二级目录
     *
     * @param int $id 子目录ID
     *
     * @return mixed
     */
    public function delDirBinding($id)
    {
        $data = [
            'id' => $id,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('DelDirBinding'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站子目录绑定伪静态信息
     *
     * @param int $id
     * @param int $type
     *
     * @return bool|mixed
     */
    public function getDirRewrite($id, $type = 0)
    {
        $data = [
            'id' => $id,
        ];
        if ($type) {
            $data['add'] = 1;
        }

        try {
            return $this->httpPostCookie($this->getUrl('GetDirRewrite'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getFileBody($path)
    {
        $data = [
            'path' => $path,
        ];

        try {
            return $this->httpPostCookie($this->getUrl('GetFileBody'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function setFileBody($path, $content)
    {
        $data = [
            'path'     => $path,
            'data'     => $content,
            'encoding' => 'utf-8',
        ];

        try {
            return $this->httpPostCookie($this->getUrl('SaveFileBody'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
