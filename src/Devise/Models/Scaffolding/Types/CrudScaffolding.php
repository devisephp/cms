<?php namespace Devise\Models\Scaffolding\Types;

use Devise\Support\Framework;
use Devise\Templates\TemplatesManager;

/**
 * Class CrudScaffolding
 * @package Devise\Models\Scaffolding\Types
 */
class CrudScaffolding extends BaseScaffolding
{
	protected function extendConstansts() {
		$pages = array_merge($this->pages, $this->apis);

		$this->constants['seederPages'] = var_export($pages, true);
		$this->constants['scaffoldingType'] = 'crud';
	}

	/**
	 * Sets the view files for this scaffold type
	 *
	 * @return void;
     */
	protected function setViewFiles()
	{
		$scaffoldSrcBase = base_path() . '/vendor/devisephp/cms/src/scaffolding/crud/views/';

		$viewBase = base_path() . '/resources/views/admin/' . $this->constants['viewsDirectory'] . '/';

		$this->viewFiles = [
			$scaffoldSrcBase . 'admin/_form-fields.txt' 
				=> $viewBase . '_form-fields.blade.php',
			$scaffoldSrcBase . 'admin/create.txt' => [
				"file_name"  => "admin.".$this->constants['snakeCasePlural'] .".create",
				"human_name" => "Admin Create ".$this->constants['pluralCase'],
				"extends"    => "devise::admin.layouts.master",
				"view"       => $viewBase . 'create.blade.php',
			],
			$scaffoldSrcBase . 'admin/edit.txt' => [
				"file_name"  => "admin.".$this->constants['snakeCasePlural'] .".edit",
				"human_name" => "Admin Edit ".$this->constants['pluralCase'],
				"extends"    => "devise::admin.layouts.master",
				"view"       => $viewBase . 'edit.blade.php',
				"vars"       => [
						// 'littleWidget' => array(
						// 	'Columbia\LittleWidgets\LittleWidgetsRepository.getLittleWidget' => array(
						// 		'{params.little_widgetid}',
						// 	),
						// ),
						$this->constants['singularVar'] => [
							$this->constants['namespace'] . 
							'\\' . 
							$this->constants['className'] .
							'\\' . 
							$this->constants['className'] .
							'Repository.get' . 
							$this->constants['modelName'] => [
								'{params.'. $this->constants['snakeCase'] .'id}'
							]
						]
					]
			], 
			$scaffoldSrcBase . 'admin/index.txt'  => [
				"file_name"  => "admin.".$this->constants['snakeCasePlural'] .".index",
				"human_name" => "Admin " . $this->constants['pluralCase'] ." Index",
				"extends"    => "devise::admin.layouts.master",
				"view"       => $viewBase . 'index.blade.php',
				"vars"		 => [
					// 'littleWidgets' => 'Columbia\LittleWidgets\LittleWidgetsRepository.getAllLittleWidgets',
					$this->constants['pluralVar'] => 
						$this->constants['namespace'] . 
						'\\' . 
						$this->constants['className'] .
						'\\' . 
						$this->constants['className'] .
						'Repository.getAll' . 
						$this->constants['className']
					],
			],
		];
	}

	/**
	 * sets the scaffolding source files and targets for this scaffold type
	 *
	 * @return void;
     */
	protected function setSrcFiles()
	{
		$scaffoldSrcBase = base_path() . '/vendor/devisephp/cms/src/scaffolding/crud/src/';

		$srcBase = base_path() . '/app/' . $this->constants['srcDirectory'] . '/';

		$this->srcFiles = [
			$scaffoldSrcBase . 'Manager.txt' 
				=> $srcBase . $this->constants['className'].'Manager.php',
			$scaffoldSrcBase . 'Repository.txt' 
				=> $srcBase . $this->constants['className'].'Repository.php',
			$scaffoldSrcBase . 'ResponseHandler.txt' 
				=> $srcBase . $this->constants['className'].'ResponseHandler.php',
			$scaffoldSrcBase . 'models/Model.txt' 
				=> base_path() . '/app/' . $this->constants['modelName'].'.php',
		];
	}

	/**
	 * Sets the pages that need to be created for this scaffold to work in Devise
	 *
	 * @return void;
     */
	protected function setPages()
	{
		$this->pages = [
			[
				'language_id'    => 45,
				'view'           => 'admin.' . $this->constants['snakeCasePlural'] . '.index',
				'title'          => 'Admin ' . $this->constants['pluralCase'],
				'http_verb'      => 'get',
				'slug'           => '/admin/'. $this->constants['slug'],
				'response_type'  => 'View',
				'route_name'     => 'admin-' . $this->constants['slug'] . '-index',
				'before'         => 'ifNotLoggedInGoToLogin'
			],
			[
				'language_id'    => 45,
				'view'           => 'admin.' . $this->constants['snakeCasePlural'] . '.create',
				'title'          => 'Admin Create ' . $this->constants['singularCase'],
				'http_verb'      => 'get',
				'slug'           => '/admin/'. $this->constants['slug'] . '/create',
				'response_type'  => 'View',
				'route_name'     => 'admin-' . $this->constants['slug'] . '-create',
				'before'         => 'ifNotLoggedInGoToLogin'
			],
			[
				'language_id'    => 45,
				'view'           => 'admin.' . $this->constants['snakeCasePlural'] . '.edit',
				'title'          => 'Admin Edit ' . $this->constants['singularCase'],
				'http_verb'      => 'get',
				'slug'           => '/admin/'. $this->constants['slug'] . '/edit/{' . $this->constants['singularVar'] . 'id}',
				'response_type'  => 'View',
				'route_name'     => 'admin-' . $this->constants['slug'] . '-edit',
				'before'         => 'ifNotLoggedInGoToLogin'
			],
		];
	}

	/**
	 * Sets the APIs needed for this scaffold to work in Devise
	 *
	 * @return void
     */
	protected function setApis()
	{
		$this->apis = [
			[
				'language_id'     => 45,
				'view'            => null,
				'title'           => 'Admin ' . $this->constants['singularCase'] . ' Update',
				'http_verb'       => 'put',
				'slug'            => '/admin/'. $this->constants['slug'] . '/update/{'.$this->constants['singularVar'].'id}',
				'response_type'   => 'Function',
				'response_path'   => $this->constants['namespace'] .'\\'. $this->constants['className'] .'\\'.$this->constants['className'] .'ResponseHandler.requestUpdate',
				'response_params' => 'params.'.$this->constants['singularVar'].'id, input',
				'route_name'      => 'admin-' . $this->constants['slug'] . '-update',
				'before'          => 'ifNotLoggedInGoToLogin'
			],
			[
				'language_id'     => 45,
				'view'            => null,
				'title'           => 'Admin ' . $this->constants['singularCase'] . ' Destroy',
				'http_verb'       => 'delete',
				'slug'            => '/admin/'. $this->constants['slug'] . '/destroy/{'.$this->constants['singularVar'].'id}',
				'response_type'   => 'Function',
				'response_path'   => $this->constants['namespace'] .'\\'. $this->constants['className'] .'\\'.$this->constants['className'] .'ResponseHandler.requestDestroy',
				'response_params' => 'params.'.$this->constants['singularVar'].'id',
				'route_name'      => 'admin-' . $this->constants['slug'] . '-destroy',
				'before'          => 'ifNotLoggedInGoToLogin'
			],
			[
				'language_id'     => 45,
				'view'            => null,
				'title'           => 'Admin ' . $this->constants['singularCase'] . ' Store',
				'http_verb'       => 'post',
				'slug'            => '/admin/'. $this->constants['slug'] . '/store',
				'response_type'   => 'Function',
				'response_path'   => $this->constants['namespace'] .'\\'. $this->constants['className'] .'\\'.$this->constants['className'] .'ResponseHandler.requestCreate',
				'response_params' => 'input',
				'route_name'      => 'admin-' . $this->constants['slug'] . '-store',
				'before'          => 'ifNotLoggedInGoToLogin'
			],
		];
	}
}