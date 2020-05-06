<?php 
namespace Svbk\WP\Privacy\Providers;

use Svbk\WP\Privacy as WP_Privacy; 

class File implements ProviderInterface {

    /**
     * Get Full Policy HTML
     *
     * @param string $name      Policy name or identifier (ex. privacy, cookie, ..)
     * @param array  $params    Provider specific parameters
     * @return string           The full policy HTML
     */
    public function getPolicyContent( $name = 'privacy-policy', $params = array() ){

            if ( !array_key_exists( $name, $this->getAvailablePolicies() ) ) {
                return '';
            }
            
            $folder = __DIR__ . DIRECTORY_SEPARATOR . 'static-policies' . DIRECTORY_SEPARATOR;
            $filename =  $name . '.html';

            $lang_folder = !empty($params['language']) ? ($params['language'] . DIRECTORY_SEPARATOR) : '';

            if ( \file_exists( $folder .  $lang_folder . $filename ) ) {
                $content = \file_get_contents(  $folder  .  $lang_folder . DIRECTORY_SEPARATOR . $filename );
            } else if( \file_exists(  $folder . $filename ) ) {
                $content = \file_get_contents(  $folder . $filename );
            } else {
                return '';
            }
            
            $search = array_map( array( self::class, 'paramPlaceholder' ) , array_keys($params));
            $replace = array_values($params);

            return str_replace( $search, $replace, $content );
    }	

    /**
     * Get the list of the available policies
     *
     * @return array           An associative array in the form of handle=>Name
     */
    public function getAvailablePolicies(){
        return array(
            'privacy-policy' => __('Privacy Policy', 'svbk-wp-privacy'),
            'cookie-policy' => __('Cookie Policy', 'svbk-wp-privacy'),
        );
    }    

    /**
     * Wraps param in it's placeholder
     *
     * @param string $name 	Attribute name
     * @return void
     */
    protected static function paramPlaceholder($param){
        return '{{' . $param . '}}';
    }

}