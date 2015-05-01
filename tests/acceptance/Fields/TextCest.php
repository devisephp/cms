<?php namespace Fields;

class TextCest extends BaseFieldTest
{
    public function i_can_update_field(\AcceptanceTester $I)
    {
        $I->clickNode('#field12-node');
    }
}