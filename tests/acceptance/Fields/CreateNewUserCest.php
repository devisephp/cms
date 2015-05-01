<?php namespace Fields;

class CreateNewUserCest extends BaseFieldTest
{
    public function i_see_the_grid_buttons(\AcceptanceTester $I)
    {
        $I->clickNode('#creatorcreator-933e76acb06dec2ba6c31ba9c058a4e9-node');
        $I->seeElement('button[data-creator-attribute-name="Name"]');
        $I->seeElement('button[data-creator-attribute-name="Email"]');
        $I->seeElement('button[data-creator-attribute-name="Password"]');
    }

    public function i_can_click_each_grid_item(\AcceptanceTester $I)
    {
        $I->clickNode('#creatorcreator-933e76acb06dec2ba6c31ba9c058a4e9-node');
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

    public function i_cannot_create_invalid_user(\AcceptanceTester $I)
    {
        $I->clickNode('#creatorcreator-933e76acb06dec2ba6c31ba9c058a4e9-node');
        $I->click('button[data-creator-attribute-name="Name"]');
        $I->waitForElement('#dvs-sidebar-field-form', self::WAIT_TIME);
        $I->click('button.dvs-sidebar-save-group');
        $I->waitForElement('#dvs-sidebar-validation-errors', 20);
        $I->wait(5);
        $I->see('The name field is required.', '#dvs-sidebar-validation-errors');
    }

    public function i_can_create_a_new_user(\AcceptanceTester $I)
    {
        $I->clickNode('#creatorcreator-933e76acb06dec2ba6c31ba9c058a4e9-node');
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
        $I->wait(self::WAIT_TIME);
        $I->seeInDatabase('users', array('email' => 'testemail@lbm.co'));
    }
}
?>