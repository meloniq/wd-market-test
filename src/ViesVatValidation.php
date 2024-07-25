<?php
namespace WDMarket\TestTask;

class ViesVatValidation {

	/**
	 * Company name.
	 *
	 * @var string
	 */
	private $company_name = '';

	/**
	 * Get company name.
	 *
	 * @return string
	 */
	public function get_company_name() : string {
		return $this->company_name;
	}

	/**
	 * Is VAT number valid?
	 *
	 * @param string|int $vat_number
	 *
	 * @return bool
	 */
	public function is_valid( string|int $vat_number ) : bool {
		if ( ! $vat_number ) {
			return false;
		}

		$country_code = preg_replace( '/[^A-Z]/', '', $vat_number );
		if ( ! $country_code ) {
			// default to Latvia
			$country_code = 'LV';
		}

		$vat_number = preg_replace( '/[^0-9]/', '', $vat_number );
		// it has to be at least 9 digits
		if ( strlen( $vat_number ) < 9 ) {
			return false;
		}

		// basic validation done, now let's check with VIES
		$result = $this->check_vies_vat( $vat_number, $country_code );
		if ( ! $result ) {
			return false;
		}

		return true;
	}

	/**
	 * Check VAT number with VIES.
	 *
	 * @param string|int $vat_number
	 * @param string $country_code
	 *
	 * @return bool
	 */
	private function check_vies_vat( string|int $vat_number, string $country_code ) : bool {
		// https://ec.europa.eu/taxation_customs/vies/rest-api/ms/LV/vat/44103126607
		$url = 'https://ec.europa.eu/taxation_customs/vies/rest-api/ms/%s/vat/%d';
		$url = sprintf( $url, $country_code, $vat_number );

		$args = array(
			'sslverify' => false,
		);

		$response = wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			error_log( $response->get_error_message() );
			return false;
		}

		$body = wp_remote_retrieve_body( $response );

		$data = json_decode( $body );
		if ( ! $data ) {
			return false;
		}

		if ( ! $data->isValid ) {
			return false;
		}

		// save company name for later use
		$this->company_name = $data->name;

		return true;
	}

}
