<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | type-order
    |--------------------------------------------------------------------------
    |
    | An array of the different types of devise items. Each item's index
    | correlates to it's order when being compiled.
    */
    'type-order' => array('variable','layout','section','template','include','form','input','field','route','data'),

    /*
    |--------------------------------------------------------------------------
    | field-types
    |--------------------------------------------------------------------------
    |
    | All types in array will be saved as a 'page field'
    |
    */
    'field-types' => array('color','date','image','link','select','textarea','string','video','editor'),

    /*
    |--------------------------------------------------------------------------
    | compilers
    |--------------------------------------------------------------------------
    |
    | A map of types to their compilers
    |
    */
    'compilers' => array(
        'data' => 'Devise\Pages\Compilers\Types\DataCompiler',
        'field' => 'Devise\Pages\Compilers\Types\FieldCompiler',
        'input' => 'Devise\Pages\Compilers\Types\InputCompiler',
        'form' => 'Devise\Pages\Compilers\Types\FormCompiler',
        'include' => 'Devise\Pages\Compilers\Types\IncludeCompiler',
        'layout' => 'Devise\Pages\Compilers\Types\LayoutCompiler',
        'route' => 'Devise\Pages\Compilers\Types\RouteCompiler',
        'section' => 'Devise\Pages\Compilers\Types\SectionCompiler'
    )
);