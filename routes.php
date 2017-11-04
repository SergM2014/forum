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


    '/admin/categories' => 'AdminCategories@index',
    '/admin/category/create'=> 'AdminCategories@create',
    '/admin/category/store' => 'AdminCategories@store',
    '/admin/category/{category}/edit' => 'AdminCategories@edit',
    '/admin/category/{category}/update' => 'AdminCategories@update',
    '/admin/category/modalWindow/delete' => 'AdminCategories@modalWindowDelete',
    '/admin/category/{category}/delete' => 'AdminCategories@delete',

    '/admin/topics' => 'AdminTopics@index',
    '/showTopicsPopUp'=>'popup@topics',
    '/admin/topic/create'=> 'AdminTopics@create',
    '/admin/topic/store' => 'AdminTopics@store',
    '/admin/topic/{topic}/edit' => 'AdminTopics@edit',
    '/admin/topic/{topic}/update' => 'AdminTopics@update',
    '/admin/topic/modalWindow/delete' => 'AdminTopics@modalWindowDelete',
    '/admin/topic/{topic}/delete' => 'AdminTopics@delete',


    '/admin/responses' => 'AdminResponses@index',
    '/showResponsesPopUp'=>'popup@responses',
    '/admin/response/create'=> 'AdminResponses@create',
    '/admin/response/showTreeStructure' => 'AdminResponses@showTreeStructure',
    '/admin/response/store' => 'AdminResponses@store',
    '/admin/response/{response}/edit' => 'AdminResponses@edit',
    '/admin/response/{response}/update' => 'AdminResponses@update',
    '/admin/response/modalWindow/delete' => 'AdminResponses@modalWindowDelete',
    '/admin/response/{response}/delete' => 'AdminResponses@delete',
    '/admin/response/{response}/publish' => 'AdminResponses@publish',
    '/admin/response/{response}/unpublish' => 'AdminResponses@unpublish',




    '/admin/members' => 'AdminMembers@index',


    '/showMembersPopUp' => 'Popup@members',
    '/admin/members/create' => 'AdminMembers@create',
    '/admin/members/store'  => 'AdminMembers@store',
    '/admin/members/{member}/edit'  => 'AdminMembers@edit',
    '/admin/members/{member}/update'  => 'AdminMembers@update',
    '/admin/members/modalWindow/delete' => 'AdminMembers@modalWindowDelete',
    '/admin/members/{member}/delete' => 'AdminMembers@delete',

    '/admin/users' => 'AdminUsers@index',
    '/showUsersPopUp' => 'Popup@users',
    '/admin/users/create' => 'AdminUsers@create',
    '/admin/users/store' => 'AdminUsers@store',
    '/admin/users/{user}/edit' => 'AdminUsers@edit',
    '/admin/users/{user}/update' => 'AdminUsers@update',
    '/admin/users/modalWindow/delete' => 'AdminUsers@modalWindowDelete',
    '/admin/users/{user}/delete' => 'AdminUsers@delete',
];
