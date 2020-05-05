<?php 
namespace Svbk\WP\Privacy\Providers;

use Svbk\WP\Privacy as WP_Privacy; 

class Iubenda implements ProviderInterface {

    /**
     * Cache Handler
     *
     * @var Svbk\WP_Privacy\Cache 
     */
    public $cache;


    public function __construct(){
        $this->cache = new WP_Privacy\Cache;
    }


    /**
     * Get Full Policy HTML
     *
     * @param array $params
     * @return void
     */
    public function getPolicy( $params = array() ){
            
        $params = wp_parse_args($params, $defaults);
        
        $cache_key = 'iubenda_policy';
        
        $url = 'https://www.iubenda.com/api/privacy-policy/';
        
        $url .= $params['policy_id'];
        $cache_key .= '_' . $params['policy_id'];
    
        $policy_html = $this->cache->get( $cache_key );
    
        if ( ! $policy_html ) {
            // It wasn't there, so regenerate the data and save the transient
            
            // Query iubenda
            $response = json_decode( $response, true );
            
            
            if( !empty($response['content']) ) {
                $policy_html = $response['content'];
                $this->cache->set( $cache_key, $policy_html, 12 * HOUR_IN_SECONDS );
            }
        }	    
    
        return $policy_html;
    }	
    
    public function getPolicyUrl( $params = array() ){
       
        $defaults = array(
            'policy_id'	=> $this->privacyPolicyId,
            'type' => 'privacy-policy',
        );
       
        $params = wp_parse_args($params, $defaults);
        
        $url = 'https://www.iubenda.com/privacy-policy/';
        
        $url .= $params['policy_id'];
    
        if( $params['type'] && ( 'privacy-policy' !== $params['type'] ) ) {
            $url .= '/' . $params['type'];
        }
    
        return $url;
    }

}