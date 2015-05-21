<?php namespace Devise\Support\Laravel;

use Laracasts\Integrated\Services\Laravel\Application as Laravel;

trait Application
{
	use Laravel;

	protected function createApplication()
	{
        $app = require __DIR__.'/../../../../tests/bootstrap/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        return $app;
	}
}