<?php
/**
 * Created by PhpStorm.
 * User: Josh Houghtelin <josh@findsomehelp.com>
 * Date: 11/3/14
 * Time: 1:42 PM
 */

foreach ($data as $k => $v) {
    $_GET['search'][$k] = $v;
}
$_GET['search']['NoComplex'] = 1;
$_GET['search']['showall'] = 1;
global $vrp;
$data = json_decode($vrp->search());
$isUR = true;

