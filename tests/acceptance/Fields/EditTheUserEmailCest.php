<?php namespace Fields;

class EditTheUserEmailCest extends BaseFieldTest
{
    public function i_can_edit_the_users_email(\AcceptanceTester $I)
    {
        $I->clickNode('#attribute3-node');
        $I->fillField('text','testemail@lbm.co');
        $I->click('button.dvs-sidebar-save-group');
        $I->wait(self::WAIT_TIME);
        $I->seeInDatabase('users', array('email' => 'testemail@lbm.co'));
    }
}