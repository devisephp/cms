<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

// apparently we need to load Laravel in order for Sami.php
// to find classes like "Eloquent" ... which makes sense I guess
// since those don't really exist (they are aliases in Laravel)
require __DIR__.'/tests/bootstrap/bootstrap/autoload.php';
$app = require __DIR__.'/tests/bootstrap/bootstrap/app.php';

class Eloquent {}

$iterator = Finder::create()
	->files()
	->name('*.php')
	->in(__DIR__ . '/src/Devise');


return new Sami($iterator, array(
	'title'                => 'Devise',
	'build_dir'            => __DIR__. '/public/docs',
	'cache_dir'            => __DIR__. '/.sami',
	'default_opened_level' => 2,
));
