<?php
use WDMarket\TestTask\Registration;
use WP_Mock\Matcher\AnyInstance;
use WP_Mock\Tools\TestCase;

final class RegistrationTestCase extends TestCase {

	public function test_hook_expectations() : void {
		$anyRegistration = new AnyInstance( Registration::class );

		WP_Mock::expectActionAdded( 'woocommerce_before_checkout_registration_form', array( $anyRegistration, 'add_fields' ) );

		new Registration();

		$this->assertConditionsMet();
	}

}
