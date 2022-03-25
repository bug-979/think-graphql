<?php


namespace thinkGql;


use GraphQL\Type\Definition\ObjectType;

class Schema
{
    public static function create()
    {
        var_dump('测试composer');
    }

    private function getObjectNameList(string $folder)
    {
        if (!file_exists(app_path() . 'graphql')) {
            throw new \HttpException('当前目录不存在');
        }
        //Query下所有文件
        $fileNameList = scandir(app_path() . $folder);

        foreach ($fileNameList as $value) {
            if (strpos($value, '.php')) {
                var_dump(lcfirst(basename($value, '.php')));
            }
        }
    }
}
