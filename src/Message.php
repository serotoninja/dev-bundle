<?php

namespace Serotoninja\DevBundle;

use Zend\Mail\Storage\Message as Base;
use Zend\Mime\Part;
use Zend\Mail\Message as Email;

class Message extends Base
{
    /**
     * @param null $type
     * @return Email
     */
    public function getMessage($type = null)
    {
        do {
            if (false !== strpos($this->current()->contenttype, 'text/html')) {
                $currentType = 'text/html';
            } else {
                $currentType = 'text';
            }
        } while ($type && $type != $currentType && $this->countParts() > $this->key() && !$this->next());

        $message = new Email();
        $message->setSubject($this->subject);
        $message->setTo($this->to);
        $message->setFrom($this->from);
        $part = new Part($this->current());
        $body = (string)$part->getContent();
        if ('text/html' == $currentType) {
            $body = quoted_printable_decode($body);
        }
        $message->setBody($body);
        return $message;
    }
}
