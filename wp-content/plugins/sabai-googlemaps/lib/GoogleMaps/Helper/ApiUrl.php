<?php
class Sabai_Addon_GoogleMaps_Helper_ApiUrl extends Sabai_Helper
{
    public function help(Sabai $application, $path, array $params, $includeKey = true)
    {
        foreach ($params as $key => $value) {
            $params[$key] = $key . '=' . urlencode($value);
        }
        $path = rtrim($path, '?') . '?' . implode('&', $params);
        $protocol = 'http';
        if ($api_conf = $application->getAddon('GoogleMaps')->getConfig('api')) {
            if ($api_conf['type'] === 'business' && $api_conf['client_id'] && defined('SABAI_GOOGLEMAPS_API_PRIVATE_KEY') && SABAI_GOOGLEMAPS_API_PRIVATE_KEY) {
                $path .= '&client=' . urlencode($api_conf['client_id']);
                $path .= '&signature=' . $this->_getSingature($path, SABAI_GOOGLEMAPS_API_PRIVATE_KEY);
            } elseif ($includeKey && isset($api_conf['key'])) {
                $path .= '&key=' . urlencode($api_conf['key']);
                $protocol = 'https';
            }
        }
        return $protocol . '://maps.googleapis.com' . $path;
    }
    
    protected function _getSingature($path, $privateKey)
    {
        // Decode the private key into its binary format
        $decoded_key = base64_decode(str_replace(array('-', '_'), array('+', '/'), $privateKey));

        // Create a signature using HMAC SHA1. This signature will be binary.
        $signature = hash_hmac('sha1', $path, $decoded_key, true);
        
        // Encode the signature to URL-safe base64
        return str_replace(array('+', '/'), array('-', '_'), base64_encode($signature));
    }
}