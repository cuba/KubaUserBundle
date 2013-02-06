<?php

namespace Kuba\UserBundle\Utilities;

class TextUtilities
{
    /**
     * Canonicalizes a string.
     */
    static public function canonicalize($text)
    {
        // lowercase
        $text = strtolower($text);
        return $text;
    } 
}