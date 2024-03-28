<?php


namespace thinkGql;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use think\facade\Cache;

class GraphQLObject
{
    /**
     * fields列表
     * @var array
     */
    protected static array $fieldsList = [];

    /**
     * 查询列表
     * @var array
     */
    protected static array $queryList = [];

    /**
     * 增删改列表
     * @var array
     */
    protected static array $mutationList = [];

    protected static $types = [];
    protected static array $paging = [];

    public function __construct()
    {
        if (empty(self::$types)) {
            self::$types = Cache::get('types');
        }
    }

    /**
     * 获取字段
     * @param string $obj
     * @return mixed
     */
    public function getFields(string $obj)
    {
        return $this->getObjectType('Fields',$obj);
    }

    /**
     * 获取查询集
     * @param string $obj
     * @return mixed
     */
    public function getQuery(string $obj)
    {
        return $this->getObjectType('Query',$obj);
    }

    /**
     * 获取Mutation
     * @param string $obj
     * @return mixed
     */
    public function getMutation(string $obj)
    {
        return $this->getObjectType('Mutation',$obj);
    }

    protected function getObjectType(string $type,string $obj)
    {
        if (array_key_exists($obj, self::$mutationList)) {
            return self::$mutationList[$obj];
        }
        $fieldType = self::$types[$type][$obj];
        return self::$mutationList[$obj] = new $fieldType();
    }

    /**
     * 分页
     * @param $type
     * @return ObjectType|mixed
     */
    public function paging($type)
    {
        if (!array_key_exists($type->name, self::$paging)) {
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
        }
        return self::$paging[$type->name];
    }
}
