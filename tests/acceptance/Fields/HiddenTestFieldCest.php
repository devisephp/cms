<?php namespace Fields;

class HiddenTestFieldCest extends BaseFieldTest
{
    public function i_can_update_field(\AcceptanceTester $I)
    {
        $I->clickNode('#field21-node');
    }
}