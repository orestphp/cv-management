<?php

/*******************************************************************************
 * FUNCTION FOR TESTING
 * @param mixed
 * @return Array
 *******************************************************************************/
if (! function_exists('tt')) {
    function tt()
    {
        $arrArgs = func_get_args();
        if (!$arrArgs) return false;
        if (isset($arrArgs[1]) && is_array($arrArgs[0]) && !isset($arrArgs[1])) {
            print_r(array($arrArgs[0]));
            exit;
        } else {
            print_r($arrArgs);
            exit;
        }
    }
}
if (! function_exists('ttv')) {
    function ttv()
    {
        $arrArgs = func_get_args();
        if (!$arrArgs) return false;
        if (isset($arrArgs[1]) && is_array($arrArgs[0]) && !isset($arrArgs[1])) {
            var_dump(array($arrArgs[0]));
            exit;
        } else {
            var_dump($arrArgs);
            exit;
        }
    }
}
