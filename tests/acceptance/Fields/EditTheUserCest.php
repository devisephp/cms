<?php namespace Fields;

class EditTheUserCest extends BaseFieldTest
{
    public function i_can_edit_the_user(\AcceptanceTester $I)
    {
        $I->clickNode('#model1-node');
        // $I->fillField('text','testemail@lbm.co');
        // $I->click('button.dvs-sidebar-save-group');
        // $I->wait(self::WAIT_TIME);
        // $I->seeInDatabase('users', array('email' => 'testemail@lbm.co'));
    }
}