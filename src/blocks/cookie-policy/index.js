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
	title: __( 'Cookie Policy' ),
	description: __( 'Embeds Cookie Policy' ),
	keywords: [ __( 'cookie' ), __( 'policy' ) ],
	supports: {
        className: false,
        lightBlockWrapper: true,
	},
	...metadata,
	edit,
	save,
};