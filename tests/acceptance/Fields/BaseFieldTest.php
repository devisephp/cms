<?php namespace Fields;

class BaseFieldTest
{
    /**
     * Wait time for stuff
     */
    const WAIT_TIME = 5;

    /**
     * Runs before every test
     *
     * @param  AcceptanceTester $I
     * @return [type]
     */
    public function _before(\AcceptanceTester $I)
    {
        $I->gotoFieldsAndShowNodes();
    }

    /**
     * Runs after every test
     *
     * @param  AcceptanceTester $I
     * @return [type]
     */
    public function _after(\AcceptanceTester $I)
    {
        $I->logout();
    }
}
