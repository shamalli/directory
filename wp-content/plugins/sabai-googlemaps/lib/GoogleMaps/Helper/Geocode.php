<?php
class Sabai_Addon_GoogleMaps_Helper_Geocode extends Sabai_Helper
{
    /**
     * @param Sabai $application
     * @param string $query
     * @param bool $latlng
     * @throw Sabai_RuntimeException
     */
    public function help(Sabai $application, $query, $latlng = false, array $params = array())
    {
        $query = trim($query);
        $hash = md5(serialize(array($query, $latlng, $params)));
        if ((!$cache = $application->getPlatform()->getCache('googlemaps_geocode'))
            || !isset($cache[$hash])
        ) {
            // Init cache
            if (!is_array($cache)) {
                $cache = array();
            } else {
                if (count($cache) > 100) {
                    array_shift($cache);
                }
            }
            // Append to cache
            $cache[$hash] = $application->GoogleMaps_GoogleGeocode($query, $latlng, $params);
            $application->getPlatform()->setCache($cache, 'googlemaps_geocode');
        }
        return $cache[$hash];
    }
}
