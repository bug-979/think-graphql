<?php


namespace thinkGql;

use app\graphql\Type\User;
use GraphQL\GraphQL;
use GraphQL\Language\AST\DocumentNode;
use GraphQL\Server\OperationParams;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Validator\Rules\CustomValidationRule;
use GraphQL\Error\DebugFlag;

class GraphQLController
{
    /**
     * 执行查询
     */
    public function query()
    {
        $schema = new Schema([
            'query' => new RootQuery(),
//            'mutation' => new RootMutation()
        ]);
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = $input['variables'] ?? null;
        $rootValue = ['prefix' => 'You said: '];

        $result = GraphQL::executeQuery(
            $schema,
            $query,
            $rootValue,
            $context = '上下文',
            $variableValues
        );
        $output = $result->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE);
        return json($output);
    }
}
