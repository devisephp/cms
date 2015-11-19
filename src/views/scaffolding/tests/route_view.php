<?php echo '<?php' ?>

class <?= $test_name ?> extends TestCase
{
	public function <?= $test_method ?>()
	{
		$response = $this->call('<?= $route_method ?>', '<?= $route_url ?>');

		$this->assertEquals(200, $response->status());
	}
}