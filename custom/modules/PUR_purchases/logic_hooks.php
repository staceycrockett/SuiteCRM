<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 

$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = 
    Array(
        77, 
        'fetchConversions', 
        'modules/PUR_purchases/PurchasesConversion_LogicHook.php',
        'PurchasesConversion_LogicHook',
        'fetchConversions'
    ); 
