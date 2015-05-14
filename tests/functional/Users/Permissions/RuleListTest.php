<?php namespace Devise\Users\Permissions;

use Mockery as m;

class RuleListTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->DvsUser = new \DvsUser;
        $this->Framework =  new \Devise\Support\Framework;
        $this->Framework->Auth = m::mock('Illuminate\Auth\Guard');
        $this->RuleList = new RuleList($this->DvsUser, $this->Framework);
    }

    /**
     * @expectedException Exception
     */
    public function test_it_throws_exception_for_call_to_unknown_method()
    {
        $this->RuleList->fooMethod();
    }

    public function test_it_can_call_a_user_defined_function()
    {
        // add closure to rules array
        $this->RuleList->rules[] = 'functOne';

        // define anonymous function and add to closures array
        $this->RuleList->closures['functOne'] = function() {
            return 'foo';
        };

        assertEquals( 'foo', $this->RuleList->functOne() );
    }

    /**
     * @expectedException Exception
     */
    public function test_it_throws_an_error_on_call_to_undefined_user_function()
    {
        // add closure to rules array
        $this->RuleList->rules[] = 'functOne';
        $this->RuleList->functOne();
    }

    public function test_it_tells_us_if_we_are_logged_in()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(true);
        assertTrue( $this->RuleList->isLoggedIn() );
    }

    public function test_it_tells_us_if_we_are_not_logged_in()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(false);
        assertTrue( $this->RuleList->isNotLoggedIn() );
    }

    public function test_it_tells_us_if_we_are_in_a_group()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->isInGroup('Developer', 'Group1') );
    }

    public function test_it_tells_us_if_we_are_not_in_a_group()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertFalse( $this->RuleList->isNotInGroup('Developer', 'Group1') );
    }

    public function test_it_tells_us_if_we_are_in_groups()
    {
        $this->Framework->Auth->shouldReceive('check')->times(2)->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->isInGroups('Developer', 'Developer') );
        assertFalse( $this->RuleList->isInGroups('Developer', 'Group1') );
    }

    public function test_it_tells_us_if_we_are_not_in_groups()
    {
        $this->Framework->Auth->shouldReceive('check')->times(3)->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->isNotInGroups('Group1', 'Group2') );
        assertTrue( $this->RuleList->isNotInGroups('Developer', 'Group1') );
        assertFalse( $this->RuleList->isNotInGroups('Developer', 'Developer') );
    }

    public function test_it_tells_us_if_we_have_a_name()
    {
        $this->Framework->Auth->shouldReceive('check')->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->hasName('Devise Administrator') );
    }

    public function test_it_tells_us_if_we_have_an_email()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->hasEmail('noreply@devisephp.com') );
    }

    public function test_it_tells_us_if_we_have_a_username()
    {
        $this->Framework->Auth->shouldReceive('check')->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->hasUserName('deviseadmin') );
    }

    public function test_it_tells_us_if_we_have_a_field_value()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(true);

        $currentUser = $this->DvsUser->find(1);
        $this->Framework->Auth->shouldReceive('user')->andReturn($currentUser);

        assertTrue( $this->RuleList->hasFieldValue('email', 'noreply@devisephp.com') );
    }

    public function test_it_tells_us_if_we_can_show_devise_span()
    {
        $this->Framework->Auth->shouldReceive('check')->once()->andReturn(true);
        assertTrue( $this->RuleList->showDeviseSpan('someKey', new \Illuminate\Support\Collection) );
    }
}