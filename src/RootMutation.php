<?php

namespace thinkGql;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use thinkGql\facade\GraphQLObject;
use thinkGql\utils\Utils;

class RootMutation extends ObjectType
{
    public function __construct()
    {
        $fields = [];
        $objectNames = Utils::getObjectNames('Mutation');
        if (!empty($objectNames)) {
            foreach ($objectNames as $val) {
                GraphQLObject::getMutation($val)->name .= 'Mutation';
                $fields[$val] = [
                    'name' => $val,
                    'type' => GraphQLObject::getMutation($val),
                    'description' => GraphQLObject::getMutation($val)->description,
                ];
            }
        }


        $config = [
            'name' => 'Mutation',
            'fields' => $fields,
            'description' => '更改',
            'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info) {
                return [];
            }
        ];
        parent::__construct($config);
    }
}
