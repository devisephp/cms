<?php namespace Fields;

class WysiwygCest extends BaseFieldTest
{
    public function i_can_update_field(\AcceptanceTester $I)
    {
        $I->clickNode('#field15-node');
    }
}