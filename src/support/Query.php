<?php


namespace thinkGql\support;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class Query extends ObjectType
{
    /**
     * 描述
     * @var string
     */
    public string $desc;

    public function __construct()
    {
        $paging = [
            'page' => [
                'type' => Type::int(),
                'description' => '页码',
                'defaultValue' => 1
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => '限制',
                'defaultValue' => 10
            ]
        ];
        $config = [
            'description' => $this->desc ?? null,
            'fields' => function () use ($paging) {
                $fields = $this->fields();
                foreach ($fields as &$field) {
                    // 判断是否是分页类型
                    $pagingKey = substr($field['type']->name, -6);
                    if ($pagingKey === 'Paging') {
                        if (array_key_exists('args', $field) && is_array($field['args'])) {
                            $field['args'] = array_merge($field['args'], $paging);
                        } else {
                            $field['args'] = $paging;
                        }
                    }
                }
                return $fields;
            },
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
            },
            ''
        ];
        parent::__construct($config);
    }

    public function fields()
    {
        return [];
    }
}
