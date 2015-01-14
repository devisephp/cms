<?php
return array (
    'devise::admin.dashboard.index' => array(

    ),
    'devise::admin.pages.index' => array(
        'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
        'pages'       => 'Devise\Pages\PagesRepository.pages'
    ),
    'devise::admin.pages.create' => array(
        'viewList' => 'Devise\Pages\PagesRepository.availableViewsList',
        'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
    ),
    'devise::admin.pages.edit' => array(
        'page' => ['Devise\Pages\PagesRepository.find' => ['id' => 'params.pageId']],
        'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
        'viewList' => 'Devise\Pages\PagesRepository.availableViewsList',
    ),
    'devise::admin.pages.copy' => array(
        'page' => ['Devise\Pages\PagesRepository.find' => ['id' => 'params.pageId']],
        'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
        'viewList' => 'Devise\Pages\PagesRepository.availableViewsList',
    ),
    'devise::admin.content.queue' => array(
        'fields'       => 'Devise\Pages\Fields\FieldsRepository.queue'
    ),
    'devise::admin.users.index' => array(
        'users' => 'Devise\Users\UsersRepository.users',
    ),
    'devise::admin.users.create' => array(
        'groups' => 'Devise\Users\Groups\GroupsRepository.groupList',
    ),
    'devise::admin.users.edit' => array(
        'user' => ['Devise\Users\UsersRepository.findById' => ['params.userId']],
        'groups' => 'Devise\Users\Groups\GroupsRepository.groupList',
        'usersGroups' => ['Devise\Users\Groups\GroupsRepository.groupListForUser' => ['params.userId']],
    ),
    'devise::admin.groups.index' => array(
        'groups' => 'Devise\Users\Groups\GroupsRepository.groups',
    ),
    'devise::admin.groups.create' => array(

    ),
    'devise::admin.groups.edit' => array(
        'group' => ['Devise\Users\Groups\GroupsRepository.findById' => ['params.groupId']],
    ),
    'devise::admin.languages.index' => array(
        'languages' => 'Devise\Languages\LanguagesRepository.languages',
    ),
    'devise::admin.menus.index' => array(
        'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
        'menus' => 'Devise\Menus\MenusRepository.menus',
    ),
    'devise::admin.menus.edit' => array(
        'menu' => ['Devise\Menus\MenusRepository.findById' => ['params.menuId']],
    ),
    'devise::admin.media.manager' => array(
        'pageData' => ['Devise\Media\Files\Repository.compileIndexData' => ['input']],
        'finalImages' => ['Devise\Media\Images\Manager.extractImagesForCallback' => ['input']]
    ),
    'devise::admin.media.crop' => array(
        'imageUrl' => ['Devise\Media\Images\Manager.getImageUrl' => ['input']]
    ),
    'devise::admin.pages.page-versions._card' => array(
        'page'  => ['Devise\Pages\PagesRepository.find' => ['params.pageId']],
    ),
    'devise::admin.calendar.index' => array(
        'unscheduledPageVersions' => 'Devise\Pages\PageVersionsRepository.getUnscheduledPageVersions',
        'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
    ),
);