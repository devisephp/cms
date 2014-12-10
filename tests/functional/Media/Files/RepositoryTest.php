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
                'file' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'png' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'jpeg' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'jpg' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'gif' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'xls' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'doc' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'docx' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'zip' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
                'js' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
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