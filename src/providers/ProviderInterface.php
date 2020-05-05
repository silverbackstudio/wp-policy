<?php 

namespace Svbk\WP\Privacy\Providers;

/**
 * Policy Provider Interface
 */
interface ProviderInterface {

    /**
     * Get Full Policy HTML
     *
     * @param string $name      Policy name or identifier (ex. privacy, cookie, ..)
     * @param array  $params    Provider specific parameters
     * @return string           The full policy HTML
     */
    public function getPolicyContent( $name, $params = array() );

    /**
     * Get the list of the available policies
     *
     * @return array           An associative array in the form of handle=>Name
     */
    public function getAvailablePolicies();

}