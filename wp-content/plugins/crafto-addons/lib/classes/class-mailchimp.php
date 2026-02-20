<?php
/**
 * Super-simple, minimum abstraction MailChimp API v3 wrapper
 * MailChimp API v3: http://developer.mailchimp.com
 * This wrapper: https://github.com/drewm/mailchimp-api
 *
 * @author  Drew McLellan <drew.mclellan@gmail.com>
 * @version 2.5
 */
class Crafto_MailChimp {
	private $api_key;
	private $api_endpoint = 'https://<dc>.api.mailchimp.com/3.0';

	const TIMEOUT = 10;

	/**
	 * SSL Verification
	 * Read before disabling:
	 * http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/
	 */
	public $verify_ssl = true;

	private $request_successful = false;
	private $last_error         = '';
	private $last_response      = [];
	private $last_request       = [];

	/**
	 * Create a new instance
	 *
	 * @param string $api_key Your MailChimp API key.
	 * @param string $api_endpoint Optional custom API endpoint.
	 * @throws \Exception If post support is missing.
	 */
	public function __construct( $api_key, $api_endpoint = null ) {
		if ( ! function_exists( 'curl_init' ) || ! function_exists( 'curl_setopt' ) ) {
			throw new \Exception( "cURL support is required, but can't be found." );
		}

		$this->api_key = $api_key;

		if ( null === $api_endpoint ) {
			if ( strpos( $this->api_key, '-' ) === false ) {
				throw new \Exception( 'Invalid MailChimp API key supplied.' );
			}
			list( , $data_center ) = explode( '-', $this->api_key );
			$this->api_endpoint    = str_replace( '<dc>', $data_center, $this->api_endpoint );
		} else {
			$this->api_endpoint = $api_endpoint;
		}

		$this->last_response = [
			'headers' => null,
			'body'    => null,
		];
	}

	/**
	 * @return string The url to the API endpoint
	 */
	public function get_api_endpoint() {
		return $this->api_endpoint;
	}

	/**
	 * Convert an email address into a 'subscriber hash' for identifying the subscriber in a method URL
	 *
	 * @param string $email The subscriber's email address.
	 *
	 * @return string Hashed version of the input
	 */
	public function subscriber_hash( $email ) {
		return md5( strtolower( $email ) );
	}

	/**
	 * Was the last request successful?
	 *
	 * @return bool True for success, false for failure
	 */
	public function success() {
		return $this->request_successful;
	}

	/**
	 * Get the last error returned by either the network transport, or by the API.
	 * If something didn't work, this should contain the string describing the problem.
	 *
	 * @return  string|false describing the error
	 */
	public function get_last_error() {
		return $this->last_error ? '' : false;
	}

	/**
	 * Get an array containing the HTTP headers and the body of the API response.
	 *
	 * @return array  Assoc array with keys 'headers' and 'body'
	 */
	public function get_last_response() {
		return $this->last_response;
	}

	/**
	 * Get an array containing the HTTP headers and the body of the API request.
	 *
	 * @return array  Assoc array
	 */
	public function get_last_request() {
		return $this->last_request;
	}

	/**
	 * Make an HTTP DELETE request - for deleting data
	 *
	 * @param   string $method  URL of the API request method.
	 * @param   array  $args    Assoc array of arguments (if any).
	 * @param   int    $timeout Timeout limit for request in seconds.
	 *
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function delete( $method, $args = [], $timeout = self::TIMEOUT ) {
		return $this->make_request( 'delete', $method, $args, $timeout );
	}

	/**
	 * Make an HTTP GET request - for retrieving data
	 *
	 * @param   string $method  URL of the API request method.
	 * @param   array  $args    Assoc array of arguments (usually your data).
	 * @param   int    $timeout Timeout limit for request in seconds.
	 *
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function get( $method, $args = [], $timeout = self::TIMEOUT ) {
		return $this->make_request( 'get', $method, $args, $timeout );
	}

	/**
	 * Make an HTTP PATCH request - for performing partial updates
	 *
	 * @param   string $method  URL of the API request method.
	 * @param   array  $args    Assoc array of arguments (usually your data).
	 * @param   int    $timeout Timeout limit for request in seconds.
	 *
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function patch( $method, $args = [], $timeout = self::TIMEOUT ) {
		return $this->make_request( 'patch', $method, $args, $timeout );
	}

	/**
	 * Make an HTTP POST request - for creating and updating items
	 *
	 * @param   string $method  URL of the API request method.
	 * @param   array  $args    Assoc array of arguments (usually your data).
	 * @param   int    $timeout Timeout limit for request in seconds.
	 *
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function post( $method, $args = [], $timeout = self::TIMEOUT ) {
		return $this->make_request( 'post', $method, $args, $timeout );
	}

	/**
	 * Make an HTTP PUT request - for creating new items
	 *
	 * @param   string $method  URL of the API request method.
	 * @param   array  $args    Assoc array of arguments (usually your data).
	 * @param   int    $timeout Timeout limit for request in seconds.
	 *
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function put( $method, $args = [], $timeout = self::TIMEOUT ) {
		return $this->make_request( 'put', $method, $args, $timeout );
	}

	/**
	 * Performs the underlying HTTP request. Not very exciting.
	 *
	 * @param    string $http_verb The HTTP verb to use: get, post, put, patch, delete.
	 * @param    string $method The API method to be called.
	 * @param    array  $args Assoc array of parameters to be passed.
	 * @param    int    $timeout timeout.
	 *
	 * @return array|false Assoc array of decoded result
	 */
	private function make_request( $http_verb, $method, $args = [], $timeout = self::TIMEOUT ) {
		$url = $this->api_endpoint . '/' . $method;

		$response = $this->prepare_state_for_request( $http_verb, $method, $url, $timeout );

		$http_header = array(
			'Accept: application/vnd.api+json',
			'Content-Type: application/vnd.api+json',
			'Authorization: apikey ' . $this->api_key,
		);

		if ( isset( $args['language'] ) ) {
			$http_header[] = 'Accept-Language: ' . $args['language'];
		}

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $http_header );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'DrewM/MailChimp-API/3.0 (github.com/drewm/mailchimp-api)' );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_VERBOSE, true );
		curl_setopt( $ch, CURLOPT_HEADER, true );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl );
		curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
		curl_setopt( $ch, CURLOPT_ENCODING, '' );
		curl_setopt( $ch, CURLINFO_HEADER_OUT, true );

		switch ( $http_verb ) {
			case 'post':
				curl_setopt( $ch, CURLOPT_POST, true );
				$this->attach_request_payload( $ch, $args );
				break;

			case 'get':
				$query = http_build_query( $args, '', '&' );
				curl_setopt( $ch, CURLOPT_URL, $url . '?' . $query );
				break;

			case 'delete':
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
				break;

			case 'patch':
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PATCH' );
				$this->attach_request_payload( $ch, $args );
				break;

			case 'put':
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
				$this->attach_request_payload( $ch, $args );
				break;
		}

		$response_content    = curl_exec( $ch );
		$response['headers'] = curl_getinfo( $ch );
		$response            = $this->set_response_state( $response, $response_content, $ch );
		$formatted_response  = $this->format_response( $response );

		curl_close( $ch );

		$is_success = $this->determine_success( $response, $formatted_response, $timeout );

		return is_array( $formatted_response ) ? $formatted_response : $is_success;
	}

	/**
	 * @param string  $http_verb http verb.
	 * @param string  $method method.
	 * @param string  $url url.
	 * @param integer $timeout timeout.
	 *
	 * @return array
	 */
	private function prepare_state_for_request( $http_verb, $method, $url, $timeout ) {
		$this->last_error = '';

		$this->request_successful = false;

		$this->last_response = [
			'headers'     => null,
			'httpHeaders' => null,
			'body'        => null,
		];

		$this->last_request = [
			'method'  => $http_verb,
			'path'    => $method,
			'url'     => $url,
			'body'    => '',
			'timeout' => $timeout,
		];

		return $this->last_response;
	}

	/**
	 * Get the HTTP headers as an array of header-name => header-value pairs.
	 *
	 * The "Link" header is parsed into an associative array based on the
	 * rel names it contains. The original value is available under
	 * the "_raw" key.
	 *
	 * @param string $headers_as_string header as string.
	 *
	 * @return array
	 */
	private function get_headers_as_array( $headers_as_string ) {
		$headers = [];

		foreach ( explode( "\r\n", $headers_as_string ) as $i => $line ) {
			if ( $i === 0 ) {
				continue;
			}

			$line = trim( $line );
			if ( empty( $line ) ) {
				continue;
			}

			list($key, $value) = explode( ': ', $line );

			if ( $key == 'Link' ) {
				$value = array_merge(
					[ '_raw' => $value ],
					$this->get_link_header_as_array( $value )
				);
			}

			$headers[ $key ] = $value;
		}

		return $headers;
	}

	/**
	 * Extract all rel => URL pairs from the provided Link header value
	 *
	 * Mailchimp only implements the URI reference and relation type from
	 * RFC 5988, so the value of the header is something like this:
	 *
	 * 'https://us13.api.mailchimp.com/schema/3.0/Lists/Instance.json; rel="describedBy",
	 * <https://us13.admin.mailchimp.com/lists/members/?id=XXXX>; rel="dashboard"'
	 *
	 * @param string $link_header_as_string link as header string.
	 *
	 * @return array
	 */
	private function get_link_header_as_array( $link_header_as_string ) {
		$urls = [];

		if ( preg_match_all( '/<(.*?)>\s*;\s*rel="(.*?)"\s*/', $link_header_as_string, $matches ) ) {
			foreach ( $matches[2] as $i => $rel_name ) {
				$urls[ $rel_name ] = $matches[1][ $i ];
			}
		}

		return $urls;
	}

	/**
	 * Encode the data and attach it to the request
	 *
	 * @param   resource $ch   cURL session handle, used by reference.
	 * @param   array    $data Assoc array of data to attach.
	 */
	private function attach_request_payload( &$ch, $data ) {
		$encoded                    = wp_json_encode( $data );
		$this->last_request['body'] = $encoded;
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $encoded );
	}

	/**
	 * Decode the response and format any error messages for debugging
	 *
	 * @param array $response The response from the curl request.
	 *
	 * @return array|false    The JSON decoded into an array
	 */
	private function format_response( $response ) {
		$this->last_response = $response;

		if ( ! empty( $response['body'] ) ) {
			return json_decode( $response['body'], true );
		}

		return false;
	}

	/**
	 * Do post-request formatting and setting state from the response
	 *
	 * @param array    $response        The response from the curl request.
	 * @param string   $response_content The body of the response from the curl request.
	 * @param resource $ch              The curl resource.
	 *
	 * @return array    The modified response
	 */
	private function set_response_state( $response, $response_content, $ch ) {
		if ( false === $response_content ) {
			$this->last_error = curl_error( $ch );
		} else {

			$header_size = $response['headers']['header_size'];

			$response['httpHeaders'] = $this->get_headers_as_array( substr( $response_content, 0, $header_size) );
			$response['body']        = substr( $response_content, $header_size );

			if ( isset( $response['headers']['request_header'] ) ) {
				$this->last_request['headers'] = $response['headers']['request_header'];
			}
		}

		return $response;
	}

	/**
	 * Check if the response was successful or a failure. If it failed, store the error.
	 *
	 * @param array       $response          The response from the curl request.
	 * @param array|false $formatted_response The response body payload from the curl request.
	 * @param int         $timeout           The timeout supplied to the curl request.
	 *
	 * @return bool     If the request was successful
	 */
	private function determine_success( $response, $formatted_response, $timeout ) {
		$status = $this->find_http_status( $response, $formatted_response );

		if ( $status >= 200 && $status <= 299 ) {
			$this->request_successful = true;
			return true;
		}

		if ( isset( $formatted_response['detail'] ) ) {
			$this->last_error = sprintf( '%d: %s', $formatted_response['status'], $formatted_response['detail'] );
			return false;
		}

		if ( $timeout > 0 && $response['headers'] && $response['headers']['total_time'] >= $timeout ) {
			$this->last_error = sprintf( 'Request timed out after %f seconds.', $response['headers']['total_time'] );
			return false;
		}

		$this->last_error = 'Unknown error, call getLastResponse() to find out what happened.';
		return false;
	}

	/**
	 * Find the HTTP status code from the headers or API response body
	 *
	 * @param array       $response          The response from the curl request.
	 * @param array|false $formatted_response The response body payload from the curl request.
	 *
	 * @return int  HTTP status code
	 */
	private function find_http_status( $response, $formatted_response ) {
		if ( ! empty( $response['headers'] ) && isset( $response['headers']['http_code'] ) ) {
			return (int) $response['headers']['http_code'];
		}

		if ( ! empty( $response['body'] ) && isset( $formatted_response['status'] ) ) {
			return (int) $formatted_response['status'];
		}

		return 418;
	}
}
