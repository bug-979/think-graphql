<?php


namespace thinkGql;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use think\facade\Cache;

class GraphQLObject
{
    protected static $fieldsList = [];

    protected static $queryList = [];

    protected static $mutationList = [];

    protected static $types = [];
    protected static $paging = [];

    public function __construct()
    {
        if (empty(self::$types)) {
            self::$types = Cache::get('types');
        }
    }

    public function getFields(string $obj)
    {
        if (array_key_exists($obj, self::$fieldsList)) {
            return self::$fieldsList[$obj];
        }
        $fieldType = self::$types['Fields'][$obj];
        return self::$fieldsList[$obj] = new $fieldType();
    }

    public function getQuery(string $obj)
    {
        if (array_key_exists($obj, self::$queryList)) {
            return self::$queryList[$obj];
        }
        $fieldType = self::$types['Query'][$obj];
        return self::$queryList[$obj] = new $fieldType();
    }

    public function getMutation(string $obj)
    {
        if (array_key_exists($obj, self::$mutationList)) {
            return self::$mutationList[$obj];
        }
        $fieldType = self::$types['Mutation'][$obj];
        return self::$mutationList[$obj] = new $fieldType();
    }

    public function paging($type)
    {
        if (array_key_exists($type->name, self::$paging)) {
            return self::$paging[$type->name];
        } else {
            self::$paging[$type->name] = new ObjectType([
                'name' => $type->name . 'Paging',
                'description' => '分页',
                'fields' => [
                    'data' => [
                        'type' => Type::listOf($type),
                        'description' => '分页',
                    ],
                    'page' => [
                        'type' => Type::int(),
                        'description' => '页码'
                    ],
                    'limit' => [
                        'type' => Type::int(),
                        'description' => '限制'
                    ],
                    'total' => [
                        'type' => Type::int(),
                        'description' => '总数'
                    ],
                ],
            ]);
            return self::$paging[$type->name];
        }
    }
}
