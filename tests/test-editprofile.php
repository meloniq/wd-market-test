<?php
use WDMarket\TestTask\EditProfile;
use WP_Mock\Matcher\AnyInstance;
use WP_Mock\Tools\TestCase;

final class EditProfileTestCase extends TestCase {

	public function test_hook_expectations() : void {
		$anyEditProfile = new AnyInstance( EditProfile::class );

		WP_Mock::expectActionAdded( 'edit_user_profile', array( $anyEditProfile, 'display' ) );
		WP_Mock::expectActionAdded( 'show_user_profile', array( $anyEditProfile, 'display' ) );

		WP_Mock::expectActionAdded( 'edit_user_profile_update', array( $anyEditProfile, 'save' ) );
		WP_Mock::expectActionAdded( 'personal_options_update', array( $anyEditProfile, 'save' ) );

		new EditProfile();

		$this->assertConditionsMet();
	}

}
