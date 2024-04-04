<?php

namespace thinkGql\support;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class Mutation extends ObjectType
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
                $fields = $this->fields();
                foreach ($fields as $name => $field) {
                    if (isset($field['resolve']) && is_string($field['resolve']) && class_exists($field['resolve'])) {
                        $resolved = new $field['resolve'];
                        $methodName = $name;
                        if (!empty($field['name']) && is_string($field['name'])) {
                            $methodName = $field['name'];
                        }
                        if (method_exists($resolved, $methodName)) {
                            $field['resolve'] = function ($value, $args, $context, $info) use ($resolved,$methodName) {
                                return $resolved->$methodName($value, $args, $context, $info);
                            };
                        }
                    }
                }
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