<?php

namespace App\Http\Controllers;
use App\Models\YandexDisk;

use Illuminate\Http\File;
use Illuminate\Http\Request;

class YandexDiskController extends Controller
{
    public function index(Request $request)
    {
        $ForderName = '';
//        if (!isset($_POST))
//        {
//            $ForderName = $_POST['name'];
//        }

        $YandexDisk = new YandexDisk();
        $arResult = $YandexDisk->_ALL($ForderName);

        if ($arResult["path"] != "disk:/Task_8"){ $arResult["path"] = str_replace("disk:/Task_8/", "", $arResult["path"]); } else {$arResult["path"] = "";}



        $counte = count($arResult["items"]);

        for ($i = 0; $i <= $counte-1; $i++)
        {
            if (empty($arResult["items"][$i]["size"])) { $arResult["items"][$i]["size"] = '';}
            if ($arResult["items"][$i]["type"] == "dir")
            {
                $arResult["items"][$i]["type"] = array(
                    "type"=>"dir",
                    "viewBox"=>"0 0 48 48",
                    "type_path"=>"svg-folder-fg",
                    "svg_type"=>"svg-folder"
                );
            }
            else
            {
                $arResult["items"][$i]["type"] = array(
                    "type"=>"file",
                    "viewBox"=>"0 0 56 56",
                    "type_path"=>"svg-path-image",
                    "svg_type"=>"svg-image"
                );
            }
            $arResult["items"][$i]["modified"] = date("Y-m-d H:m:s", strtotime($arResult["items"][$i]["modified"]));


        }






        return view('ya-disk.index',compact('arResult'));
    }

    public function View(Request $request)
    {
        $arResult = [];
        $fileName = $request->FileName;
        $YandexDisk = new YandexDisk();

        $path =  $request->FilePath.$fileName;
        $arResult = $YandexDisk->_getResource($path);
        $arResult["html_view"] = "";

        $file = $YandexDisk->_saveFile($path,$fileName);

        if ($arResult["mime_type"] == "text/plain" or $arResult["mime_type"] =="text/x-php")
        {
            $arResult["html_view"] = file_get_contents('./file/'.$fileName, FILE_USE_INCLUDE_PATH);
        }

        $pieces = explode(".", $arResult["name"]);
        $arResult["mime_type"] = $pieces[1];
        $arResult["modified"] = date("Y-m-d H:m:s", strtotime($arResult["modified"]));

        //переводим в json и возвращаем данные json_encode
        return ($arResult);
    }

    public function Delete(Request $request)
    {
        $YandexDisk = new YandexDisk();
        $fileName = $request->FileName;
        $path =  $request->FilePath.$fileName;
        $YandexDisk->_deleteFile($path);
        die();
    }

    public function Upload(Request $request)
    {
        $path =  $request->FilePath;
        $file_name = $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], './upload/'. $file_name);

        $YandexDisk = new YandexDisk();
        $YandexDisk->_uploadFile($file_name,$path);

        die();
    }

    public function Save(Request $request)
    {
        $YandexDisk = new YandexDisk();
        $value = $request->Value;
        $fileName = $request->FileName;
        $path =  $request->FilePath;

        if (file_exists('./file/'.$fileName))
        {
            file_put_contents('./file/'.$fileName, $value);
            $YandexDisk = new YandexDisk();
            $YandexDisk->_editFile($fileName,$path);
        }
        die();

    }

}
