<?php namespace Devise\Mothership\Logs\Payload;

use Devise\Mothership\Logs\Utilities;

class Context implements \Serializable
{
    private $pre;
    private $post;
    private $utilities;

    public function __construct($pre, $post)
    {
        $this->utilities = new Utilities();
        $this->setPre($pre);
        $this->setPost($post);
    }

    public function getPre()
    {
        return $this->pre;
    }

    public function setPre($pre)
    {
        $this->pre = $pre;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    public function serialize()
    {
        $result = array(
            "pre" => $this->pre,
            "post" => $this->post,
        );
        return $this->utilities->serializeForLogs($result);
    }
    
    public function unserialize($serialized)
    {
        throw new \Exception('Not implemented yet.');
    }
}
