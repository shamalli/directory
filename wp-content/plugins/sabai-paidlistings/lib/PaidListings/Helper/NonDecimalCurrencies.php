<?php
class Sabai_Addon_PaidListings_Helper_NonDecimalCurrencies extends Sabai_Helper
{    
    public function help(Sabai $application)
    {
        return array('BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'VND', 'VUV', 'XAF', 'XOF', 'XPF');
    }
}