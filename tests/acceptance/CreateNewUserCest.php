<?php

class CreateNewUserCest extends BaseTester {

    public function _before(AcceptanceTester $I)
    {
        $this->login($I);
        $this->gotToFieldsAndShowNodes($I);

        $this->clickNode($I, 'Create New User');
    }

    public function _after(AcceptanceTester $I)
    {
        $this->logout($I);
    }

    /**
     * clicking on the node and open sidebar
     */
    public function checkTheGridIsThere(AcceptanceTester $I)
    {
        $I->seeElement('button[data-creator-attribute-name="Name"]');
        $I->seeElement('button[data-creator-attribute-name="Email"]');
        $I->seeElement('button[data-creator-attribute-name="Password"]');
    }

    /**
     * clicking on the all the grid items and using the bread crumbs
     */
    public function clickEachGridItem(AcceptanceTester $I)
    {
        $I->click('button[data-creator-attribute-name="Name"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->see('Max Length');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);
        $I->dontSee('Max Length');

        $I->click('button[data-creator-attribute-name="Email"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->see('Max Length');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);
        $I->dontSee('Max Length');

        $I->click('button[data-creator-attribute-name="Password"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->see('Max Length');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);
        $I->dontSee('Max Length');
    }

    /**
     * click on name and then try to save with blank form
     */
    public function checkValidationFails(AcceptanceTester $I)
    {
        $I->click('button[data-creator-attribute-name="Name"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->click('button.dvs-sidebar-save-group');

        $I->waitForElement('#dvs-sidebar-validation-errors', 20); // waiting for ajax to return
        $I->see('field is required');
    }

    /**
     * fill out field and save, refresh and make sure the value is saved
     */
    public function saveTestValue(AcceptanceTester $I)
    {
        $I->click('button[data-creator-attribute-name="Name"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->fillField('text','tester');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);

        $I->click('button[data-creator-attribute-name="Email"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->fillField('text','testemail@lbm.co');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);

        $I->click('button[data-creator-attribute-name="Password"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->fillField('text','password');

        $I->click('button.dvs-sidebar-save-group');

        $I->wait(5); // waiting for ajax to save
        $I->seeInDatabase('users', array('email' => 'testemail@lbm.co'));
    }
}
?>