<?php namespace Devise\Support\Console;

use Illuminate\Container\Container;
use DB, File;

class DeviseTestRoutesCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:test:routes';

    // php artisan devise:test:routes --http_verb="%" --route_name="%" --dvs_admin="0"


    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles creating tests for every devise route in this application';

    /**
     * Setup the application container as we'll need this for running migrations.
     *
     *
     * TODO: need to put OPTIONs parameters in here
     */
    public function __construct(Container $app)
    {
        parent::__construct();

        $this->app = $app;

        $this->testDir = $this->app->basepath() . '/tests/routes';

        $this->File = File::getFacadeRoot();
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $pages = $this->getPages();

        $this->writeTestsFor($pages);
    }

    private function getScaffoldView($data)
    {

    }

    private function getPages()
    {
        return DB::table('dvs_pages')
            ->where('dvs_admin', '=', 0)
            ->get();
    }

    private function writeTestsFor($pages)
    {
        foreach ($pages as $page)
        {
            $testFile = $this->testDir . '/' . $page->route_name . '.php';

            if ($this->File->exists($testFile)) continue;

            $data = $this->dataForPage($page);

            $viewpath = $data['viewpath'];

            $compiled = view($viewpath, $data)->render();

            $this->File->put($testFile, $compiled);
        }
    }

    private function dataForPage($page)
    {
        $data = [];

        $data['test_name'] = $this->testNameForPage($page);
        $data['test_method'] = 'test_route';
        $data['route_name'] = $page->route_name;
        $data['route_params'] = $this->routeParamsForPage($page);
        $data['route_method'] = strtoupper($page->http_verb);
        $data['route_url'] = $page->slug;
        $data['use_db_transactions_stmt'] = 'use DatabaseTransactions;';
        $data['use_fqn_db_transactions_stmt'] = 'use Illuminate\Foundation\Testing\DatabaseTransactions;';
        $data['page'] = $page;
        $data['viewpath'] = 'devise::scaffolding.tests.route_' . (strtoupper($page->http_verb) == 'GET' ? 'view' : 'function');
        $data['route_path'] = "'{$data['route_name']}'" . ($data['route_params'] ? ', ' . $data['route_params'] : '');

        return $data;
    }

    private function testNameForPage($page)
    {
        $name = $page->route_name;

        $name = str_replace(['-', ' '], '_', $name);

        $parts = explode('_', $name);

        foreach ($parts as $index => $part)
        {
            $parts[$index] = ucfirst($part);
        }

        $name = implode('_', $parts);

        return $name;
    }

    private function routeParamsForPage($page)
    {
        preg_match_all('/{(.*?)}/', $page->slug, $matches);

        if (!array_key_exists(1, $matches)) return '';

        $params = '[';

        foreach ($matches[1] as $match)
        {
            $params .= $params == '[' ? '' : ',';
            $params .= "'{$match}'";
        }

        $params .= ']';

        return $params == '[]' ? '' : $params;
    }

}