<?php namespace Devise\Pages\Docs;

use Mockery as m;

class LiveSpanTest extends \DeviseTestCase
{
	public function test_it_can_replace_live_span()
	{
		$original = '@if(DeviseUser::checkRule(\'@livespan(#target-form-id,default value)\')) @endif <h3>\\@livespan(selector, value)</h3> @livespan(selector) @livespan() @livespan[selector, durka]';
		$LiveSpan = new LiveSpan(new \Devise\Support\Str);
		$replaced = $LiveSpan->replace($original);
		assertEquals('@if(DeviseUser::checkRule(\'<span data-livespan="#target-form-id">default value</span>\')) @endif <h3>@livespan(selector, value)</h3> <span data-livespan="selector"></span> <span data-livespan=""></span> <span data-livespan="selector">durka</span>', $replaced);
	}
}