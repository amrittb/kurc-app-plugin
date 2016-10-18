<?php

$router->get('posts','PostsController@index',[
    'after',
    'page' => [
        'default' => 1,
        'sanitize_callback' => 'absint'
    ],
    'per_page' => [
        'default' => 20,
        'sanitize_callback' => 'absint'
    ],
    'order' => [
        'default' => 'desc',
        'validate_callback' => function($param, $request, $key) {
            return in_array($param,['asc','desc']);
        }
    ],
    'orderby' => [
        'default' => 'date',
        'validate_callback' => function($param, $request, $key) {
            return in_array($param,[
                'id',
                'date',
                'title',
            ]);
        }
    ],
    'category_slug',
]);

$router->get('categories','CategoriesController@index');