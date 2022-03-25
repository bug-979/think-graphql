<?php


namespace thinkGql;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class Query extends ObjectType
{
    protected $attributes = [];

    public function __construct()
    {
        // 构建ObjectType
        $config = [
            'name' => $this->attributes['name'],
            'description' => $this->attributes['description'],
            'fields' => $this->fields(),
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                $methodName = 'resolve' . str_replace('_', '', $info->fieldName);
                if (array_key_exists($info->fieldName, $value)) {
                    // 返回上级参数
                    return $value[$info->fieldName] ?? null;
                }
                if (method_exists($this, $methodName)) {
                    // 执行resolve
                    return $this->{$methodName}($value, $args, $context, $info);
                }
            }
        ];
        parent::__construct($config);
    }
}
