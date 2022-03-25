<?php

namespace thinkGql\facade;

use think\Facade;

/**
 * Class GraphQLObject
 * @see thinkGql\GraphQLObject
 * @package thinkGql\facade
 * @mixin thinkGql\GraphQLObject
 * @method static mixed getFields(string $obj)
 * @method static mixed getQuery(string $obj)
 * @method static mixed getMutation(string $obj)
 * @method static mixed paging(mixed $obj)
 */
class GraphQLObject extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thinkGql\GraphQLObject';
    }
}
