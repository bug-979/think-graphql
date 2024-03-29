<?php

namespace thinkGql\support;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class Fields extends ObjectType
{
    /**
     * 描述
     * @var string
     */
    public string $desc;

    public function __construct()
    {
        // 构建ObjectType
        $config = [
            'description' => $this->desc ?? null,
            'fields' => function () {
                return $this->fields();
            },
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                $methodName = 'resolve' . str_replace('_', '', $info->fieldName);
                if (method_exists($this, $methodName)) {
                    // 执行resolve
                    return $this->{$methodName}($value, $args, $context, $info);
                }
                if (array_key_exists($info->fieldName, $value)) {
                    // 返回上级参数
                    return $value[$info->fieldName] ?? null;
                }
            }
        ];
        parent::__construct($config);
    }

    public function fields()
    {
        return [];
    }
}
