<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('sign in with valid account');
$I->amOnPage('/admin/login');