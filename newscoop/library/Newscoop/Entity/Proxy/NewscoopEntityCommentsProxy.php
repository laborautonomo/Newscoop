<?php

namespace Newscoop\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class NewscoopEntityCommentsProxy extends \Newscoop\Entity\Comments implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setTimeCreated(\DateTime $p_datetime)
    {
        $this->_load();
        return parent::setTimeCreated($p_datetime);
    }

    public function getTimeCreated()
    {
        $this->_load();
        return parent::getTimeCreated();
    }

    public function setSubject($p_subject)
    {
        $this->_load();
        return parent::setSubject($p_subject);
    }

    public function getSubject()
    {
        $this->_load();
        return parent::getSubject();
    }

    public function setMessage($p_message)
    {
        $this->_load();
        return parent::setMessage($p_message);
    }

    public function getMessage()
    {
        $this->_load();
        return parent::getMessage();
    }

    public function setIp($p_ip)
    {
        $this->_load();
        return parent::setIp($p_ip);
    }

    public function getIp()
    {
        $this->_load();
        return parent::getIp();
    }

    public function setUser(\Newscoop\Entity\CommentsUsers $p_user)
    {
        $this->_load();
        return parent::setUser($p_user);
    }

    public function getUser()
    {
        $this->_load();
        return parent::getUser();
    }

    public function getUserName()
    {
        $this->_load();
        return parent::getUserName();
    }

    public function setStatus($p_status)
    {
        $this->_load();
        return parent::setStatus($p_status);
    }

    public function getStatus()
    {
        $this->_load();
        return parent::getStatus();
    }

    public function setThread(\Newscoop\Entity\Articles $p_thread)
    {
        $this->_load();
        return parent::setThread($p_thread);
    }

    public function getThread()
    {
        $this->_load();
        return parent::getThread();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'user', 'forum', 'parent', 'thread', 'language', 'subject', 'message', 'thread_level', 'status', 'ip', 'time_created', 'likes', 'dislikes');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}