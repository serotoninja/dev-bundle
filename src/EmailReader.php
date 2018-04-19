<?php

namespace Serotoninja\DevBundle;

class EmailReader
{
    /** @var string */
    public const EXTENSION = '.eml';

    /** @var string */
    protected $dir;

    /**
     * EmailReader constructor.
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return array
     */
    public function getAllEmails() : array
    {
        return glob($this->dir . '/*' . self::EXTENSION);
    }

    /**
     * @param $filename
     * @return Message
     */
    public function getEmail($filename) : Message
    {
        return new Message(['file' => $filename]);
    }

    public function clear()
    {
        foreach ($this->getAllEmails() as $fileName) {
            @unlink($fileName);
        }
    }
} 
