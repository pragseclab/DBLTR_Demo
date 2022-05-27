<?php

use Vendor\Package\{ClassA as A, ClassB, ClassC as C};
use Vendor\Package\SomeNamespace\ClassD as D;
use Vendor\Package\AnotherNamespace\ClassE as E;
use function Vendor\Package\{functionA, functionB, functionC};
use function Another\Vendor\functionD;
use const Vendor\Package\{CONSTANT_A, CONSTANT_B, CONSTANT_C};
use const Another\Vendor\CONSTANT_D;
class ClassName3
{
    use \FirstTrait;
    use SecondTrait;
    use ThirdTrait;
}
$foo = function () use($bar) {
};