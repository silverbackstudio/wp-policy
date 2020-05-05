/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { PanelBody, TextControl } = wp.components;
const {
	InspectorControls
} = wp.editor;


/**
 * Browser dependencies
 */

function PrivacyPolicyBlock({
	attributes,
	setAttributes,
}) {
	const {
		company,
		email,
		phone,
		address
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Policy settings')}>
					<TextControl
						label={__('Company Name')}
						value={company}
						onChange={(value) =>
							setAttributes({ company: value })
						}
					/>
					<TextControl
						label={__('Email')}
						value={email}
						onChange={(value) =>
							setAttributes({ email: value })
						}
					/>
					<TextControl
						label={__('Phone')}
						value={phone}
						onChange={(value) =>
							setAttributes({ phone: value })
						}
					/>
					<TextControl
						label={__('Address')}
						value={address}
						onChange={(value) =>
							setAttributes({ address: value })
						}
					/>
				</PanelBody>
			</InspectorControls>
			<p>Privacy Policy</p>
		</>
	);
}

export default PrivacyPolicyBlock;