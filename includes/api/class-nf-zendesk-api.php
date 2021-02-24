<?php
/**
 * The Zendesk API Class
 * Handles all the work with the Zendesk API including authentication,
 * ticket creation, listings, etc. Operates via the JSON api.
 *
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;

require_once dirname( __FILE__ ) . '/class-nf-zendesk-api-resource.php';

/**
 * NF_Zendesk_API class.
 */
class NF_Zendesk_API {

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url;

	/**
	 * Basic authorization string.
	 *
	 * @var string
	 */
	protected $auth;

	/**
	 * Array of API resources.
	 *
	 * @var array
	 */
	protected $resources;

	/**
	 * User agent for API request.
	 */
	const USER_AGENT = 'Zendesk Nija Froms';

	/**
	 * Constructor.
	 *
	 * @param string $subdomain Zendesk subdomain.
	 * @param array  $auth array with the email and API token.
	 */
	public function __construct( $subdomain, $auth = false ) {
		$this->api_url   = 'https://' . $subdomain . '.zendesk.com/api/v2/';
		$this->auth      = false;
		$this->resources = array();

		if ( is_array( $auth ) ) {
			$auth = wp_parse_args(
				$auth,
				array(
					'email_address' => '',
					'api_token'     => '',
				)
			);

			$this->auth = base64_encode( $auth['email_address'] . '/token:' . $auth['api_token'] );
		}
	}

	/**
	 * Cache Salts (helper)
	 * Use this function to compose Transient API keys.
	 *
	 * @param string $postfix Cache group.
	 * @return string
	 */
	protected function salt( $postfix ) {
		return 'zd-' . md5( 'zendesk-' . $this->username . $this->api_url . $postfix );
	}

	/**
	 * Retrieve common headers
	 *
	 * @param bool $auth To indicate if the authentication headers are included.
	 * @return array $headers
	 */
	protected function headers( $auth = true ) {
		$headers = array( 'Content-Type' => 'application/json' );
		if ( $auth ) {
			$headers['Authorization'] = 'Basic ' . $this->auth;
		}
		return $headers;
	}

	/**
	 * Parse response.
	 *
	 * @param array $data HTTP reponse data.
	 * @return stdObject|WP_Error
	 */
	protected function parse_response( $data ) {
		if ( is_wp_error( $data ) ) {
			$response = $data;
		} else {
			$body = json_decode( $data['body'] );
			if ( 201 != $data['response']['code'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
				$error_message = isset( $body->error ) ? $body->error : $data['response']['message'];
				$response      = new WP_Error( 'zd_api_error_' . $data['response']['code'], 'Zendesk API: ' . $error_message );
			} else {
				$response = $body;
			}
		}

		return $response;
	}

	/**
	 * API GET
	 *
	 * @param string $endpoint API endpoint.
	 * @param array  $query Array of query params.
	 * @param array  $extra_headers Extra headers.
	 */
	public function http_get( $endpoint, $query = array(), $extra_headers = array() ) {
		$headers    = array_merge( $this->headers(), $extra_headers );
		$target_url = trailingslashit( $this->api_url ) . $endpoint;
		$target_url = add_query_arg( $query, $target_url );
		$result     = wp_remote_get(
			$target_url,
			array(
				'headers'    => $headers,
				'user-agent' => self::USER_AGENT,
			)
		);

		return $this->parse_response( $result );
	}

	/**
	 * API POST
	 *
	 * Similar to the GET method, this function forms the request params as a POST request to the Zendesk API.
	 *
	 * @param string $endpoint API endpoint.
	 * @param array  $post_data Associative array of data.
	 * @param array  $extra_headers Extra headers.
	 */
	public function http_post( $endpoint, $post_data = null, $extra_headers = array() ) {
		$post_data  = wp_json_encode( $post_data );
		$headers    = array_merge( $this->headers(), $extra_headers );
		$target_url = trailingslashit( $this->api_url ) . $endpoint;
		$result     = wp_remote_post(
			$target_url,
			array(
				'redirection' => 0,
				'headers'     => $headers,
				'body'        => $post_data,
				'user-agent'  => self::USER_AGENT,
			)
		);
		return $this->parse_response( $result );
	}

	/**
	 * Returns a resource.
	 *
	 * @param string $base Resource base.
	 * @param string $name Resource name.
	 * @return NF_Zendesk_API_Resource
	 */
	public function get_resource( $base, $name ) {
		if ( isset( $this->resources[ $base ] ) ) {
			return $this->resources[ $base ];
		} else {
			$this->resources[ $base ] = new NF_Zendesk_API_Resource( $this, $base, $name );
		}
		return $this->resources[ $base ];
	}

	/**
	 * Magic method to return resources.
	 *
	 * @param string $method Method name.
	 * @param array  $args Array of arguments.
	 * @throws BadFunctionCallException Wrong resurce.
	 * @return NF_Zendesk_API_Resource
	 */
	public function __call( $method, $args = false ) {
		if ( ! in_array( $method, array( 'requests', 'tickets' ), true ) ) {
			throw new BadFunctionCallException( 'Function ' . $method . ' is not callable' );
		}

		$name  = substr( $method, 0, -1 );
		$base  = $method;
		$base .= ( is_array( $args ) && count( $args ) ? '/' . absint( $args[0] ) : '' );

		return $this->get_resource( $base, $name );
	}

}
