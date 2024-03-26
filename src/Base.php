<?php

declare(strict_types=1);

namespace hulang\Bt;

use hulang\Bt\Exceptions\BtException;

class Base
{
    protected $config;

    protected $btPanel;

    protected $btKey;

    protected $cookiePath;

    protected $error;

    public function __construct($panel, $key, $cookiePath)
    {
        $this->btPanel = $panel;
        $this->btKey = $key;
        $this->cookiePath = $key;
    }

    public function panel($host)
    {
        $this->btPanel = $host;

        return $this;
    }

    public function key($key)
    {
        $this->btKey = $key;

        return $this;
    }

    protected function error($errorMsg): bool
    {
        $this->error = $errorMsg;

        return false;
    }

    public function getError()
    {
        return $this->error;
    }

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
        if (!file_exists($cookieFile)) {
            $fp = fopen($cookieFile, 'w+');
            fclose($fp);
        }

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
