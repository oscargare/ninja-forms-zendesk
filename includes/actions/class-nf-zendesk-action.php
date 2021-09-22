<?php
/**
 * Zendesk Action. Create a new Zendeks ticket.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

class_exists( 'NF_Abstracts_Action' ) || exit;

/**
 * NF_Zendesk_Action class.
 */
final class NF_Zendesk_Action extends NF_Abstracts_Action {

	// phpcs:disable PSR2.Classes.PropertyDeclaration.Underscore

	/**
	 * Unique slug used to identify the action type
	 *
	 * @var string
	 */
	protected $_name = 'zendesk';

	/**
	 * Array of keywords
	 *
	 * @var array
	 */
	protected $_tags = array();

	/**
	 * Processing after early actions.
	 *
	 * @var string
	 */
	protected $_timing = 'normal';

	/**
	 * Action priority.
	 *
	 * @var int
	 */
	protected $_priority = 10;

	// phpcs:enable

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();

		$settings = NF_Zendesk::config( 'zendesk_action' );

		$this->_nicename = __( 'Zendesk', 'ninja-forms-zendesk' );
		$this->_settings = array_merge( $this->_settings, $settings );
	}

	/**
	 * Process the form.
	 *
	 * @param array  $action_settings Action settings.
	 * @param string $form_id Form ID.
	 * @param array  $data Data.
	 */
	public function process( $action_settings, $form_id, $data ) {
		$errors    = array();
		$subdomain = sanitize_text_field( $action_settings['zd_subdomain'] );
		$auth      = false;

		if ( ! $subdomain ) {
			$errors['zd_no_subdomain'] = esc_html__( 'The Zendesk subdomain has not been set!', 'ninja-forms-zendesk' );
		} elseif ( empty( $action_settings['zd_anonymous'] ) && ( empty( $action_settings['zd_auth_user'] ) || empty( $action_settings['zd_auth_token'] ) ) ) {
			$errors['zd_empty_auth'] = esc_html__( 'The Zendesk credentials has not been set!', 'ninja-forms-zendesk' );
		} else {

			if ( empty( $action_settings['zd_anonymous'] ) ) {
				$auth = array(
					'email_address' => sanitize_email( $action_settings['zd_auth_user'] ),
					'api_token'     => sanitize_text_field( $action_settings['zd_auth_token'] ),
				);
			}

			$ticket = array(
				'subject'   => sanitize_text_field( $action_settings['zd_subject'] ),
				'comment'   => array(
					'html_body' => wpautop( sanitize_textarea_field( $action_settings['zd_body'] ) ),
				),
				'requester' => array(
					'name'  => sanitize_text_field( $action_settings['zd_name'] ),
					'email' => sanitize_email( $action_settings['zd_email'] ),
				),
			);

			if ( $action_settings['zd_recipient'] ) {
				$ticket['recipient'] = sanitize_email( $action_settings['zd_recipient'] );
			}

			if ( count( $action_settings['zd_custom_fields'] ) ) {
				$ticket['custom_fields'] = array();

				foreach ( $action_settings['zd_custom_fields'] as $custom_field ) {

					$ticket['custom_fields'][] = array(
						'id'    => $custom_field['field_id'],
						'value' => sanitize_text_field( $custom_field['value'] ),
					);
				}
			}

			/**
			 * Allow 3rdparty developers to modify the ticket before create it.
			 */
			$ticket = apply_filters( 'nf_zendesk_action_ticket_data', $ticket, $action_settings, $data );

			// Make clickable the URLs before create the ticket.
			$ticket['comment']['html_body'] = make_clickable( $ticket['comment']['html_body'] );

			// Create the ticket via API.
			$client = new NF_Zendesk_API( $subdomain, $auth );
			$result = $client->requests()->create( $ticket );

			// Register errors.
			if ( is_wp_error( $result ) ) {
				$errors[ $result->get_error_code() ] = $result->get_error_message();
			}

			// Set the ticket ID.
			if ( isset( $data['fields'] ) && is_array( $data['fields'] ) ) {
				foreach ( $data['fields'] as $field_id => $field ) {
					if ( isset( $field['type'] ) && 'zd_ticket_id' === $field['type'] ) {
						$data['fields'][ $field_id ]['value'] = is_wp_error( $result ) ? 'Error: ' . $result->get_error_message() : $result->id;
						break;
					}
				}
			}

			/**
			 * Ticket created.
			 */
			do_action( 'nf_zendesk_action_ticket_created', $result, $action_settings, $data, $client );
		}

		if ( count( $errors ) ) {
			$data['errors']         = isset( $data['errors'] ) && is_array( $data['errors'] ) ? $data['errors'] : array();
			$data['errors']['form'] = isset( $data['errors']['form'] ) && is_array( $data['errors']['form'] ) ? $data['errors']['form'] : array();

			if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
				$data['errors']['form'] += $errors;
			} else {
				$data['errors']['form']['zd_user_error'] = __( 'A new ticket could not be created at this time, please try again later.', 'ninja-forms-zendesk' );
			}
		}

		return $data;
	}
}
