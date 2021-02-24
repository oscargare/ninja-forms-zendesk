<?php
/**
 * The Zendesk API Resource Class
 * Handles a Zendesk API endpoit.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

/**
 * NF_Zendesk_API_Resource class.
 */
class NF_Zendesk_API_Resource {

	/**
	 * API client.
	 *
	 * @var NF_Zendesk_API
	 */
	protected $client;

	/**
	 * Resource URL base.
	 *
	 * @var string
	 */
	protected $base;

	/**
	 * Resource name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Constructor.
	 *
	 * @param NF_Zendesk_API $client Zendesk API client.
	 * @param string         $base Resource base URL.
	 * @param string         $name Resource object name.
	 */
	public function __construct( $client, $base, $name ) {
		$this->client = $client;
		$this->base   = $base;
		$this->name   = $name;
	}

	/**
	 * Create a new resource.
	 *
	 * @param array $data Resource data.
	 * @return stdClass
	 */
	public function create( $data ) {
		return $this->client->http_post(
			$this->base . '.json',
			array(
				$this->name => $data,
			)
		);
	}

	/**
	 * Return all resources.
	 *
	 * @param array $query Query params.
	 * @return array
	 */
	public function get_all( $query = array() ) {
		return $this->client->http_get( $this->base . '.json', $query );
	}

	/**
	 * Return a single resource
	 *
	 * @return stdClass
	 */
	public function get() {
		$data = $this->client->http_get( $this->base . '.json' );
		if ( is_array( $data ) && count( $data ) ) {
			$data = $data[0];
		}
		return $data;
	}
}

