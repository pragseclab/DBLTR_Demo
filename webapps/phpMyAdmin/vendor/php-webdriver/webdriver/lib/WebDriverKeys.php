<?php

namespace Facebook\WebDriver;

/**
 * Representations of pressable keys that aren't text.
 * These are stored in the Unicode PUA (Private Use Area) code points.
 * @see https://w3c.github.io/webdriver/#keyboard-actions
 */
class WebDriverKeys
{
    const NULL = "";
    const CANCEL = "";
    const HELP = "";
    const BACKSPACE = "";
    const TAB = "";
    const CLEAR = "";
    const RETURN_KEY = "";
    const ENTER = "";
    const SHIFT = "";
    const CONTROL = "";
    const ALT = "";
    const PAUSE = "";
    const ESCAPE = "";
    const SPACE = "";
    const PAGE_UP = "";
    const PAGE_DOWN = "";
    const END = "";
    const HOME = "";
    const ARROW_LEFT = "";
    const ARROW_UP = "";
    const ARROW_RIGHT = "";
    const ARROW_DOWN = "";
    const INSERT = "";
    const DELETE = "";
    const SEMICOLON = "";
    const EQUALS = "";
    const NUMPAD0 = "";
    const NUMPAD1 = "";
    const NUMPAD2 = "";
    const NUMPAD3 = "";
    const NUMPAD4 = "";
    const NUMPAD5 = "";
    const NUMPAD6 = "";
    const NUMPAD7 = "";
    const NUMPAD8 = "";
    const NUMPAD9 = "";
    const MULTIPLY = "";
    const ADD = "";
    const SEPARATOR = "";
    const SUBTRACT = "";
    const DECIMAL = "";
    const DIVIDE = "";
    const F1 = "";
    const F2 = "";
    const F3 = "";
    const F4 = "";
    const F5 = "";
    const F6 = "";
    const F7 = "";
    const F8 = "";
    const F9 = "";
    const F10 = "";
    const F11 = "";
    const F12 = "";
    const META = "";
    const ZENKAKU_HANKAKU = "\xee\x80\xc0";
    const RIGHT_SHIFT = "";
    const RIGHT_CONTROL = "";
    const RIGHT_ALT = "";
    const RIGHT_META = "";
    const NUMPAD_PAGE_UP = "";
    const NUMPAD_PAGE_DOWN = "";
    const NUMPAD_END = "";
    const NUMPAD_HOME = "";
    const NUMPAD_ARROW_LEFT = "";
    const NUMPAD_ARROW_UP = "";
    const NUMPAD_ARROW_RIGHT = "";
    const NUMPAD_ARROW_DOWN = "";
    const NUMPAD_ARROW_INSERT = "";
    const NUMPAD_ARROW_DELETE = "";
    // Aliases
    const LEFT_SHIFT = self::SHIFT;
    const LEFT_CONTROL = self::CONTROL;
    const LEFT_ALT = self::ALT;
    const LEFT = self::ARROW_LEFT;
    const UP = self::ARROW_UP;
    const RIGHT = self::ARROW_RIGHT;
    const DOWN = self::ARROW_DOWN;
    const COMMAND = self::META;
    /**
     * Encode input of `sendKeys()` to appropriate format according to protocol.
     *
     * @param string|array|int|float $keys
     * @param bool $isW3cCompliant
     * @return array|string
     */
    public static function encode($keys, $isW3cCompliant = false)
    {
        if (is_numeric($keys)) {
            $keys = (string) $keys;
        }
        if (is_string($keys)) {
            $keys = [$keys];
        }
        if (!is_array($keys)) {
            if (!$isW3cCompliant) {
                return [];
            }
            return '';
        }
        $encoded = [];
        foreach ($keys as $key) {
            if (is_array($key)) {
                // handle key modifiers
                $key = implode('', $key) . self::NULL;
                // the NULL clears the input state (eg. previous modifiers)
            }
            $encoded[] = (string) $key;
        }
        if (!$isW3cCompliant) {
            return $encoded;
        }
        return implode('', $encoded);
    }
}