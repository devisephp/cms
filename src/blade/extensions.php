<?php

/**
 * register @snippet code
 */
Blade::extend(function($view, $complier)
{
	return App::make('Devise\Editor\Helpers\SnippetAdapter')->compile($view);
});

/**
 * register data-devise code
 */
Blade::extend(function($view, $compiler)
{
	// return App::make('Devise\Editor\Helpers\DeviseBindingAdapter')->compile($view);
	return App::make('Devise\Pages\Interrupter\DeviseBladeCompiler')->compile($view);
});


