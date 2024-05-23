<?php

declare(strict_types=1);

namespace hulang\Bt;

use hulang\Bt\Exceptions\BtException;
use hulang\tool\File;

class Base
{
    protected $config;
    protected $btPanel;
    protected $btKey;
    protected $cookiePath;
    protected $error;
    /**
     * 初始化
     * @param string $panel 访问URL
     * @param string $key 接口密钥
     * @param string $cookiePath cookie保存路径
     * @return $this
     */
    public function __construct($panel, $key, $cookiePath)
    {
        $this->btPanel = $panel;
        $this->btKey = $key;
        $this->cookiePath = $cookiePath;
    }
    /**
     * 获取[访问URL]
     * @param string $host 访问URL
     * @return $this
     */
    public function panel($host)
    {
        $this->btPanel = $host;
        return $this;
    }
    /**
     * 获取[接口密钥]
     * @param string $key 接口密钥
     * @return $this
     */
    public function key($key)
    {
        $this->btKey = $key;
        return $this;
    }
    /**
     * 设置[错误]
     * @param string $errorMsg 错误信息
     * @return mixed|bool
     */
    protected function error($errorMsg): bool
    {
        $this->error = $errorMsg;
        return false;
    }
    /**
     * 获取[错误]
     * @return $this
     */
    public function getError()
    {
        return $this->error;
    }
    /**
     * curl请求URL
     * @param string $url 访问URL
     * @param array $data 数据
     * @param int $timeout 超时时间
     * @return mixed|array|bool
     */
    public function httpPostCookie($url, $data = [], $timeout = 60)
    {
        if (!$this->btPanel) {
            throw new BtException(101);
        }
        if (!$this->btKey) {
            throw new BtException(102);
        }
        // 定义[cookie]保存位置
        $cookieFile = join(DIRECTORY_SEPARATOR, [
            $this->cookiePath,
            'bt',
            sha1($this->btPanel) . '.cookie'
        ]);
        File::readFile($cookieFile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->btPanel . $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getData($data));
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($ch);

        curl_close($ch);

        if ($output !== false) {
            if (is_array($output)) {
                $result = $output;
            } else {
                $result = json_decode($output, true);
            }
            return $result;
        } else {
            throw new \Exception('返回内容解析失败');
        }
    }
    /**
     * @param $data
     *
     * @return array
     */
    private function getData($data)
    {
        $time = time();
        return array_merge($data, [
            'request_token' => md5($time . '' . md5($this->btKey)),
            'request_time'  => $time,
        ]);
    }
    protected function getUrl($key)
    {
        return $this->config[$key];
    }
}
