<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
    ];

    public function type()
    {
        return GraphQL::type('User'); 
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            $user = \App\User::findOrFail($args['id']);
            $user->count_followings = $user->followingUsers()->count();;
            return $user;
        }

        $user = getUser();

        return $user;
    }
}
