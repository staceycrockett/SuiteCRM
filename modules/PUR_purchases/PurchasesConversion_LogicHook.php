<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class PurchasesConversion_LogicHook
{
    const API_KEY = "e1a4de61d0df08f3921fca5458e5edeb";
    const API_URL = "http://api.exchangeratesapi.io/v1/";

    public function fetchConversions(&$bean, $event, $arguments){
        $priceGBP = $bean->price_gbp_c;
        
        $purchaseDate = new DateTime($bean->date_purchased_c);
        $purchaseDate = $purchaseDate->format('Y-m-d');

        //only free to use base currency is EUR 
        $ch = curl_init(self::API_URL.$purchaseDate.
                            '?access_key='.self::API_KEY.
                            '&base=EUR&'.
                            'symbols=USD,GBP,AUD,NZD');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($json, true);
        $rates = $result['rates'];

        //convert GBP to EUR
        $priceEUR = $priceGBP/$rates['GBP'];
        $bean->price_eur_c = round($priceEUR, 2);
        //use euro price to get other prices
        $bean->price_usd_c = round($priceEUR*$rates['USD'], 2);
        $bean->price_aud_c = round($priceEUR*$rates['AUD'], 2);
        $bean->price_nzd_c = round($priceEUR*$rates['NZD'], 2);
    }

}