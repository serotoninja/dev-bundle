<?php

namespace Serotoninja\DevBundle;

/**
 * Class Str
 *
 * @package Serotoninja\DevBundle
 *
 * @author serotoninja <serotoninja@gmail.com>
 * @since 2018-04-14
 */
final class Str
{
    private static $validCodeTypes = ['php', 'yml', 'yaml', 'xml', 'bash'];

    /**
     * @param string $value
     * @return string
     */
    public static function asHashAnchor(string $value): string
    {
        $value = strtolower($value);
        $value = '#' . str_replace(' ', '-', $value);
        return $value;
    }

    /**
     * @param string $value
     * @return string
     */
    public static function handleCode(string $value): string
    {
        $result = '```';
        if (strpos($value, PHP_EOL) !== false) {
            $lines = explode(PHP_EOL, $value);
            if (in_array(trim($lines[0]), self::$validCodeTypes)) {
                $result .= trim($lines[0]) . PHP_EOL;
                array_shift($lines);
            }
            $result .= implode(PHP_EOL, $lines);
        } else {
            $result .= $value;
        }
        $result .= '```' . PHP_EOL;
        return $result;
    }
}
