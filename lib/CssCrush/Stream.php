<?php
/**
 *
 *  Stream sugar.
 *
 */
namespace CssCrush;

class Stream
{
    public function __construct ($str)
    {
        $this->raw = $str;
    }

    public function __toString ()
    {
        return $this->raw;
    }

    public static function endsWith ($haystack, $needle)
    {
        return substr($haystack, -strlen($needle)) === $needle;
    }

    public function update ($str)
    {
        $this->raw = $str;

        return $this;
    }

    public function substr ($start, $length = null)
    {
        if (! isset($length)) {

            return substr($this->raw, $start);
        }
        else {

            return substr($this->raw, $start, $length);
        }
    }

    public function matchAll ($patt, $offset = 0)
    {
        return Regex::matchAll($patt, $this->raw, $offset);
    }

    public function replace ($find, $replacement)
    {
        $this->raw = str_replace($find, $replacement, $this->raw);

        return $this;
    }

    public function replaceHash ($replacements)
    {
        if ($replacements) {
            $this->raw = str_replace(
                array_keys($replacements),
                array_values($replacements),
                $this->raw);
        }
        return $this;
    }

    public function replaceTokens ($type, $callback = null)
    {
        $tokens =& CssCrush::$process->tokens->store->{ $type };
        $callback = $callback ?: function ($m) use (&$tokens) {
            return isset($tokens[$m[0]]) ? $tokens[$m[0]] : '';
        };

        $this->raw = preg_replace_callback(Regex::make("~\? $type {{token-id}} \?~xS"), $callback, $this->raw);
        return $this;
    }

    public function pregReplace ($patt, $replacement)
    {
        $this->raw = preg_replace($patt, $replacement, $this->raw);
        return $this;
    }

    public function pregReplaceCallback ($patt, $callback)
    {
        $this->raw = preg_replace_callback($patt, $callback, $this->raw);
        return $this;
    }

    public function pregReplaceHash ($replacements)
    {
        if ($replacements) {
            $this->raw = preg_replace(
                array_keys($replacements),
                array_values($replacements),
                $this->raw);
        }
        return $this;
    }

    public function append ($append)
    {
        $this->raw .= $append;
        return $this;
    }

    public function prepend ($prepend)
    {
        $this->raw = $prepend . $this->raw;
        return $this;
    }

    public function splice ($replacement, $offset, $length = null)
    {
        $this->raw = substr_replace($this->raw, $replacement, $offset, $length);
        return $this;
    }

    public function trim ()
    {
        $this->raw = trim($this->raw);
        return $this;
    }

    public function rTrim ()
    {
        $this->raw = rtrim($this->raw);
        return $this;
    }

    public function lTrim ()
    {
        $this->raw = ltrim($this->raw);
        return $this;
    }
}
