<?php namespace Devise\Support\Config;

use Mockery as m;

class SettingsRepositoryTest extends \DeviseTestCase
{
    public function test_it_can_fetch_all_overrides()
    {
        $overrides = ['a' => 1, 'b' => 2];
        $SettingsRepository = new SettingsRepository($overrides);
        assertEquals($overrides, $SettingsRepository->fetchAllOverrides());
    }
}