<?php
class Sabai_Addon_PaidListings_Helper_Currencies extends Sabai_Helper
{
    static protected $_currencies, $_labels;
    
    /**
     * @param Sabai $application
     */
    public function help(Sabai $application, $currency, $labels = false)
    {
        if (!isset(self::$_currencies)) {
            self::$_currencies = $application->Filter('paidlistings_currencies', array(
                'USD' => '&#36;',
                'BRL' => 'R&#36;',
                'CHF' => '&#67;&#72;&#70;',
                'CNY' => '&#165;',
                'CZK' => '&#75;&#269;',
                'DKK' => '&#107;&#114;',
                'EUR' => '&#8364;',
                'GBP' => '&#163;',
                'HUF' => '&#70;&#116;',
                'IDR' => '&#82;&#112;',
                'INR' => '&#8377;',
                'ILS' => '&#8362;',
                'IRR' => '&#65020;',
                'JPY' => '&#165;',
                'KRW' => '&#8361;',
                'MYR' => '&#82;&#77;',
                'NGN' => '&#8358;',
                'NOK' => '&#107;&#114;',
                'PLN' => '&#122;&#322;',
                'RUB' => '&#8381;',
                'SEK' => '&#107;&#114;',
                'THB' => '&#3647;', 
                'ZAR' => '&#82;',
            ));
        }
        if (!$labels) {
            return isset($currency)
                ? (isset(self::$_currencies[$currency]) ? self::$_currencies[$currency] : '&#36;')
                : self::$_currencies; 
        }
        if (!isset(self::$_labels)) {
            self::$_labels = $application->Filter('paidlistings_currency_labels', array(
                'USD' => __('U.S. Dollar', 'sabai-paidlistings'),
                'AUD' => __('Australian Dollar', 'sabai-paidlistings'),
                'BRL' => __('Brazillian Real', 'sabai-paidlistings'),
                'CAD' => __('Canadian Dollar', 'sabai-paidlistings'),
                'CHF' => __('Swiss Franc', 'sabai-paidlistings'),
                'CNY' => __('Chinese Renminbi Yuan', 'sabai-paidlistings'),
                'CZK' => __('Czech Koruna', 'sabai-paidlistings'),
                'DKK' => __('Danish Krone', 'sabai-paidlistings'),
                'EUR' => __('Euro', 'sabai-paidlistings'),
                'HKD' => __('Hong Kong Dollar', 'sabai-paidlistings'),
                'HUF' => __('Hungarian Forint', 'sabai-paidlistings'),
                'IDR' => __('Indonesian Rupiah', 'sabai-paidlistings'),
                'INR' => __('Indian Rupee', 'sabai-paidlistings'),
                'ILS' => __('Israeli New Sheqel', 'sabai-paidlistings'),
                'IRR' => __('Iranian Rial', 'sabai-paidlistings'),
                'JPY' => __('Japanese Yen', 'sabai-paidlistings'),
                'KRW' => __('South Korean Won', 'sabai-paidlistings'),
                'MXN' => __('Mexican Peso', 'sabai-paidlistings'),
                'MYR' => __('Malaysian Ringgit', 'sabai-paidlistings'),
                'NGN' => __('Nigerian Naira', 'sabai-paidlistings'),
                'NOK' => __('Norwegian Krone', 'sabai-paidlistings'),
                'NZD' => __('New Zealand Dollar', 'sabai-paidlistings'),
                'PLN' => __('Polish Zloty', 'sabai-paidlistings'),
                'GBP' => __('British Pound', 'sabai-paidlistings'),
                'RUB' => __('Russian Ruble', 'sabai-paidlistings'),
                'SEK' => __('Swedish Krona', 'sabai-paidlistings'),
                'SGD' => __('Singapore Dollar', 'sabai-paidlistings'),
                'THB' => __('Thailand Baht', 'sabai-paidlistings'),
                'ZAR' => __('South African Rand', 'sabai-paidlistings'),
            ));
            $format = __('%s (%s)', 'sabai-paidlistings');
            foreach (self::$_labels as $code => $label) {
                self::$_labels[$code] = sprintf($format, $label, isset(self::$_currencies[$code]) ? self::$_currencies[$code] : '&#36;');
            }
        }
        return isset($currency) ? @self::$_labels[$currency] : self::$_labels;
    }
}
