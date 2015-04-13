<?php

class EditTheUserEmailCest extends BaseTester {

    public function _before(AcceptanceTester $I)
    {
        $this->login($I);
        $this->gotToFieldsAndShowNodes($I);

        $this->clickNode($I, 'Edit the User Email');
    }

    public function _after(AcceptanceTester $I)
    {
        $this->logout($I);
    }

    /**
     * sidebar is open form is howing
     */
    public function checkIfFormOpenByDefault(AcceptanceTester $I)
    {
        $I->see('Max Length');
    }

    /**
     * fill out email field and save
     */
    public function saveTestValue(AcceptanceTester $I)
    {
        $I->fillField('text','testemail@lbm.co');

        $I->click('button.dvs-sidebar-save-group');

        $I->wait(5); // waiting for ajax to save
        $I->seeInDatabase('users', array('email' => 'testemail@lbm.co'));
    }
}
?>