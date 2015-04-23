<?php

class BaseAcceptanceTester extends \Codeception\Actor
{
    /**
     * logs in using the admin login form
     */
    public function login($url = '/admin/login')
    {
        $this->amOnPage($url);
        $this->see('Log In to Administration');
        $this->fillField('uname_or_email', 'devise');
        $this->fillField('password', 'secret');
        $this->click('Log In to Administration');
    }

    /**
     * loads logout page
     */
    public function logout()
    {
        $this->amOnPage('/admin/logout');
    }

    /**
     * loads logout page
     */
    public function gotoFieldsAndShowNodes($waitTime = 5)
    {
        $this->login('/admin/fields');
        $this->waitForElement('#dvs-node-mode-button', $waitTime);
        $this->click('Edit Page');
        $this->switchToIFrame('dvsiframe');
        $this->waitForElement('.dvs-node', $waitTime);
    }

    /**
     * clicks on a node using the text in the span
     * waits for the sidebar to load
     */
    public function clickNode($nodeId, $waitTime = 5)
    {
        $this->waitForElement($nodeId, $waitTime);
        $this->click($nodeId);
        $this->switchToWindow();
        $this->waitForElement("//div[@id='dvs-sidebar'][@class='loaded']", $waitTime);
    }

    /**
    * generates random string, 10 characters long by default
    **/
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}