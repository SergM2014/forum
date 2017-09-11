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
    '/index/getLanguageComponents' => 'index@getLanguageComponents',
    '/images/uploadAvatar' =>'images@uploadAvatar',
    '/images/deleteAvatar' =>'images@deleteAvatar',
    '/admin/categories' => 'admincategories@index',
    
    
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
    '/admin/category/{category}/edit' => 'admincategories@edit',
    '/admin/category/{category}/update' => 'admincategories@update',
    '/admin/category/modalWindow/delete' => 'admincategories@modalWindowDelete',
    '/admin/category/{category}/delete' => 'admincategories@delete',

    '/admin/topics' => 'admintopics@index',
    '/showTopicsPopUp'=>'popup@topics',
    '/admin/topic/create'=> 'admintopics@create',
    '/admin/topic/store' => 'admintopics@store',
    '/admin/topic/{topic}/edit' => 'admintopics@edit',
    '/admin/topic/{topic}/update' => 'admintopics@update',
    '/admin/topic/modalWindow/delete' => 'admintopics@modalWindowDelete',
    '/admin/topic/{topic}/delete' => 'admintopics@delete',


    '/admin/responses' => 'adminresponses@index',
    '/showResponsesPopUp'=>'popup@responses',
    '/admin/response/create'=> 'adminresponses@create',
    '/admin/response/store' => 'adminresponses@store',
    '/admin/response/{response}/edit' => 'adminresponses@edit',
    '/admin/response/{response}/update' => 'adminresponses@update',
    '/admin/response/modalWindow/delete' => 'adminresponses@modalWindowDelete',
    '/admin/response/{response}/delete' => 'adminresponses@delete',


   


];
