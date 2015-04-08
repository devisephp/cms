<?php namespace Devise\Templates;

use \Illuminate\Filesystem\Filesystem as Filesystem;
use Devise\Support\Config\FileManager as ConfigFileManager;

use Mockery as m;

class TemplatesRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;

        $this->Filesystem = new Filesystem;

        $this->ConfigFileManager = m::mock(new ConfigFileManager($this->Filesystem, $this->Framework));
        $this->ConfigFileManager->shouldReceive('saveToFile')->andReturn(['some' => 'stuff']);

        $this->TemplatesManager = new TemplatesManager($this->ConfigFileManager, $this->Framework);

        $this->TemplatesRepository = new TemplatesRepository($this->TemplatesManager, $this->Framework);
    }

    public function test_it_can_get_template_by_path()
    {
        $results = $this->TemplatesRepository->getTemplateByPath('devise::installer.welcome');

        assertInternalType('array', $results);
        assertEquals($results['human_name'], 'Devise: Welcome Page');
    }

    public function test_it_cannot_get_template_by_path()
    {
        $templatePath = 'does.not.exist';

        $this->setExpectedException('Devise\Templates\DeviseTemplateNotFoundException', '"' . $templatePath . '" was not found in templates config. Please check the devise.templates.php and ensure this path exists.');
        $this->TemplatesRepository->getTemplateByPath($templatePath);
    }

    public function test_it_can_get_all_templates_paginated()
    {
        assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $this->TemplatesRepository->allTemplatesPaginated(2));
    }

    public function test_it_can_get_all_templates_paginated_with_invalid_param()
    {
        assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $this->TemplatesRepository->allTemplatesPaginated('abc'));
    }

    public function test_it_can_get_registered_templates_list_with_human_names()
    {
        $results = $this->TemplatesRepository->registeredTemplatesList();

        assertInternalType('array', $results);
        assertEquals('Devise: Welcome Page', $results['devise::installer.welcome']);
    }

    public function test_it_can_get_unregistered_templates_list()
    {
        $results = $this->TemplatesRepository->unregisteredTemplatesList();
        assertInternalType('array', $results);
        assertEquals('app', $results['app']);
    }
}