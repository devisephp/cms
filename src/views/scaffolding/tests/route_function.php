<?php echo '<?php' ?>

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class <?= $test_name ?> extends TestCase
{
	use WithoutMiddleware, DatabaseTransactions;

	public function <?= $test_method ?>()
	{
		$input = [

		];

		$response = $this->call('<?= $route_method ?>', '<?= $route_url ?>', $input);

		$this->assertEquals(200, $response->status());
	}
}