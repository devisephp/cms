<?php namespace Devise\Media\Files;

use Mockery as m;

class RepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Filesystem = m::mock('Devise\Media\Files\Filesystem');
        $this->Config = [
            'root-dir' => 'media',
            'thumb-key' => 'dvs-thumb',
            'crop-key' => 'dvs-crop',
            'thumbs' => [
                'file' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'png' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'jpeg' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'jpg' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'gif' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'xls' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'doc' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'docx' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'zip' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
                'js' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
            ]
        ];

        $this->Request = m::mock('Illuminate\Http\Request');
        $this->URL = m::mock('Illuminate\Routing\UrlGenerator');
        $this->Repository = new Repository($this->Filesystem, $this->Config, $this->Request, $this->URL);
    }

    /**
     * @todo come back to testing this...
     */
    public function test_it_compiles_index_data()
    {
        $this->Request->shouldReceive('url')->andReturn('someUrl');
        // $this->Repository->compileIndexData(['capable' => true]);
    }
}