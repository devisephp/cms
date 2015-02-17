<?php
return array(

   'isDeviseAdmin' => array(
        'isInGroup' => array(
            'Devise Administrator'
        ),
    ),

   'isAppAdmin' => array(
        'isInGroup' => array(
            'Application Administrator'
        ),
    ),

   'isEditor' => array(
        'isInGroup' => array(
            'Editor'
        ),
    ),

   'isNotDeviseAdmin' => array(
        'isNotInGroup' => array(
            'Devise Administrator'
        ),
    ),

   'isNotAppAdmin' => array(
        'isNotInGroup' => array(
            'Application Administrator'
        ),
    ),

   'isNotEditor' => array(
        'isNotInGroup' => array(
            'Editor'
        ),
    ),

   'canAccessAdmin' => array(
        'isLoggedIn' => array(),
        'redirect' => 'user-login',
        'redirect_type' => 'route',
        'redirect_message' => 'You are not currently logged in.',
    ),

   'canAccessLogin' => array(
        'isNotLoggedIn' => array(),
        'redirect' => 'dvs-dashboard',
        'redirect_type' => 'route',
        'redirect_message' => '',
    ),

   'showDeviseEditor' => array(
        'isLoggedIn' => array()
    ),

   'showAnnotationEditor' => array(
        'isNotInGroup' => array(
            'Editor'
        )
    )
);
