<?php
namespace Serotoninja\DevBundle\EventListener;

use Swift_Message;
use Swift_Events_SendEvent;
use Swift_Events_SendListener;

/**
 * Class EmailListener
 * Memory driver for Email messages
 *
 * @author Ton Sharp <66ton99@gmail.com>
 */
class EmailListener implements Swift_Events_SendListener
{
    /**
     * @var array
     */
    protected $preSendMessages = array();

    /**
     * @var array
     */
    protected $postSendMessages = array();

    public function clean()
    {
        $this->preSendMessages = array();
        $this->postSendMessages = array();
    }

    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
        $this->preSendMessages[] = $evt->getMessage();
    }

    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        $this->postSendMessages[] = $evt->getMessage();
    }

    public function getPreSendMessages()
    {
        return $this->preSendMessages;
    }

    public function getPostSendMessages()
    {
        return $this->postSendMessages;
    }

    /**
     * @param $item
     *
     * @return Swift_Message
     */
    public function getPreSendMessage($item)
    {
        if (empty($this->preSendMessages[$item])) {
            return null;
        }
        return $this->preSendMessages[$item];
    }

    /**
     * @param $item
     *
     * @return Swift_Message
     */
    public function getPostSendMessage($item)
    {
        if (empty($this->postSendMessages[$item])) {
            return null;
        }
        return $this->postSendMessages[$item];
    }
}
