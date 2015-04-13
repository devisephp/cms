<?php
class BaseTester {

    const WAIT_TIME = 5;

    /**
     * logs in using the admin login form
     */
    protected function login(AcceptanceTester $I)
    {
        // login
        $I->amOnPage('/admin/login');
        $I->see('Log In to Administration');
        $I->fillField('uname_or_email', 'devise');
        $I->fillField('password', 'secret');
        $I->click('Log In to Administration');
        $I->see('DASHBOARD');
    }

    /**
     * loads logout page
     */
    protected function logout(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/logout');
    }

    /**
     * loads logout page
     */
    protected function gotToFieldsAndShowNodes(AcceptanceTester $I)
    {
        // go to fields page
        $I->amOnPage('/admin/fields');

        // wait for the edit page button
        $I->waitForElement('#dvs-node-mode-button', self::WAIT_TIME);
        $I->click('Edit Page');

        // wait for nodes
        $I->waitForElement('.dvs-node', self::WAIT_TIME);
    }

    /**
     * clicks on a node using the text in the span
     * waits for the sidebar to load
     */
    protected function clickNode(AcceptanceTester $I, $name)
    {
        $I->waitForElement("//span[.='" . $name . "']", self::WAIT_TIME);
        $I->click("//span[.='" . $name . "']");

        // wait for <div id="dvs-sidebar" class="loaded">
        $I->waitForElement("//div[@id='dvs-sidebar'][@class='loaded']", self::WAIT_TIME);
    }

    /**
    * generates random string, 10 characters long by default
    **/
    protected function randString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>