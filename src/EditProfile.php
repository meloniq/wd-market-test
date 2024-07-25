<?php
namespace WDMarket\TestTask;

use WP_User;

class EditProfile {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'edit_user_profile', array( $this, 'display' ) );
		add_action( 'show_user_profile', array( $this, 'display' ) );

		add_action( 'edit_user_profile_update', array( $this, 'save' ) );
		add_action( 'personal_options_update', array( $this, 'save' ) );
	}

	/**
	 * Display the fields.
	 *
	 * @param WP_User $user
	 *
	 * @return void
	 */
	public function display( WP_User $user ) : void {
		$fields = array(
			'vat_number' => array(
				'label' => __( 'VAT Number', WDM_TT_TD ),
				'type'  => 'text',
			),
			'company_name' => array(
				'label' => __( 'Company Name', WDM_TT_TD ),
				'type'  => 'text',
			),
		);

		?>
		<h2><?php esc_html_e( 'Additional Information', WDM_TT_TD ); ?></h2>
		<table class="form-table">
			<?php
			foreach ( $fields as $field_id => $field_values ) :
				$the_value = get_user_meta( $user->ID, $field_id, true );
				?>
				<tr>
					<th>
						<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $field_values['label'] ); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $the_value ); ?>" class="regular-text" size="35" />
					</td>
				</tr>
			<?php
			endforeach;
			?>
		</table>
		<?php
	}

	/**
	 * Save the fields.
	 *
	 * @param int $user_id
	 *
	 * @return void
	 */
	public function save( int $user_id ) : void {
		$fields = array(
			'vat_number',
			'company_name',
		);

		foreach ( $fields as $field_id ) {
			if ( isset( $_POST[ $field_id ] ) ) {
				update_user_meta( $user_id, $field_id, sanitize_text_field( wp_unslash( $_POST[ $field_id ] ) ) );
			}
		}
	}

}
