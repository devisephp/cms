<?php namespace Fields;

class AudioCest extends BaseFieldTest
{
	/**
	 * @incomplete
	 * not sure how to test this since it requires a file input
	 */
    public function i_can_update_field(\AcceptanceTester $I)
    {
        $I->clickNode('#field1-node');
    }
}