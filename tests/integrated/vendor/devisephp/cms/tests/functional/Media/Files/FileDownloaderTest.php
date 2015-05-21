<?php namespace Devise\Media\Files;

use Mockery as m;

class FileDownloaderTest extends \DeviseTestCase
{
    public function test_it_downloads_files()
    {
        // don't have a good way to test this without actually
        // using a real url I suppose, so I'm just going to
        // make sure it constructs for now
        // @todo see if there is a better test for this
        $FileDownloader = new FileDownloader;
    }
}