<?php
namespace Serotoninja\DevBundle\Swift\Transport;

use Swift_Transport_MailInvoker;
use Swift_Events_EventDispatcher;
use Swift_Events_EventListener;
use Swift_Mime_Message;
use Swift_Transport;
use Exception;
use Serotoninja\DevBundle\EmailReader;

class FileTransport implements Swift_Transport
{
    /**
     * The event dispatcher from the plugin API
     *
     * @var Swift_Events_EventDispatcher
     */
    private $eventDispatcher;

    /**
     * Not in use
     *
     * @var mixed An invoker that calls the mail() function
     */
    private $invoker;

    /**
     * @var string
     */
    protected $dir;

    /**
     * Create a new FileTransport with the $log.
     *
     * @param Swift_Transport_MailInvoker  $invoker
     * @param Swift_Events_EventDispatcher $eventDispatcher
     */
    public function __construct(Swift_Transport_MailInvoker $invoker, Swift_Events_EventDispatcher $eventDispatcher)
    {
        $this->invoker = $invoker;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Not used.
     */
    public function isStarted()
    {
        return false;
    }

    /**
     * Not used.
     */
    public function start()
    {
    }

    /**
     * Not used.
     */
    public function stop()
    {
    }

    /**
     * Send the given Message.
     *
     * Recipient/sender data will be retreived from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
     * @param Swift_Mime_Message $message
     * @param string[] &$failedRecipients to collect failures by-reference
     *
     * @throws Exception
     *
     * @return int
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $failedRecipients = (array)$failedRecipients;

        if ($evt = $this->eventDispatcher->createSendEvent($this, $message)) {
            $this->eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
            if ($evt->bubbleCancelled()) {
                return 0;
            }
        }

        $count = (
            count((array)$message->getTo())
                + count((array)$message->getCc())
                + count((array)$message->getBcc())
        );

        $toHeader = $message->getHeaders()->get('To');
        $subjectHeader = $message->getHeaders()->get('Subject');

        $subject = $subjectHeader->getFieldBody();

        //Remove headers that would otherwise be duplicated
        $message->getHeaders()->remove('Subject');

        $messageStr = $message->toString();

        $message->getHeaders()->set($toHeader);
        $message->getHeaders()->set($subjectHeader);

        //Separate headers from body
        if (false !== $endHeaders = strpos($messageStr, "\r\n\r\n")) {
            $headers = substr($messageStr, 0, $endHeaders) . "\r\n"; //Keep last EOL
            $body = substr($messageStr, $endHeaders + 4);
        } else {
            $headers = $messageStr . "\r\n";
            $body = '';
        }

        unset($messageStr);

        if ("\r\n" != PHP_EOL) { //Non-windows (not using SMTP)
            $headers = str_replace("\r\n", PHP_EOL, $headers);
            $body = str_replace("\r\n", PHP_EOL, $body);
        } else { //Windows, using SMTP
            $headers = str_replace("\r\n.", "\r\n..", $headers);
            $body = str_replace("\r\n.", "\r\n..", $body);
        }

        if (!is_dir($this->dir)) {
            $path = '';
            foreach (explode(DIRECTORY_SEPARATOR, substr($this->dir, 1)) as $pathDir) {
                $path .= DIRECTORY_SEPARATOR . $pathDir;
                if (!is_dir($path)) {
                    @mkdir($path);
                    @chmod($path, 0777);
                }
            }
        }

        $base = $this->dir . DIRECTORY_SEPARATOR . date('Y-m-d_H:i:s');
        $i = 1;
        while (true) {
            $fileName = sprintf('%s-%s%s',$base, $i, EmailReader::EXTENSION);
            if (is_file($fileName)) {
                $i++;
            } else {
                break;
            }
        }

        $fOut = fopen($fileName, "w");
        if (!$fOut) {
            throw new Exception("Cant open file {$fileName} for writing");
        }

        fwrite($fOut, $headers);
        fwrite($fOut, "Subject: " . $subject);
        fwrite($fOut, "\n\n");
        fwrite($fOut, $body);

        fclose($fOut);

        @chmod($fileName, 0777);

        return $count;
    }

    /**
     * Register a plugin.
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->eventDispatcher->bindEventListener($plugin);
    }
}
