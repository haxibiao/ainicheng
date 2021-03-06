<?php
namespace App\GraphQL\Enum;

use Folklore\GraphQL\Support\Type as GraphQLType;

class ArticleOrderEnum extends GraphQLType {
    protected $enumObject = true;

    protected $attributes = [
        'name' => 'ArticleOrder',
        'description' => 'The Orders of Article query',
        'values' => [
            'LATEST' => 'LATEST',
            'COMMENTED' => 'COMMENTED',
            'HOT' => 'HOT',

            'VIDEO'     => 'VIDEO',     //视频
            'ARTICLE'   => 'ARTICLE',   //普通文章
            'POST'      => 'POST'       //动态
        ],
    ];
}