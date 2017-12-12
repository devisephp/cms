<?php return array (
		'devise::installer.welcome' => array(
      		'human_name' => 'Devise: Welcome Page',
    	),
    	'devise::installer.index-post-install' => array(
      		'human_name' => 'Devise: You Have Arrived',
    	),
		'devise::admin.layouts.master' => array(
			'human_name' => 'Devise Admin Master Layout',
			'extends' => '',
			'vars' => array(
				'dvsAdminMenu' => array('Devise\Menus\MenusRepository.buildMenu' => array('Admin Menu')),
			),
		),
		'devise::admin.pages.copy' => array(
			'human_name' => 'Devise Page Copy',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'page' => array(
					'Devise\Pages\PagesRepository.find' => array(
						'id' => '{params.pageId}',
					),
				),
				'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
				'templateList' => array(
					'Devise\Templates\TemplatesRepository.registeredTemplatesList' => array(
						false,
					),
				),
				'viewList' => 'Devise\Templates\TemplatesRepository.registeredTemplatesList',
				'versionsList' => array(
					'Devise\Pages\PageVersionsRepository.getVersionsListForPage' => array(
						'{page}',
					),
				),
				'liveVersion' => array(
					'Devise\Pages\PagesRepository.getLivePageVersion' => array(
						'{page}',
					),
				),
				'availableLanguages' => array(
	                'Devise\Pages\PagesRepository.getUnUsedLanguageList' => array(
	                    '{params.pageId}',
	                    '{languages}'
	                )
	            ),
			),
		),
		'devise::admin.dashboard.index' => array(
			'human_name' => 'Devise Admin Dashboard',
			'extends' => 'devise::admin.layouts.master',
		),
		'devise::admin.pages.index' => array(
			'human_name' => 'Devise Pages List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
				'pages' => 'Devise\Pages\PagesRepository.pages',
				'templateList' => array(
					'Devise\Templates\TemplatesRepository.registeredTemplatesList' => array(
						true,
					),
				),
			),
		),
		'devise::admin.pages.create' => array(
			'human_name' => 'Devise Pages List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'templateList' => array(
					'Devise\Templates\TemplatesRepository.registeredTemplatesList' => array(
						true,
					),
				),
				'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
			),
		),
		'devise::admin.pages.edit' => array(
			'human_name' => 'Devise Page Edit',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'page' => array(
					'Devise\Pages\PagesRepository.find' => array(
						'id' => '{params.pageId}',
					),
				),
				'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
				'templateList' => array(
					'Devise\Templates\TemplatesRepository.registeredTemplatesList' => array(
						true,
					),
				),
			),
		),
		'devise::admin.api.index' => array(
			'human_name' => 'Devise API Request List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'pages' => 'Devise\Pages\ApiPagesRepository.pages',
			),
		),
		'devise::admin.api.edit' => array(
			'human_name' => 'Devise API Request Edit',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'page' => array(
					'Devise\Pages\ApiPagesRepository.find' => array(
						'id' => '{params.pageId}',
					),
				),
			),
		),
		'devise::admin.content.queue' => array(
			'human_name' => 'Devise Content Queue',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'fields' => 'Devise\Pages\Fields\FieldsRepository.queue',
			),
		),
		'devise::admin.users.index' => array(
			'human_name' => 'Devise: Users List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'users' => 'Devise\Users\UsersRepository.users',
			),
		),
		'devise::admin.users.create' => array(
			'human_name' => 'Devise User Create',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'users' => 'Devise\Users\UsersRepository.users',
				'groups' => 'Devise\Users\Groups\GroupsRepository.groupList',
			),
		),
		'devise::admin.users.edit' => array(
			'human_name' => 'Devise User Edit',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'user' => array(
					'Devise\Users\UsersRepository.findById' => array(
						'{params.userId}',
					),
				),
				'groups' => 'Devise\Users\Groups\GroupsRepository.groupList',
				'usersGroups' => array(
					'Devise\Users\Groups\GroupsRepository.groupListForUser' => array(
						'{params.userId}',
					),
				),
			),
		),
		'devise::admin.groups.index' => array(
			'human_name' => 'Devise Groups List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'groups' => 'Devise\Users\Groups\GroupsRepository.groups',
			),
		),
		'devise::admin.groups.create' => array(
			'human_name' => 'Devise Group Create',
			'extends' => 'devise::admin.layouts.master',
		),
		'devise::admin.groups.edit' => array(
			'human_name' => 'Devise Group Edit',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'group' => array(
					'Devise\Users\Groups\GroupsRepository.findById' => array(
						'{params.groupId}',
					),
				),
			),
		),
		'devise::admin.languages.index' => array(
			'human_name' => 'Devise Languages List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'languages' => 'Devise\Languages\LanguagesRepository.languages',
			),
		),
		'devise::admin.menus.index' => array(
			'human_name' => 'Devise Menus List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
				'menus' => 'Devise\Menus\MenusRepository.menus',
			),
		),
		'devise::admin.menus.edit' => array(
			'human_name' => 'Devise Menu Edit',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'availablePermissions' => 'Devise\Users\Permissions\PermissionsRepository.availablePermissions',
				'menu' => array(
					'Devise\Menus\MenusRepository.findById' => array(
						'{params.menuId}',
					),
				),
			),
		),
		'devise::admin.media.manager' => array(
			'human_name' => 'Devise Media Manager',
			'extends' => 'devise::admin.layouts.media-manager',
		),
		'devise::admin.pages.page-versions._card' => array(
			'human_name' => 'Devise Page Version Card',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'page' => array(
					'Devise\Pages\PagesRepository.find' => array(
						'{params.pageId}',
						'{input}',
					),
				),
				'templateList' => array(
					'Devise\Templates\TemplatesRepository.registeredTemplatesList' => array(
						true,
					),
				),
			),
		),
		'devise::admin.calendar.index' => array(
			'human_name' => 'Devise Calendar',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'unscheduledPageVersions' => 'Devise\Pages\PageVersionsRepository.getUnscheduledPageVersions',
				'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
			),
		),
		'devise::admin.templates.index' => array(
			'human_name' => 'Devise Templates List',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'templates' => 'Devise\Templates\TemplatesRepository.allTemplatesPaginated',
			),
		),
		'devise::admin.templates.edit' => array(
			'human_name' => 'Devise Admin Template Edit',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'template' => array(
					'Devise\Templates\TemplatesRepository.getTemplateByPath' => array(
						'{params.templatePath}',
					),
				),
			),
		),
		'devise::admin.templates.register' => array(
			'human_name' => 'Devise Admin Register New Template',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'unregisteredTemplatesList' => 'Devise\Templates\TemplatesRepository.unregisteredTemplatesList',
			),
		),
		'devise::admin.templates.variables.create' => array(
			'human_name' => 'Devise Admin New Variable Form',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
				'usedVariables' => 'Devise\Templates\TemplatesRepository.compileAllUsedVars',
                'template' => array(
                    'Devise\Templates\TemplatesRepository.getTemplateByPath' => array(
                        '{params.templatePath}',
                    ),
                ),
			),
		),
        'devise::admin.permissions.index' => array(
            'human_name' => 'Devise Permissions List',
            'extends' => 'devise::admin.layouts.master',
            'vars' => array(
                'permissions' => 'Devise\Users\Permissions\PermissionsRepository.allPermissionsPaginated',
            ),
        ),
        'devise::admin.permissions.create' => array(
            'human_name' => 'Devise Permissions Edit',
            'extends' => 'devise::admin.layouts.master',
            'vars' => array(
                'availableRulesList' => 'Devise\Users\Permissions\PermissionsRepository.availableRulesList',
                'ruleParamMap' => array(
                    'Devise\Users\Permissions\PermissionsRepository.getRuleParamMap' => array(
                        '{availableRulesList}'
                    )
                ),
            ),
        ),
        'devise::admin.permissions.edit' => array(
            'human_name' => 'Devise Permissions Edit',
            'extends' => 'devise::admin.layouts.master',
            'vars' => array(
                'permission' => array(
                    'Devise\Users\Permissions\PermissionsRepository.getPermissionByPath' => ['{input.condition}']
                ),
                'availableRulesList' => 'Devise\Users\Permissions\PermissionsRepository.availableRulesList',
                'ruleParamMap' => array(
                    'Devise\Users\Permissions\PermissionsRepository.getRuleParamMap' => array(
                        '{availableRulesList}'
                    )
                ),
            ),
        ),
        'devise::admin.fields.index' => array(
			'human_name' => 'Devise Admin Fields Documentation',
			'extends' => null,
			'vars' => array(
				'dvsAdminMenu' => array('Devise\Menus\MenusRepository.buildMenu' => array('Admin Menu')),
			)
		),
		'devise::admin.settings.index' => array(
            'human_name' => 'Devise Settings List',
            'extends' => 'devise::admin.layouts.master',
            'vars' => array(
            ),
        ),
        'devise::admin.models.create' => array(
			'human_name' => 'Devise Admin Model Creator',
			'extends' => 'devise::admin.layouts.master',
			'vars' => array(
                'fieldTypesList' => 'Devise\Models\Scaffolding\ScaffoldingRepository.getModelFieldTypesList',
                'formTypesList' => 'Devise\Models\Scaffolding\ScaffoldingRepository.getModelFormTypesList',
			),
		),
	);
