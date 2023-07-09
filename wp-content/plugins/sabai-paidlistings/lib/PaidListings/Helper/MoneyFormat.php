<?php
class Sabai_Addon_PaidListings_Helper_MoneyFormat extends Sabai_Helper
{
    public function help(Sabai $application, $value, $currency, $decimals = 2, $noDecimalsIfEmpty = false, $returnArray = false)
    {
        if (!$decimals || in_array($currency, $application->PaidListings_NonDecimalCurrencies())) {
            $value = number_format($value);
            $decimals = 0;
        } else {
            $value = number_format($value, $decimals);
            if ($noDecimalsIfEmpty && substr($value, -3) === '.00') {
                $value = substr($value, 0, -3);
                $decimals = 0;
            }
        }
        $symbol = $application->PaidListings_Currencies($currency, false);
        $args = array('symbol' => $symbol, 'value' => $value, 'currency' => $currency, 'decimals' => $decimals);
        return $returnArray ? $args : $application->Filter('paidlistings_money_format', $symbol . $value, $args);
    }
}