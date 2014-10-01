<?php

use Devise\User\Permissions\RuleList;
use Mockery as m;

class RuleListTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test __call() method throws an exception for an unknown function in the RuleList
     * class. Checks the exception message equals what is expected.
     *
     * @expectedException              Exception
     * @expectedExceptionMessage       Unknown Function "isNotAnActualRule" in RuleList
     */
    public function testCallMethodFailsWhenUnknownFunctionIsCalled()
    {
        $RuleList = new RuleList(m::mock('User'));
        $RuleList->isNotAnActualRule();
    }

    /**
     * Test _call() method executes call_user_func_array function if method
     * is in the rules array.
     *
     * @expectedException              Exception
     * @expectedExceptionMessage       Unknown Function "fooFunc" in RuleList
     */
    public function testCallMethodExecutesCallUserFuncArrayIfMethodInRulesArray()
    {
        $RuleList = new RuleList(m::mock('User'));

        // manually override init. $rules array in RuleList to get passed the first if
        // Statement in __call(); Which would signify it is a closure.
        $RuleList->rules = array('fooFunc');
        $RuleList->fooFunc();
    }

    /**
     * Test isLoggedIn method returns true when a user is logged in
     */
    public function testIsLoggedInReturnsTrueWhenUserLoggedIn()
    {
        Auth::shouldReceive('check')
            ->andReturn(true);

        $RuleList = new RuleList(m::mock('User'));
        $result = $RuleList->isLoggedIn();

        // check for true value
        $this->assertTrue($result);
    }

    /**
     * Test isLoggedIn method returns false if no user is logged in
     */
    public function testIsLoggedInReturnsFalseWhenNoUserLoggedIn()
    {
        $RuleList = new RuleList(m::mock('User'));
        $result = $RuleList->isLoggedIn();

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test isInGroup method returns true when a user is in the specified group
     */
    public function testIsInGroupReturnsTrueWhenUserIsInTheSpecifiedGroup()
    {
        // Partial mock User[groups] and Group[name] then set mocked Group equal to
        // User->groups relation and wrap in an array for the foreach
        $mockUser = m::mock('User[groups]');
        $mockGroup = m::mock('Group[name]');
        $mockGroup->name = 'Teamsters';
        $mockUser->groups = array($mockGroup);

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->isInGroup('Teamsters');

        // check for true value
        $this->assertTrue($result);
    }

    /**
     * Test isInGroup method returns false when User does have groups, but none
     * of the group names are a match to the specified string
     */
    public function testIsInGroupReturnsFalseWhenUserHasGroupsButNoGroupNameMatches()
    {
        // Partial mock User[groups] and Group[name] then set mocked Group equal to
        // User->groups relation wrapped in an array (for the foreach loop)
        $mockUser = m::mock('User[groups]');
        $mockGroup = m::mock('Group[name]');
        $mockGroup->name = 'Teamsters';
        $mockUser->groups = array($mockGroup);

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->isInGroup('FooGroupName');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test isInGroup method return false when user is not logged in
     */
    public function testIsInGroupReturnsFalseWhenUserNotLoggedIn()
    {
        $RuleList = new RuleList(m::mock('User'));
        $result = $RuleList->isInGroup('Administrators');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test isNotInGroup method returns true when all of the user's groups have
     * been checked against the group name passed and no matches were found.
     */
    public function testIsNotInGroupReturnsTrueWhenNoGroupMatchesFound()
    {
        // Partial mock User[groups] and Group[name] then set mocked Group equal to
        // User->groups relation and wrap in an array for the foreach
        $mockUser = m::mock('User[groups]');
        $mockGroup = m::mock('Group[name]');
        $mockGroup->name = 'Foo';
        $mockUser->groups = array($mockGroup);

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->isNotInGroup('Teamsters');

        // check for true value indicating no matches found
        $this->assertTrue($result);
    }

    /**
     * Test isNotInGroup method returns false when User group name matches are found
     */
    public function testIsNotInGroupReturnsFalseWhenGroupMatchesExist()
    {
        // Partial mock User[groups] and Group[name] then set mocked Group equal to
        // User->groups relation wrapped in an array (for the foreach loop)
        $mockUser = m::mock('User[groups]');
        $mockGroup = m::mock('Group[name]');
        $mockGroup->name = 'Teamsters';
        $mockUser->groups = array($mockGroup);

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->isNotInGroup('Teamsters');

        // check for false value indicating match(es) found
        $this->assertFalse($result);
    }

    /**
     * Test isNotInGroup method return false when user is not logged in
     */
    public function testIsNotInGroupReturnsFalseWhenUserNotLoggedIn()
    {
        $RuleList = new RuleList(m::mock('User'));
        $result = $RuleList->isNotInGroup('Administrators');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test hasUserName method returns true when username isset and
     * the value matches the provided value
     */
    public function testHasUserNameReturnsTrueWhenFieldIssetAndValuesMatch()
    {
        $mockUser = m::mock('User[username]');
        $mockUser->username = 'yolanda';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasUserName('yolanda');

        // check for true value
        $this->assertTrue($result);
    }

    /**
     * Test hasUserName method returns false when User does not have the
     * the property/field value being searched against
     */
    public function testHasUserNameReturnsFalseWhenUserDoesNotHaveProperty()
    {
        $mockUser = m::mock('User[foo_property]');

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasUserName('yolanda@lbm.co');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test hasUserName method returns false when User does
     * not have a matching field value with the value provided.
     */
    public function testHasUserNameReturnsFalseWhenUserDoesNotHaveMatchingValue()
    {
        $mockUser = m::mock('User[username]');
        $mockUser->username = 'foomanchu';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasUserName('yolanda@lbm.co');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test hasEmail method returns true when passed string and
     * value of email property match.
     */
    public function testHasEmailReturnsTrueWhenValuesMatch()
    {
        $mockUser = m::mock('User[email]');
        $mockUser->email = 'foo@lbm.co';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasEmail('yolanda@lbm.co');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test hasEmail method returns false when values do not match
     */
    public function testHasEmailReturnsFalseWhenValuesDoNotMatch()
    {
        $mockUser = m::mock('User[email]');
        $mockUser->email = 'foo@lbm.co';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasEmail('yolanda@lbm.co');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test hasFieldValue method returns true when field is set and the value of the
     * field matches the string passed to the function.
     */
    public function testHasFieldValueReturnsTrueWhenEmailFieldMatchesPassedValue()
    {
        // Mock User->email and set to desired value
        $mockUser = m::mock('User[email]');
        $mockUser->email = 'yolanda@lbm.co';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasFieldValue('email', 'yolanda@lbm.co');

        // check for true value
        $this->assertTrue($result);
    }

    /**
     * Test hasFieldValue method returns false when field (being checked against) is not set
     */
    public function testHasFieldValueReturnsFalseWhenFieldIsNotSet()
    {
        $mockUser = m::mock('User[email]');
        $mockUser->email = 'yolanda@lbm.co';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        // instantiate RuleList and check for non-existent field "foo"
        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasFieldValue('foo', 'yolanda@lbm.co');

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test hasFieldValue method returns false when the email field is set but does not
     * match the string passed into the function.
     */
    public function testHasFieldValueReturnsFalseWhenEmailFieldDoesNotMatchPassedValue()
    {
        // Mock User->email and set to desired value
        $mockUser = m::mock('User[email]');
        $mockUser->email = 'foo@lbm.co';

        // mock Auth component and pass on partial User mock
        Auth::shouldReceive('user')
            ->andReturn($mockUser)
            ->shouldReceive('attempt')
            ->andReturn(true)
            ->shouldReceive('check')
            ->andReturnSelf();

        $RuleList = new RuleList($mockUser);
        $result = $RuleList->hasFieldValue('email', 'yolanda@lbm.co');

        // check for false value
        $this->assertFalse($result);
    }
}
