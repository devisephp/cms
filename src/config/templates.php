<?php return array (
    'devise::admin.layouts.master' => array(
        'human_name' => 'Devise: Admin Master Layout',
    ),
    'devise::admin.dashboard.index' => array(
        'human_name' => 'Devise: Admin Dashboard',
        'extends' => 'devise::admin.layouts.master',
    ),
    'devise::admin.pages.index' => array(
        'human_name' => 'Devise: Admin Pages List',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
            'pages'       => 'Devise\Pages\PagesRepository.pages'
        ),
    ),
    'devise::admin.pages.create' => array(
        'human_name' => 'Devise: Admin Page Create',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'viewList' => 'Devise\Templates\TemplatesRepository.registeredTemplatesList',
            'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
        ),
    ),
    'devise::admin.pages.edit' => array(
        'human_name' => 'Devise: Admin Page Edit',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'page' => array(
                'Devise\Pages\PagesRepository.find' => array(
                    '{params.pageId}'
                )
            ),
            'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
            'viewList' => 'Devise\Templates\TemplatesRepository.registeredTemplatesList',
        ),
    ),
    'devise::admin.pages.copy' => array(
        'human_name' => 'Devise: Page Copy',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'page' => array(
                'Devise\Pages\PagesRepository.find' => array(
                    '{params.pageId}'
                )
            ),
            'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
            'availableLanguages' => array(
                'Devise\Pages\PagesRepository.getUnUsedLanguageList' => array(
                    '{params.pageId}',
                    '{languages}'
                )
            ),
            'viewList' => 'Devise\Templates\TemplatesRepository.registeredTemplatesList',
            'liveVersion' => array(
                'Devise\Pages\PagesRepository.getLivePageVersion' => array(
                    '{page}'
                )
            ),
            'versionsList' => array(
                'Devise\Pages\PageVersionsRepository.getVersionsListForPage' => array(
                    '{page}'
                )
            )
        )
    ),
    'devise::admin.pages.page-versions._card' => array(
        'human_name' => 'Devise: Version Cards',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'page'  => array(
                'Devise\Pages\PagesRepository.find' => array(
                    '{params.pageId}'
                )
            ),
        )
    ),
    'devise::admin.content.queue' => array(
        'human_name' => 'Devise: Page Content Queue',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'fields'       => 'Devise\Pages\Fields\FieldsRepository.queue'
        )
    ),
    'devise::admin.users.index' => array(
        'human_name' => 'Devise: Users List',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'users' => 'Devise\Users\UsersRepository.users',
        )
    ),
    'devise::admin.users.create' => array(
        'human_name' => 'Devise: User Create',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'groups' => 'Devise\Users\Groups\GroupsRepository.groupList',
        )
    ),
    'devise::admin.users.edit' => array(
        'human_name' => 'Devise: User Create',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'user' => array(
                'Devise\Users\UsersRepository.findById' => array(
                    '{params.userId}'
                )
            ),
            'groups' => 'Devise\Users\Groups\GroupsRepository.groupList',
            'usersGroups' => array(
                'Devise\Users\Groups\GroupsRepository.groupListForUser' => array(
                    '{params.userId}'
                )
            ),
        )
    ),
    'devise::admin.groups.index' => array(
        'human_name' => 'Devise: User Groups List',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'groups' => 'Devise\Users\Groups\GroupsRepository.groups',
        )
    ),
    'devise::admin.groups.create' => array(
        'human_name' => 'Devise: Create User Group',
        'extends' => 'devise::admin.layouts.master',
    ),
    'devise::admin.groups.edit' => array(
        'human_name' => 'Devise: Edit User Group',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'group' => array(
                'Devise\Users\Groups\GroupsRepository.findById' => array(
                    '{params.groupId}'
                )
            ),
        )
    ),
    'devise::admin.languages.index' => array(
        'human_name' => 'Devise: Languages List',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'languages' => 'Devise\Languages\LanguagesRepository.languages',
        )
    ),
    'devise::admin.menus.index' => array(
        'human_name' => 'Devise: Menus List',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
            'menus' => 'Devise\Menus\MenusRepository.menus',
        )
    ),
    'devise::admin.menus.edit' => array(
        'human_name' => 'Devise: Edit Menu',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'menu' => array(
                'Devise\Menus\MenusRepository.findById' => array(
                    '{params.menuId}'
                )
            ),
        )
    ),
    'devise::admin.media.manager' => array(
        'human_name' => 'Devise: Media Manager',
        'extends' => 'devise::admin.layouts.media-manager',
        'vars' => array(
            'pageData' => array(
                'Devise\Media\Files\Repository.compileIndexData' => array(
                    '{input}'
                )
            ),
            'finalImages' => array(
                'Devise\Media\Images\Manager.extractImagesForCallback' => array(
                    '{input}'
                )
            )
        )
    ),
    'devise::admin.media.crop' => array(
        'human_name' => 'Devise: Media Manager Cropper',
        'extends' => 'devise::admin.layouts.media-manager',
        'vars' => array(
            'imageUrl' => array(
                'Devise\Media\Images\Manager.getImageUrl' => array(
                    '{input}'
                )
            )
        )
    ),
    'devise::admin.calendar.index' => array(
        'human_name' => 'Devise: Calendar',
        'extends' => 'devise::admin.layouts.media-manager',
        'vars' => array(
            'unscheduledPageVersions' => 'Devise\Pages\PageVersionsRepository.getUnscheduledPageVersions',
            'languages' => 'Devise\Languages\LanguagesRepository.activeLanguageList',
        )
    ),
    'devise::admin.templates.index' => array(
        'human_name' => 'Devise: Templates List',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'templates' => 'Devise\Templates\TemplatesRepository.allTemplatesPaginated',
        ),
    ),
    'devise::admin.templates.edit' => array(
        'human_name' => 'Devise: Admin Template Edit',
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
        'human_name' => 'Devise: Admin Register New Template',
        'extends' => 'devise::admin.layouts.master',
        'vars' => array(
            'unregisteredTemplatesList' => 'Devise\Templates\TemplatesRepository.unregisteredTemplatesList',
        ),
    ),
);