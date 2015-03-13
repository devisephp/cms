<?php
return array(
   'isDeveloper' => array(
        'isInGroup' => array(
            'Developer'
        ),
        'redirect' => 'dvs-dashboard',
        'redirect_type' => 'route',
        'redirect_message' => '',
    ),

   'isAdministrator' => array(
        'isInGroup' => array(
            'Administrator'
        ),
        'redirect' => 'dvs-dashboard',
        'redirect_type' => 'route',
        'redirect_message' => '',
    ),

   'ifNotLoggedInGoToLogin' => array(
        'isLoggedIn' => array(),
        'redirect' => 'dvs-user-login',
        'redirect_type' => 'route',
        'redirect_message' => 'Please log in.',
    ),

   'ifLoggedInGoToDash' => array(
        'isNotLoggedIn' => array(),
        'redirect' => 'dvs-dashboard',
        'redirect_type' => 'route',
        'redirect_message' => '',
    ),

   'canUseDeviseEditor' => array(
        'isLoggedIn' => array()
    ),
);
