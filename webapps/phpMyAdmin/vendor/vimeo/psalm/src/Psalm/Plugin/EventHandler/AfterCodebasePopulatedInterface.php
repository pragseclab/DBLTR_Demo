<?php

namespace Psalm\Plugin\EventHandler;

use Psalm\Plugin\EventHandler\Event\AfterCodebasePopulatedEvent;
interface AfterCodebasePopulatedInterface
{
    /**
     * Called after codebase has been populated
     *
     * @return void
     */
    public static function afterCodebasePopulated(AfterCodebasePopulatedEvent $event);
}