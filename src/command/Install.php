<?php

namespace thinkGql\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Console;
use think\facade\Env;

class Install extends Command
{
    protected function configure()
    {
        $this->setName('thinkGql:install')
            ->setDescription('安装初始化');
    }

    protected function execute(Input $input, Output $output)
    {
        // 初始化配置文件
        $this->initFile('graphql.php', config_path());

        // 初始化文件夹
        $this->initFile('graphql/Type', app_path(), false);
        $this->initFile('graphql/Query', app_path(), false);
        $this->initFile('graphql/Mutation', app_path(), false);
    }

    /**
     * 创建文件或文件夹
     *
     * @param $tplName
     * @param $path
     * @param bool $type true:文件 false:文件夹
     */
    private function initFile($tplName, $path, $type = true)
    {
        if ($type) {
            // 目录不存在创建目录
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            if (!file_exists($path . $tplName)) {
                $tpl = file_get_contents(__DIR__ . '/../tpl/template.' . $tplName);
                file_put_contents($path . $tplName, $tpl);
            }
        } else {
            if (is_dir(dirname($path . $tplName)) && !file_exists($path . $tplName)) {
                mkdir($path . $tplName, 0755, true);
            }
        }
    }
}
