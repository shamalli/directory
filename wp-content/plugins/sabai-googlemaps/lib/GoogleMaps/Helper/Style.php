<?php
class Sabai_Addon_GoogleMaps_Helper_Style extends Sabai_Helper
{
    /**
     * @param Sabai $application
     * @param string $style
     */
    public function help(Sabai $application, $style = null, $url = false)
    {
        if (!$styles = $application->getPlatform()->getCache('googlemaps_styles')) {
            $styles = array('Red' => null, 'Blue' => null, 'Greyscale' => null, 'Night' => null, 'Sepia' => null, 'Chilled' => null,
                'Mixed' => null, 'Pale Dawn' => null, 'Apple Maps-esque' => null, 'Paper' => null, 'Hot Pink' => null, 'Flat Map' => null,
                'Subtle' => null, 'Light Monochrome' => null, 'Bright and Bubbly' => null, 'Clean Grey' => null,
            );
            $styles = $application->Filter('googlemaps_styles', $styles);
            ksort($styles);
            $application->getPlatform()->setCache($styles, 'googlemaps_styles');
        }

        if (!isset($style)) return array_combine(array_keys($styles), array_keys($styles));
            
        $file = isset($styles[$style]) ? $styles[$style] : 'sabai-googlemaps-map-style-' . str_replace(' ', '-', strtolower($style)) . '.min.js';

        if (!$url) return $file;
        
        return strpos($file, 'http') === 0 ? $file : $application->JsUrl($file, 'sabai-googlemaps');
    }
}