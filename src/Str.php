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
    /**
     * @param string $value
     * @return string
     */
    public static function asHashAnchor(string $value): string
    {
        $value = strtolower($value);
        $value = str_replace(' ', '-', $value);
        return $value;
    }
}
