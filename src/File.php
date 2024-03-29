<?php

declare(strict_types=1);

namespace hulang\Bt;

use Exception;

class File extends Base
{
    /**
     * 系统状态相关接口
     *
     * @var string[]
     */
    protected $config = [
        'Upload' => '/files?action=upload' //上传文件
    ];

    /**
     *
     *
     * @param  string  $uploadPath     上传到服务器位置的路径
     * @param  string  $localFilePath  本地文件路径
     *
     * @return array|bool|mixed
     */
    public function upload(string $uploadPath, string $localFilePath)
    {
        file($localFilePath);
        $fileName = explode('/', $localFilePath);
        $data     = [
            'f_path'  => $uploadPath,
            'f_name'  => $fileName,
            'f_size'  => filesize($localFilePath),
            'f_start' => 0,
            'file'    => new \CURLFile($localFilePath, '', 'blob'),
        ];

        try {
            return $this->httpPostCookie($this->getUrl('Upload'), $data, $localFilePath);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
