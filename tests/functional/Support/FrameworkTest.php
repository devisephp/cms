<?php namespace Devise\Support;

class FrameworkTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->Framework = new Framework;
    }

    public function test_it_resolves_auth()
    {
        assertInstanceOf('Illuminate\Auth\AuthManager', $this->Framework->Auth);
    }

    public function test_it_resolves_config()
    {
        assertInstanceOf('Illuminate\Config\Repository', $this->Framework->Config);
    }

    public function test_it_resolves_container()
    {
        assertInstanceOf('Illuminate\Container\Container', $this->Framework->Container);
    }

    public function test_it_resolves_event()
    {
        assertInstanceOf('Illuminate\Events\Dispatcher', $this->Framework->Event);
    }

    public function test_it_resolves_exception()
    {
        assertInstanceOf('Devise\Support\DeviseException', $this->Framework->Exception);
    }

    public function test_it_resolves_hash()
    {
        assertInstanceOf('Illuminate\Hashing\BcryptHasher', $this->Framework->Hash);
    }

    public function test_it_resolves_input()
    {
        assertInstanceOf('Illuminate\Http\Request', $this->Framework->Input);
    }

    public function test_it_resolves_lang()
    {
        assertInstanceOf('Illuminate\Translation\Translator', $this->Framework->Lang);
    }

    public function test_it_resolves_mail()
    {
        assertInstanceOf('Illuminate\Mail\Mailer', $this->Framework->Mail);
    }

    public function test_it_resolves_password()
    {
        assertInstanceOf('Illuminate\Auth\Reminders\PasswordBroker', $this->Framework->Password);
    }

    public function test_it_resolves_redirect()
    {
        assertInstanceOf('Illuminate\Routing\Redirector', $this->Framework->Redirect);
    }

    public function test_it_resolves_response()
    {
        assertInstanceOf('Devise\Support\DeviseResponse', $this->Framework->Response);
    }

    public function test_it_resolves_request()
    {
        assertInstanceOf('Illuminate\Http\Request', $this->Framework->Request);
    }

    public function test_it_resolves_session()
    {
        assertInstanceOf('Illuminate\Session\SessionManager', $this->Framework->Session);
    }

    public function test_it_resolves_url()
    {
        assertInstanceOf('Illuminate\Routing\UrlGenerator', $this->Framework->URL);
    }

    public function test_it_resolves_validator()
    {
        assertInstanceOf('Illuminate\Validation\Factory', $this->Framework->Validator);
    }

    public function test_it_resolves_view()
    {
        assertInstanceOf('Illuminate\View\Factory', $this->Framework->View);
    }
}