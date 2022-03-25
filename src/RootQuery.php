<?php

namespace thinkGql;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use think\facade\Cache;
use think\facade\Config;
use thinkGql\support\Fields;
use thinkGql\utils\Utils;
use thinkGql\facade\GraphQLObject;

class RootQuery extends ObjectType
{
    public function __construct()
    {
        $objectNames = Utils::getObjectNames('Query');
        $fields = [];
        foreach ($objectNames as $val) {
            GraphQLObject::getQuery($val)->name .= 'Query';
            $fields[$val] = [
                'name' => $val,
                'type' => GraphQLObject::getQuery($val),
                'description' => GraphQLObject::getQuery($val)->description,
            ];
        }
        $config = [
            'name' => 'Query',
            'fields' => $fields,
            'description' => '查询',
            'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info) {
                return [];
            }
        ];
        parent::__construct($config);
    }
}
