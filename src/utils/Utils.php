<?php


namespace thinkGql\utils;


use think\facade\Env;

class Utils
{
    public static function getObjectNames(string $type)
    {
        $objectNames = [];
        //Query下所有文件
        $fieldNames = scandir(app_path() . "graphql/$type");
        if (!is_array($fieldNames)) {
            // 读取文件错误
            return $objectNames;
        }
        foreach ($fieldNames as $key => $val) {
            $fieldName = basename($val, '.php');
            if (!is_dir($val)) {
                $objectNames[] = $fieldName;
            }
        }
        return $objectNames;
    }
}
