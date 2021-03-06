<?php

//消息
Route::middleware('auth:api')->get('notification/chats', 'Api\NotificationController@chats');
Route::middleware('auth:api')->get('notification/chat/{id}', 'Api\NotificationController@chat');
Route::middleware('auth:api')->post('notification/chat/{id}/send', 'Api\NotificationController@sendMessage');
Route::middleware('auth:api')->get('notifications/{type}', 'Api\NotificationController@notifications');
//未读消息
Route::middleware('auth:api')->get('/unreads', 'Api\UserController@unreads');