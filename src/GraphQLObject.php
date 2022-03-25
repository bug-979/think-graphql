<?php


namespace thinkGql;

use think\facade\Cache;

class GraphQLObject
{
    protected static $fieldsList = [];

    protected static $queryList = [];

    protected static $mutationList = [];

    protected static $types = [];

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

    public function paging($obj)
    {
    }
}
