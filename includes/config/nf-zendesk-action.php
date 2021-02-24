<?php
/**
 * Zendesk action config.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

return array(
	'zd_subdomain'     => array(
		'name'           => 'zd_subdomain',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Zendesk subdomain', 'nf-zendesk' ),
		'placeholder'    => esc_attr__( 'Enter your Zendesk subdomain', 'nf-zendesk' ),
		'width'          => 'full',
		'use_merge_tags' => false,
	),
	'zd_subject'       => array(
		'name'           => 'zd_subject',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Ticket Subject', 'nf-zendesk' ),
		'placeholder'    => esc_attr__( 'Ticket subject or seach for a field', 'nf-zendesk' ),
		'width'          => 'full',
		'use_merge_tags' => true,
	),
	'zd_body'          => array(
		'name'           => 'zd_body',
		'type'           => 'rte',
		'group'          => 'primary',
		'label'          => esc_html__( 'Ticket Message', 'nf-zendesk' ),
		'placeholder'    => '',
		'value'          => '',
		'width'          => 'full',
		'use_merge_tags' => true,
	),
	'zd_name'          => array(
		'name'           => 'zd_name',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Requester Name', 'nf-zendesk' ),
		'placeholder'    => esc_attr__( 'Requester name or search for a field', 'nf-zendesk' ),
		'width'          => 'one-half',
		'use_merge_tags' => true,
	),
	'zd_email'         => array(
		'name'           => 'zd_email',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Requester E-mail', 'nf-zendesk' ),
		'placeholder'    => esc_attr__( 'Requester email or search for a field', 'nf-zendesk' ),
		'width'          => 'one-half',
		'use_merge_tags' => true,
	),
	'zd_recipient'     => array(
		'name'           => 'zd_recipient',
		'type'           => 'textbox',
		'group'          => 'advanced',
		'label'          => esc_html__( 'Recipient e-mail address', 'nf-zendesk' ),
		'placeholder'    => esc_attr__( 'Ticket recipient or seach for a field', 'nf-zendesk' ),
		'value'          => '',
		'width'          => 'full',
		'use_merge_tags' => true,
		'help'           => esc_html__( 'The original recipient e-mail address of the request.', 'nf-zendesk' ),
	),
	'zd_custom_fields' => array(
		'name'           => 'zd_custom_fields',
		'type'           => 'option-repeater',
		'label'          => esc_html__( 'Custom Fields', 'nf-zendesk' ) . ' <a href="#" class="nf-add-new">' . esc_html__( 'Add New', 'nf-zendesk' ) . '</a>',
		'width'          => 'full',
		'group'          => 'advanced',
		'tmpl_row'       => 'tmpl-nf-zendesk-custom-field-row',
		'value'          => array(),
		'columns'        => array(
			'field_id' => array(
				'header'  => esc_html__( 'Field ID', 'nf-zendesk' ),
				'default' => '',
			),
			'value'    => array(
				'header'  => esc_html__( 'Value', 'nf-zendesk' ),
				'default' => '',
			),
		),
		'use_merge_tags' => true,
	),

);
