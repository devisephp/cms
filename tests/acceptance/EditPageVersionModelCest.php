<?php

class EditPageVersionModelCest extends BaseTester {

    public function _before(AcceptanceTester $I)
    {
        $this->login($I);
        $this->gotToFieldsAndShowNodes($I);
    }

    public function _after(AcceptanceTester $I)
    {
        $this->logout($I);
    }

    /**
     * clicking on the node and open sidebar
     */
    public function clickOnNodeToOpenSidebar(AcceptanceTester $I)
    {
        $this->clickNode($I, 'Edit the Page Versioned Model');
    }

    /**
     * clicking on the "name" grid item
     */
    public function clickNameGridItem(AcceptanceTester $I)
    {
        $this->clickNode($I, 'Edit the Page Versioned Model');

        $I->click('.dvs-sidebar-elements button');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->see('Max Length');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);
        $I->dontSee('Max Length');
    }

    /**
     * fill out field and save, refresh and make sure random value is on page
     */
    public function saveTestValue(AcceptanceTester $I)
    {
        $value = $this->randString();

        $this->clickNode($I, 'Edit the Page Versioned Model');
        
        $I->click('.dvs-sidebar-elements button');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);

        $I->fillField('text',$value);
        $I->click('button.dvs-sidebar-save-group');

        $I->wait(5); // waiting for ajax to save
        $I->seeInDatabase('dvs_test_models', array('id' => 1, 'name' => $value));
    }
}
?>