/**
 * WordPress dependencies
 */
const {
	registerBlockType
} = wp.blocks;

/**
 * Internal dependencies
 */
import * as privacyPolicy from './privacy-policy';
import * as cookiePolicy from './cookie-policy';


/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}
    const { settings, name } = block;
	
	registerBlockType( name, settings );
};

/**
 * Function to register core blocks provided by the block editor.
 *
 * @example
 * ```js
 * import { registerCoreBlocks } from '@wordpress/block-library';
 *
 * registerCoreBlocks();
 * ```
 */
[
	// Common blocks are grouped at the top to prioritize their display
	// in various contexts — like the inserter and auto-complete components.
	privacyPolicy,
	cookiePolicy,
].forEach( registerBlock );

