<?php
use WDMarket\TestTask\ViesVatValidation;
use WP_Mock\Matcher\AnyInstance;
use WP_Mock\Tools\TestCase;

final class ViesVatValidationTestCase extends TestCase {

	public function test_is_valid() : void {
		$vat_validation = new ViesVatValidation();

		// Test invalid VAT number.
		$this->assertFalse( $vat_validation->is_valid( '' ) );
		$this->assertFalse( $vat_validation->is_valid( '123' ) );
		$this->assertFalse( $vat_validation->is_valid( 'lorem ipsum' ) );

		// Mock wp_remote_get()
		WP_Mock::userFunction( 'wp_remote_get', array(
			'return' => array(
				'body' => $this->get_mock_vies_response(),
			),
		) );

		// Mock is_wp_error()
		WP_Mock::userFunction( 'is_wp_error', array(
			'return' => false,
		) );

		// Mock wp_remote_retrieve_body()
		WP_Mock::userFunction( 'wp_remote_retrieve_body', array(
			'return' => $this->get_mock_vies_response(),
		) );

		// Test valid VAT number.
		$this->assertTrue( $vat_validation->is_valid( 'LV44103126607' ) );
		$this->assertTrue( $vat_validation->is_valid( '44103126607' ) );

		$this->assertTrue( $vat_validation->is_valid( 'PL5492174701' ) );
		$this->assertTrue( $vat_validation->is_valid( '5492174701' ) );
	}

	/**
	 * Get mocked response from VIES.
	 *
	 * @return string
	 */
	private function get_mock_vies_response() : string {
		ob_start();
		?>
{
  "isValid" : true,
  "requestDate" : "2024-07-25T07:28:37.115Z",
  "userError" : "VALID",
  "name" : "SIA \"WD Market\"",
  "address" : "Lāčplēša iela 6–8, Sigulda, Siguldas nov., LV-2150",
  "requestIdentifier" : "",
  "originalVatNumber" : "44103126607",
  "vatNumber" : "44103126607",
  "viesApproximate" : {
    "name" : "---",
    "street" : "---",
    "postalCode" : "---",
    "city" : "---",
    "companyType" : "---",
    "matchName" : 3,
    "matchStreet" : 3,
    "matchPostalCode" : 3,
    "matchCity" : 3,
    "matchCompanyType" : 3
  }
}
<?php
		return ob_get_clean();
	}


}
