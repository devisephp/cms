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
