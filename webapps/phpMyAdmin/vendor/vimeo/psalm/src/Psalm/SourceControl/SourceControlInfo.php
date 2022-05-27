<?php

namespace Psalm\SourceControl;

abstract class SourceControlInfo
{
    public abstract function toArray() : array;
}