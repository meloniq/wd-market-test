<?php
namespace WDMarket\TestTask;

use WC_Checkout;

class Registration {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'woocommerce_before_checkout_registration_form', array( $this, 'add_fields' ) );

		add_action( 'woocommerce_checkout_process', array( $this, 'validate_fields' ) );

	}

	/**
	 * Add fields to the registration form.
	 *
	 * @param WC_Checkout $checkout
	 *
	 * @return void
	 */
	public function add_fields( WC_Checkout $checkout ) : void {
		?>
		<div class="create-account">
			<?php
			foreach ( $this->get_fields() as $key => $field ) {
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
			?>
			<div class="clear"></div>
		</div>
		<?php
	}

	/**
	 * Get fields.
	 *
	 * @return array
	 */
	public function get_fields() : array {
		return array(
			'vat_number'   => array(
				'type'         => 'text',
				'label'        => __( 'VAT Number', WDM_TT_TD ),
				'required'     => false,
				'placeholder'  => '',
			),
			'company_name' => array(
				'type'         => 'text',
				'label'        => __( 'Company Name', WDM_TT_TD ),
				'required'     => false,
				'placeholder'  => '',
			),
		);
	}

	/**
	 * Validate fields.
	 *
	 * @return void
	 */
	public function validate_fields() : void {
		if ( ! empty( $_POST['vat_number'] ) ) {
			$validator = new ViesVatValidation();
			if ( ! $validator->is_valid( $_POST['vat_number'] ) ) {
				wc_add_notice( __( 'Please enter a valid VAT Number.', WDM_TT_TD ), 'error' );
			} else {
				// if company name is empty, then try to get it from the validator
				if ( empty( $_POST['company_name'] ) && $validator->get_company_name() ) {
					$_POST['company_name'] = $validator->get_company_name();
				}
			}
		}
	}

}
