<?php

/*
|--------------------------------------------------------------------------
| Delete form macro
|--------------------------------------------------------------------------
|
| This macro creates a form with only a submit button.
| We'll use it to generate forms that will post to a certain url with the DELETE method,
| following REST principles.
|
*/
Form::macro('delete', function($url, $button_label='Delete', $form_parameters = array(), $button_options=array()){

	if(empty($form_parameters)){
		$form_parameters = array(
			'method'=>'DELETE',
			'class' =>'delete-form',
			'url'   =>$url
		);
	}else{
		$form_parameters['url'] = $url;
		$form_parameters['method'] = 'DELETE';
	};

	return Form::open($form_parameters)
	       . Form::submit($button_label, $button_options)
	       . Form::close();
});


HTML::macro('httpVerb', function($verb, $english = true) {
	if ($english) {
		switch($verb) {
			case 'post':
				return 'Create New';
				break;
			case 'put':
			case 'patch':
				return 'Update';
				break;
			case 'delete':
				return 'Delete';
				break;
			case 'any':
				return 'Any';
				break;
			case 'get':
			default:
				return 'Page';
				break;
		}
	} else {
		switch($verb) {
			case 'post':
				return 'POST (Create)';
				break;
			case 'put':
			case 'patch':
				return 'PUT (Update)';
				break;
			case 'delete':
				return 'DELETE (Delete)';
				break;
			case 'any':
				return 'ANY';
				break;
			case 'get':
			default:
				return 'GET (View)';
				break;
		}
	}
});

HTML::macro('filterLinkParts', function($slug)
{
	$parts = explode('/', $slug);

	if (!$parts) return $slug;

	if ($parts[0] === '') $empty = array_shift($parts);

	$link = '';
	$html = "<a data-change-target=\".filter-by-slug\" class=\"dvs-link-part\" data-value=\"\" href=\"#\">/</a>";

	foreach ($parts as $part)
	{
		$link .= $link ? '/' . $part : $part;
		$html .= "<a data-change-target=\".filter-by-slug\" class=\"dvs-link-part\" data-value=\"/{$link}\" href=\"#\">{$part}</a>";
	}

	return $html;
});


HTML::macro('showLanguagesForPages', function($languages, $showLinkAsIcon =  false)
{
    $html = '';

    foreach ($languages as $language)
    {
        if (!$showLinkAsIcon)
        {
            $html .= $html ? ', ' : $html;
            $html .= "<a href=\"{$language['url']}\">{$language['human_name']}</a>";
        } else {
            $html .= "<a class=\"dvs-lang-flag\" href=\"{$language['url']}\" title=\"{$language['human_name']}\"><img src=\"/packages/devisephp/cms/img/icons/flags/{$language['code']}.png\"></a>";
        }
    }

    return $html;
});

HTML::macro('getHtmlForJsVar', function($path, $data = array())
{
	return str_replace(
				PHP_EOL,
				'',
				\View::make(
					$path,
					$data
				)->render()
			);
});

/*
|--------------------------------------------------------------------------
| Displays text which indicates a page has atleast one field with
| the value of "content_requested" equal to true
|--------------------------------------------------------------------------
|
*/
HTML::macro('showPagesWithRequestedContent', function($page)
{
    if( $page->getLiveVersion() ) {
        $pageLiveVersion = $page->getLiveVersion()->load('fields', 'collectionFields');

        $fieldsArr = array_merge(
            $page->getLiveVersion()->fields->toArray(),
            $page->getLiveVersion()->collectionFields->toArray()
        );

        foreach($fieldsArr as $field) {
            if(isset($field['content_requested']) && $field['content_requested'] == '1') {
                return '<div class="dvs-badge dvs-content-requested fg red">
                			Needs Content
                			<button class="dvs-button-tiny dvs-button-primary dvs-pr dvs-content-requested-mark-done" data-url="'. URL::route('dvs-fields-content-requested-mark-all-complete', $page->id) .'">
                				<span class="ion-android-close"></span>
                			</button>
                		</div>';
            }
        }
    }

    return '';
});

/*
|--------------------------------------------------------------------------
| Is active link
|--------------------------------------------------------------------------
|
| This macro checks if the current request url is equal to the supplied segment.
| If it is, the default active class ".dvs-active" is applied. Also, boolean can be
| passed as second param to check singular of segment.
|
*/
if (!function_exists('isActiveLink'))
{
	function isActiveLink($segment, $checkSingular = false, $active = 'dvs-active')
	{
	    if($checkSingular == false) {
	        return (Request::is($segment)) ? $active : '';
	    }

	    return (Request::is($segment) || Request::is(Str::singular($segment))) ? $active : '';
	}
}

/*
|--------------------------------------------------------------------------
| Devise model
|--------------------------------------------------------------------------
|
| This adds a model to devise at run time on the page when the
| view is rendered. It will use the model's key() and get_class()
| information.
|
*/
if (!function_exists('devise_tag_cid'))
{
    function devise_tag_cid($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults)
    {
    	return App::make('dvsPageData')->cid($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults);
    }
}

/*
|--------------------------------------------------------------------------
| Gets proper url/link in the order precedence, 1) route or 2) url
|--------------------------------------------------------------------------
|
*/
if (!function_exists('getLinkRouteOrUrl'))
{
    function getLinkRouteOrUrl($linkValue, $default = '/#')
    {
        $link = ($linkValue->url != '') ? $linkValue->url : $default;

        if($linkValue->route != '') {
            $link = URL::route($linkValue->route);
        }

        return $link;
    }
}

/*
|--------------------------------------------------------------------------
| Gets proper url/link in the order precedence, 1) route or 2) url
|--------------------------------------------------------------------------
|
*/
if (!function_exists('deviseDocs'))
{
	function deviseDocs($viewName)
	{
		return App::make('Devise\Pages\Docs\Creator')->deviseDocs($viewName);
	}
}

/*
*/
if (!function_exists('deviseLiveCode'))
{
    function deviseLiveCode($target, $default)
    {
        echo '<span data-dvs-docs-target="' . $target .'" data-dvs-docs-default="' . $default .'"></span>';
    }
}

if (!function_exists('deviseDocsLink'))
{
	function deviseDocsLink($section = null, $helptext = null)
	{
		$section = ($section !== null) ? ' data-dvs-document="'. $section . '"' : null;
		$helptext = ($helptext !== null) ? '<span>'. $helptext . '</span>' : null;

		echo '<button class="dvs-document"'.$section.'>'.$helptext.'</button>';
	}
}


if (!function_exists('startdvsmagic'))
{
	function startdvsmagic()
	{
		Request::query('start-editor') === 'false' && App::make('dvsMagicMode')->enable();
		return null;
	}
}

if (!function_exists('dvsmagic'))
{
	function dvsmagic($object)
	{
		if ($object instanceof Devise\Pages\Fields\LiveFieldValue)
		{
			return $object->render();
		}

		return $object;
	}
}

if (!function_exists('enddvsmagic'))
{
	function enddvsmagic()
	{
		App::make('dvsMagicMode')->disable();
		return null;
	}
}
