<?php namespace Fields;

class HtmlCest extends BaseFieldTest
{
    public function i_can_update_field(\AcceptanceTester $I)
    {
        $I->clickNode('#field7-node');
    }
}