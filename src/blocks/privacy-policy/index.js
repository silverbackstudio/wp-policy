/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

/**
 * Internal dependencies
 */
import edit from './edit';
import metadata from './block.json';
import save from './save';

const { name } = metadata;

export { metadata, name };

export const settings = {
	title: __( 'Privacy Policy' ),
	description: __( 'Embeds Privacy Policy' ),
	keywords: [ __( 'privacy' ), __( 'policy' ) ],
	supports: {
        className: false,
        lightBlockWrapper: true,
	},
	...metadata,
	edit,
	save,
};