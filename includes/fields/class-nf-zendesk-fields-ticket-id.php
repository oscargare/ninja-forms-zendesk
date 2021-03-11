<?php
/**
 * Zendesk Ticket ID field type.
 *
 * This type of field is fill with the ticket ID after submit a ticket.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

class_exists( 'NF_Fields_Hidden' ) || exit;

/**
 * NF_Zendesk_Action class.
 */
class NF_Zendesk_Fields_Ticket_ID extends NF_Abstracts_Field {

	// phpcs:disable PSR2.Classes.PropertyDeclaration.Underscore

	/**
	 * Name.
	 *
	 * @var string
	 */
	protected $_name = 'zd_ticket_id';

	/**
	 * Nicename.
	 *
	 * @var string
	 */
	protected $_nicename = 'Zendesk ticket ID';

	/**
	 * Type.
	 *
	 * @var string
	 */
	protected $_type = 'zd_ticket_id';

	/**
	 * Section.
	 *
	 * @var string
	 */
	protected $_section = 'misc';

	/**
	 * Icon.
	 *
	 * @var string
	 */
	protected $_icon = 'eye-slash';

	/**
	 * Settings only.
	 *
	 * @var array
	 */
	protected $_settings_only = array( 'label', 'key', 'admin_label' );

	/**
	 * Template.
	 *
	 * @var string
	 */
	protected $_templates = 'hidden';

	// phpcs:enable

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->_nicename = esc_html__( 'Zendesk ticket ID', 'nf-zendesk' );
	}

}
