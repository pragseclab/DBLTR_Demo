<?php

if (isset($param)) {
    ?>
   <h3>some text</h3>
<?php 
}
if (($condition1 || $condition2) && $condition3 && $condition4 && $condition5) {
}
if (($condition1 || $condition2) && $condition3 && $condition4 && $condition5) {
}
if (($condition1 || $condition2) && $condition3) {
}
if (($condition1 || $condition2) && $condition3) {
}
if ($condition1 || $condition2) {
}
if (($condition1 || $condition2) && $condition3 && $condition4) {
}
if (($condition1 || $condition2) && $condition3 && $condition4 && $condition5) {
}
if ($condition1 || $condition2) {
}
if ($condition1 || $condition2) {
}
if (($condition1 || $condition2) && $condition3) {
}
if ($condition1 || $condition2 || $condition3) {
}
if ($condition1 || $condition2 || $condition3) {
} else {
    if ($condition1 || $condition2 || $condition3) {
    }
}
if ($condition1 || $condition2 || $condition3) {
} elseif ($condition1 || $condition2 && $condition3) {
}
if ($condition1 || $condition2 || $condition3) {
}
if ($condition1 || $condition2 || $condition3) {
}
if ($condition1) {
    echo 'bar';
}
if ($condition1 || $condition2 || $condition3) {
    echo 'bar';
}
if ($condition1 || $condition2 || $condition3) {
    echo 'bar';
}
if (!empty($post) && (!empty($context['header']) xor stripos($context['header'], 'Content-Type'))) {
    // ...
}
if ($foo) {
    echo 'bar';
}
// Should be no errors even though lines are
// not exactly aligned together. Multi-line function
// call takes precedence.
if (array_key_exists($key, $value) && array_key_exists($key, $value2)) {
}
if (true) {
    $foo = true;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    /* long comment
         here
       */
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    // long comment here
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    return false;
}
function bar()
{
    if ($a && $b) {
        return false;
    }
}
if ($a && foo('a', 'b')) {
    return false;
}
foreach ($blah as $boo) {
    ?>
    <?php 
    if ($foo) {
        ?>
        <?php 
        if ($bar) {
        } else {
        }
        ?>
    <?php 
    }
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    /*
      phpcs:ignore Standard.Category.Sniff -- for reasons.
    */
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    // phpcs:enable
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() == 3200) {
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() === 'someverylongexpectedoutput') {
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() === 'someverylongexpectedoutput') {
    return false;
}
if ($IPP->errorCode() == 401 || $IPP->errorCode() === 'someverylongexpectedoutput') {
    return false;
}