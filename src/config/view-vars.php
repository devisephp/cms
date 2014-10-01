<?php
return array (
	'devise::admin.pages.index' => array(
		'pages'       => 'Devise\Pages\Repositories\PagesRepository.pages',
        'languages' => 'Devise\Languages\Repositories\LanguagesRepository.activeLanguageList',
    ),
    'devise::admin.pages.create' => array(
        'viewList' => 'Devise\Pages\Repositories\TemplatesRepository.availableViewsList',
        'languages' => 'Devise\Languages\Repositories\LanguagesRepository.activeLanguageList',
    ),
    'devise::admin.pages.edit' => array(
        'page' => ['Devise\Pages\Repositories\PagesRepository.find' => ['id' => 'params.pageId']],
        'languages' => 'Devise\Languages\Repositories\LanguagesRepository.activeLanguageList',
        'viewList' => 'Devise\Pages\Repositories\TemplatesRepository.availableViewsList',
    ),
    'devise::admin.pages.copy' => array(
	    'page' => ['Devise\Pages\Repositories\PagesRepository.find' => ['id' => 'params.pageId']],
        'languages' => 'Devise\Languages\Repositories\LanguagesRepository.activeLanguageList',
	    'viewList' => 'Devise\Pages\Repositories\TemplatesRepository.availableViewsList',
    ),
    'devise::admin.content.queue' => array(
	    'fields'       => 'Devise\Fields\Repositories\FieldsRepository.queue'
    ),
    'devise::admin.users.index' => array(
        'users' => 'Devise\User\Repositories\UsersRepository.users',
    ),
    'devise::admin.users.create' => array(
        'groups' => 'Devise\User\Repositories\GroupsRepository.groupList',
    ),
    'devise::admin.users.edit' => array(
        'user' => ['Devise\User\Repositories\UsersRepository.findById' => ['params.userId']],
        'groups' => 'Devise\User\Repositories\GroupsRepository.groupList',
        'usersGroups' => ['Devise\User\Repositories\GroupsRepository.groupListForUser' => ['params.userId']],
    ),
    'devise::admin.groups.index' => array(
        'groups' => 'Devise\User\Repositories\GroupsRepository.groups',
    ),
    'devise::admin.groups.create' => array(

    ),
    'devise::admin.groups.edit' => array(
        'group' => ['Devise\User\Repositories\GroupsRepository.findById' => ['params.groupId']],
    ),
    'devise::admin.languages.index' => array(
        'languages' => 'Devise\Languages\Repositories\LanguagesRepository.languages',
    ),
    'devise::admin.menus.index' => array(
        'menus' => 'Devise\Menus\Repositories\MenusRepository.menus',
    ),
    'devise::admin.menus.edit' => array(
        'menu' => ['Devise\Menus\Repositories\MenusRepository.findById' => ['params.menuId']],
    ),
    'devise::admin.media.manager' => array(
        'config' => 'Devise\MediaManager\Files\Repository.getConfig',
        'validatorResults' => ['Devise\MediaManager\Files\Validator.checkCapabilities' => ['config']],
        'pageData' => ['Devise\MediaManager\Files\Repository.compileIndexData' => ['validatorResults', 'input']],
        'finalImages' => ['Devise\MediaManager\Images\Manager.extractImagesForCallback' => ['input']]
    ),
    'devise::admin.media.crop' => array(
        'imageUrl' => ['Devise\MediaManager\Helpers\CropData.getImageUrl' => ['input']]
    ),
);