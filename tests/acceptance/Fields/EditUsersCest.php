<?php namespace Fields;

class EditUsersCest extends BaseFieldTest
{
    public function i_can_edit_the_users(\AcceptanceTester $I)
    {
        $I->clickNode('#group3-node');
        // $I->fillField('text','testemail@lbm.co');
        // $I->click('button.dvs-sidebar-save-group');
        // $I->wait(self::WAIT_TIME);
        // $I->seeInDatabase('users', array('email' => 'testemail@lbm.co'));
    }
}