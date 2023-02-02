<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Arhitector\Yandex\Disk;
use Laminas\Diactoros\Request;

class YandexDisk extends Model
{
    use HasFactory;
    var $disk;

    public function __construct()
    {
        $this->disk = new Disk(env('YANDEX_DISK_API_TOKEN'));
    }

    public function _ALL($ForderName): array
    {
        // Выведем список корневой папки.
        $path = '/Task_8/'.$ForderName;
        $result = $this->_Request($path);
        return $result["_embedded"];

    }

    private function _Request($path,$fields='', $limit = 1000)
    {
        // Внимание! В запрос будет передан Access Token
        $request = new Request('https://cloud-api.yandex.net/v1/disk/resources?path=' . urlencode($path) . '&fields=' . $fields . '&limit=' . $limit, 'GET');
        $response = $this->disk->send($request);
        $res = json_decode($response->getBody()->getContents(), true);
        return $res;
    }

    public function _getResource($path)
    {
        $resource = $this->disk->getResource($path);

        return $resource->toArray();
    }

    public function _saveFile($path,$fileName)
    {
        $resource = $this->disk->getResource($path);
        $resource->download('./file/'.$fileName, true);
    }

    public function _deleteFile($path)
    {
        $resource = $this->disk->getResource($path);
        // проверить сущестует такой файл на яндекс диске ?
        if ($resource->has())
        {
            $resource->delete();
        }

    }

    public function _uploadFile($file_name, $path)
    {
        $uploaddir = './file';
        $done_files = realpath( "$uploaddir/$file_name");
        $resource = $this->disk->getResource($path.$file_name);
        $resource->upload($done_files);
        unlink($done_files);
    }

    public function _editFile($file_name, $path)
    {
        $uploaddir = './file';
        $done_files = realpath( "$uploaddir/$file_name");
        $resource = $this->disk->getResource($path);
        $resource->upload($done_files, true);
        unlink($done_files);
    }


}
