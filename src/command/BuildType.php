<?php


namespace thinkGql\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Cache;
use thinkGql\utils\Utils;

class BuildType extends Command
{
    protected function configure()
    {
        $this->setName('thinkGql:buildType')
            ->setDescription('构建ObjectType');
    }

    protected function execute(Input $input, Output $output)
    {
        $fieldsNames = Utils::getObjectNames('Type');
        $queryNames = Utils::getObjectNames('Query');
        $mutationNames = Utils::getObjectNames('Mutation');
        $configType = [];
        foreach ($fieldsNames as $val) {
            $configType['Fields'][$val] = 'app\graphql\Type\\' . $val;
        }
        foreach ($queryNames as $val) {
            $configType['Query'][$val] = 'app\graphql\Query\\' . $val;
        }
        foreach ($mutationNames as $val) {
            $configType['Mutation'][$val] = 'app\graphql\Mutation\\' . $val;
        }
        if (Cache::set('types', $configType)) {
            $output->writeln('构建成功');
        } else {
            $output->writeln('构建失败');
        }
    }
}
