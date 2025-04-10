<?php
/**
 * Zendesk action config.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

return array(
	'label'            => array(
		'name'        => 'label',
		'type'        => 'textbox',
		'group'       => 'primary',
		'label'       => esc_html__( 'Action Name', 'ninja-forms-zendesk' ),
		'placeholder' => '',
		'width'       => 'full',
		'value'       => '',
	),
	'active'           => array(
		'name'  => 'active',
		'type'  => 'toggle',
		'label' => esc_html__( 'Active', 'ninja-forms-zendesk' ),
		'value' => 1,
	),
	'zd_subdomain'     => array(
		'name'           => 'zd_subdomain',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Zendesk subdomain', 'ninja-forms-zendesk' ),
		'placeholder'    => esc_attr__( 'Enter your Zendesk subdomain', 'ninja-forms-zendesk' ),
		'width'          => 'full',
		'use_merge_tags' => false,
	),
	'zd_subject'       => array(
		'name'           => 'zd_subject',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Ticket Subject', 'ninja-forms-zendesk' ),
		'placeholder'    => esc_attr__( 'Ticket subject or seach for a field', 'ninja-forms-zendesk' ),
		'width'          => 'full',
		'use_merge_tags' => true,
	),
	'zd_body'          => array(
		'name'           => 'zd_body',
		'type'           => 'rte',
		'group'          => 'primary',
		'label'          => esc_html__( 'Ticket Message', 'ninja-forms-zendesk' ),
		'placeholder'    => '',
		'value'          => '',
		'width'          => 'full',
		'use_merge_tags' => true,
	),
	'zd_name'          => array(
		'name'           => 'zd_name',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Requester Name', 'ninja-forms-zendesk' ),
		'placeholder'    => esc_attr__( 'Requester name or search for a field', 'ninja-forms-zendesk' ),
		'width'          => 'one-half',
		'use_merge_tags' => true,
	),
	'zd_email'         => array(
		'name'           => 'zd_email',
		'type'           => 'textbox',
		'group'          => 'primary',
		'label'          => esc_html__( 'Requester E-mail', 'ninja-forms-zendesk' ),
		'placeholder'    => esc_attr__( 'Requester email or search for a field', 'ninja-forms-zendesk' ),
		'width'          => 'one-half',
		'use_merge_tags' => true,
	),
	'zd_anonymous'     => array(
		'name'  => 'zd_anonymous',
		'type'  => 'toggle',
		'group' => 'advanced',
		'label' => esc_html__( 'Create an anonymous ticket?', 'ninja-forms-zendesk' ),
		'value' => 1,
		'help'  => esc_html__( 'Create the ticket without credentials. Anonymous requests must first be enabled in your Zendesk account.', 'ninja-forms-zendesk' ),
	),
	'zd_auth_user'     => array(
		'name'  => 'zd_auth_user',
		'type'  => 'textbox',
		'group' => 'advanced',
		'label' => esc_html__( 'Zendesk user email', 'ninja-forms-zendesk' ),
		'value' => '',
		'width' => 'one-half',
	),

	'zd_auth_token'    => array(
		'name'  => 'zd_auth_token',
		'type'  => 'textbox',
		'group' => 'advanced',
		'label' => esc_html__( 'Zendesk API token', 'ninja-forms-zendesk' ),
		'value' => '',
		'width' => 'one-half',
	),
	'zd_recipient'     => array(
		'name'           => 'zd_recipient',
		'type'           => 'textbox',
		'group'          => 'advanced',
		'label'          => esc_html__( 'Recipient e-mail address', 'ninja-forms-zendesk' ),
		'placeholder'    => esc_attr__( 'Ticket recipient or seach for a field', 'ninja-forms-zendesk' ),
		'value'          => '',
		'width'          => 'full',
		'use_merge_tags' => true,
		'help'           => esc_html__( 'The original recipient e-mail address of the request.', 'ninja-forms-zendesk' ),
	),
	'zd_custom_fields' => array(
		'name'           => 'zd_custom_fields',
		'type'           => 'option-repeater',
		'label'          => esc_html__( 'Custom Fields', 'ninja-forms-zendesk' ) . ' <a href="#" class="nf-add-new">' . esc_html__( 'Add New', 'ninja-forms-zendesk' ) . '</a>',
		'width'          => 'full',
		'group'          => 'advanced',
		'tmpl_row'       => 'tmpl-nf-zendesk-custom-field-row',
		'value'          => array(),
		'columns'        => array(
			'field_id' => array(
				'header'  => esc_html__( 'Field ID', 'ninja-forms-zendesk' ),
				'default' => '',
			),
			'value'    => array(
				'header'  => esc_html__( 'Value', 'ninja-forms-zendesk' ),
				'default' => '',
			),
		),
		'use_merge_tags' => true,
	),

);
