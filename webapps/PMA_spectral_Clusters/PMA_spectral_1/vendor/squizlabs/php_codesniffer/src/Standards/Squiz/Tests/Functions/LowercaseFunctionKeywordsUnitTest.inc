<?php

// Correct.
function Foo()
{
}
$a = function () {
};
abstract class Foo
{
    public function PublicFunction()
    {
    }
    private function PrivateFunction()
    {
    }
    protected function ProtectedFunction()
    {
    }
    static function StaticFunction()
    {
    }
    protected abstract function AbstractProtectedFunction();
    public static final function FinalStaticPublicFunction()
    {
    }
}
// Incorrect.
function Bar()
{
}
$a = function () {
};
abstract class Bar
{
    public function PublicFunction()
    {
    }
    private function PrivateFunction()
    {
    }
    protected function ProtectedFunction()
    {
    }
    static function StaticFunction()
    {
    }
    protected abstract function AbstractProtectedFunction();
    public static final function FinalStaticPublicFunction()
    {
    }
}
$a = fn($x) => $x;