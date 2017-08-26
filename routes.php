<?php

$routes = [
    /*
     * 'route where {dum1} are arguments for controller => 'controller itself@its action'
     *
     * '/article/{dum1}/update/{dum2}' => 'Controller2@update',
     *
     * routes in this file is to write without languages components
     */

   /* '/index/edit/'=> 'Index@edit',
    '/index/update' => 'Index@update',
    '/article/{dum1}/show/{dum2}' => 'index@showArgs',
    '/many/edit' => 'many@edit',
    '/images/uploadManyItems' => 'images@uploadManyItems',
    '/many/update' => 'many@update',*/

    '/'=>'Index@index',
    '/category/{title}' => 'index@category',
    '/topic/store' => 'topic@store',
    '/topic/{topic}' => 'topic@showResponses',
    '/addResponse' => 'topic@addResponse',
    '/getCaptcha' => 'index@getCaptchaOutput',
    '/showParentComment' => 'topic@showParentComment',
    '/response/{response}' => 'topic@showOneResponse',

    '/searchResults' =>'search@find',
    '/category/create/new' => 'topic@createCategory',
    '/category/store' => 'topic@storeCategory',
    '/category/{id}/create/topic' => 'topic@create',


    '/signUp' => 'member@register',
    '/saveMember' => 'member@store',
    '/signIn' => 'member@signin',
    '/getMember' =>'member@getMember',
    '/signOut' => 'member@signOut',
    '/member/{member}/edit' => 'member@edit',
    '/updateMember' => 'member@update',

    '/admin' => 'admin@index',
    '/admin/login' =>'admin@login',
    '/admin/exit' =>'admin@logout',
    '/showCategoriesPopUp'=>'popup@categories',
    '/admin/category/create'=> 'admincategories@create',
    '/admin/category/store' => 'admincategories@store',
    '/admin/category/{category}/edit' => '',
    '/admin/category/{category}/delete' => '',


    '/index/getLanguageComponents' => 'index@getLanguageComponents',
    '/images/uploadAvatar' =>'images@uploadAvatar',
    '/images/deleteAvatar' =>'images@deleteAvatar',
    '/admin/categories' => 'admincategories@index'


];
