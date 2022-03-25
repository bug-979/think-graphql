<?php


namespace thinkGql;


use think\Service;
use think\Route;
use thinkGql\command;

class GraphQLService extends Service
{
    public function register()
    {
        // 服务注册
        $this->bindRouter();
        $this->commands([
            command\Install::class,
            command\BuildType::class
        ]);
    }

    public function boot(Route $route)
    {
        // 服务启动
//        var_dump('我是GQL服务');
    }

    protected function bindRouter()
    {
        // 路由
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}
