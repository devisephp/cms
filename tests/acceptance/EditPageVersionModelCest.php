<?php

class EditPageVersionModelCest extends BaseAcceptanceTest
{
    public function i_can_click_name_grid_item(AcceptanceTester $I)
    {
        $I->clickNode('#model0-node');
        $I->click('.dvs-sidebar-elements button');
        $I->waitForElement('#dvs-sidebar-field-form', 5);
        $I->see('Max Length');
        $I->click('a[data-breadcrumb-id="0"]');
        $I->wait(1);
        $I->dontSee('Max Length');
    }

    public function i_can_save_this_model(AcceptanceTester $I)
    {
        $value = $I->generateRandomString();
        $I->clickNode('#model0-node');
        $I->click('.dvs-sidebar-elements button');
        $I->waitForElement('#dvs-sidebar-field-form', 5);
        $I->fillField('text', $value);
        $I->click('button.dvs-sidebar-save-group');
        $I->wait(10);
        $I->seeInDatabase('dvs_test_models', array('id' => 1, 'name' => $value));
    }
}