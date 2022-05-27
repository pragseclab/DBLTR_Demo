<?php

function test()
{
    $string = 'hello';
    $string = 'hello';
    // Set string to hello.
    // Valid comment.
}
function testing()
{
}
//end test()
class TestClass
{
    public $good = true;
    // Indeed.
}
//end class
if (true || -1 == $b) {
    /* test */
}
$y = 10 + -2;
$a = function () {
};
//end closure
$array = [
    function ($a) {
    },
    // phpcs:ignore Standard.Category.SniffName -- for reasons.
    'key' => function ($b) {
    },
    // comment.
    'key' => 'value',
    // phpcs:ignore Standard.Category.SniffName -- for reasons.
    'key' => 'value',
];
// Verify that multi-line control structure with comments and annotations are left alone.
for ($i = 0; $i < 10; $i++) {
}
if ($condition === true && $anotherCondition === false) {
}