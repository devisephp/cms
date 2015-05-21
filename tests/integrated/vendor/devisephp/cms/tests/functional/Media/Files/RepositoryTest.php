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

        $this->MediaPaths = m::mock('Devise\Media\MediaPaths');
        $this->Request = m::mock('Illuminate\Http\Request');
        $this->URL = m::mock('Illuminate\Routing\UrlGenerator');
        $this->Images = m::mock('Devise\Media\Images\Images');
        $this->Repository = new Repository($this->Filesystem, $this->MediaPaths, $this->Images, $this->Config, $this->Request, $this->URL);
    }

    /**
     * @todo come back to testing this...
     */
    public function test_it_can_compile_index_data()
    {
        $this->Request->shouldReceive('url')
            ->andReturn('someUrl');

        $this->Filesystem->shouldReceive('exists')
            ->once()
            ->andReturn(true)
            ->shouldReceive('directories')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('files')
            ->once()
            ->andReturnSelf();

        $output = $this->Repository->compileIndexData(['capable' => true]);

        assertInternalType('array', $output);
        assertArrayHasKey('crumbs', $output);
        assertArrayHasKey('categories', $output);
        assertArrayHasKey('media-items', $output);
        assertArrayHasKey('searched-items', $output);
    }
}