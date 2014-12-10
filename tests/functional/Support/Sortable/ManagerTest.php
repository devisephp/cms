<?php namespace Devise\Support\Sortable;

use Mockery as m;

class ManagerTest extends \DeviseTestCase
{
    public function test_it_gets_is_multi()
    {
        $Framework = new \Devise\Support\Framework;
        $Framework->Session = m::mock('Mock\Session');
        $Framework->Session->shouldReceive('get')->times(1);
        $Manager = new Manager($Framework);
        $Manager->getIsMulti();
    }

    public function test_it_sets_is_multi()
    {
        $Framework = new \Devise\Support\Framework;
        $Framework->Session = m::mock('Mock\Session');
        $Framework->Session->shouldReceive('put')->times(1);
        $Manager = new Manager($Framework);
        $Manager->setIsMulti(true);
    }

    public function test_it_gets_key()
    {
        $Framework = new \Devise\Support\Framework;
        $Manager = new Manager($Framework);
        assertEquals('httplocalhost', $Manager->getKey());
    }

    public function test_it_sets_key()
    {
        $Framework = new \Devise\Support\Framework;
        $Manager = new Manager($Framework);
        $Manager->setKey('somekey');
    }

    public function test_it_adds_to_stack()
    {
        $Framework = new \Devise\Support\Framework;
        $Framework->Session = m::mock('Mock\Session');
        $Framework->Session->shouldReceive('get')->times(1)->andReturn([]);
        $Framework->Session->shouldReceive('put')->times(1);
        $Manager = new Manager($Framework);
        $Manager->addToStack([]);
    }

    public function test_it_removes_from_stack()
    {
        $Framework = new \Devise\Support\Framework;
        $Manager = new Manager($Framework);
        $Manager->removeFromStack([]);
    }

    public function test_it_gets_stack()
    {
        $Framework = new \Devise\Support\Framework;
        $Manager = new Manager($Framework);
        $Manager->getStack();
    }

    public function test_it_clears_stack()
    {
        $Framework = new \Devise\Support\Framework;
        $Manager = new Manager($Framework);
        $Manager->clearStack();
    }
}