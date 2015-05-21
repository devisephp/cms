<?php namespace Devise\Support\IO;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class FileDiffTest extends \DeviseTestCase
{
    public function setUp()
    {
    	parent::setUp();

        $structure = array(
            'config1' => array(
            	'auth.php' => $this->fixture('auth-config'),
            	'database.php' => $this->fixture('database-config'),
            	'subdir' => array(
            		'auth.php' => $this->fixture('auth-config')
            	)
            ),
            'config2' => array(
            	'auth.php' => $this->fixture('config-overrides'),
            	'somefile.php' => $this->fixture('database-config'),
            	'subdir' => array(
            		'auth.php' => $this->fixture('database-config')
            	)
            )
        );

        vfsStream::setup('basedir', null, $structure);
	}

	public function test_it_finds_different_files()
	{
		$FileDiff = new FileDiff;
		$difference = $FileDiff->different(vfsStream::url('basedir/config1'), vfsStream::url('basedir/config2'));
		assertEquals(['auth.php', 'subdir/auth.php'], $difference);
	}

	public function test_it_finds_unmodified_files()
	{
		$FileDiff = new FileDiff;
		$unmodified = $FileDiff->unmodified(vfsStream::url('basedir/config1'), vfsStream::url('basedir/config2'));
		assertEquals(['database.php'], $unmodified);
	}
}