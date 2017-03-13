<?php

/**
 * Testcase for the points logs regenerator.
 *
 * @package WordPoints_Points_Logs_Regenerator
 * @since 1.1.0
 */

/**
 * Tests for the points logs regenerator.
 *
 * @since 1.1.0
 */
class WordPoints_Points_Logs_Regenerator_Test
	extends WordPoints_PHPUnit_TestCase_Points {

	/**
	 * @since 1.1.0
	 */
	public static function setUpBeforeClass() {

		parent::setUpBeforeClass();

		/**
		 * The admin-side functions from WordPoints.
		 *
		 * @since 1.1.0
		 */
		require_once( WORDPOINTS_DIR . '/admin/admin.php' );
	}

	/**
	 * @since 1.1.0
	 */
	public function setUp() {

		parent::setUp();

		add_filter( 'wordpoints_points_log-test', array( $this, 'log_text_hello_world' ) );

		$this->factory->wordpoints->points_log->create_many(
			2
			, array( 'log_type' => 'test' )
		);

		$query = new WordPoints_Points_Logs_Query();
		$logs = $query->get();

		$this->assertCount( 2, $logs );
		$this->assertSame( 'Hello world!', $logs[0]->text );
		$this->assertSame( 'Hello world!', $logs[1]->text );

		remove_filter( 'wordpoints_points_log-test', array( $this, 'log_text_hello_world' ) );
		add_filter( 'wordpoints_points_log-test', array( $this, 'log_text_hello_tester' ) );

		wp_set_current_user(
			$this->factory->user->create( array( 'role' => 'administrator' ) )
		);

		$_POST['regenerate_points_logs'] = 'Regenerate Points Logs';
		$_REQUEST['_wpnonce'] = wp_create_nonce( 'wordpoints_points_logs_regenerator' );
	}

	/**
	 * Test that the logs are regenerated.
	 *
	 * @since 1.1.0
	 *
	 * @covers ::wordpoints_points_logs_regenerator_regenerate
	 */
	public function test_points_logs_regenerated() {

		wordpoints_points_logs_regenerator_regenerate();

		$query = new WordPoints_Points_Logs_Query();
		$logs = $query->get();

		$this->assertCount( 2, $logs );
		$this->assertSame( 'Hello tester!', $logs[0]->text );
		$this->assertSame( 'Hello tester!', $logs[1]->text );
	}

	/**
	 * Test that the logs are regenerated when the form is submitted.
	 *
	 * @since 1.1.0
	 *
	 * @covers ::wordpoints_points_logs_regenerator_form
	 */
	public function test_points_logs_regenerated_by_submit() {

		ob_start();
		wordpoints_points_logs_regenerator_form();
		$form = ob_get_clean();

		$this->assertWordPointsAdminNotice( $form );

		$query = new WordPoints_Points_Logs_Query();
		$logs = $query->get();

		$this->assertCount( 2, $logs );
		$this->assertSame( 'Hello tester!', $logs[0]->text );
		$this->assertSame( 'Hello tester!', $logs[1]->text );
	}

	/**
	 * Test that the logs are not regenerated if the user doesn't have the caps.
	 *
	 * @since 1.1.0
	 *
	 * @covers ::wordpoints_points_logs_regenerator_form
	 */
	public function test_submit_requires_correct_caps() {

		wp_set_current_user(
			$this->factory->user->create( array( 'role' => 'subscriber' ) )
		);

		$_REQUEST['_wpnonce'] = wp_create_nonce( 'wordpoints_points_logs_regenerator' );

		ob_start();
		wordpoints_points_logs_regenerator_form();
		$form = ob_get_clean();

		$this->assertSame( '', $form );

		$this->assertLogsNotRegenerated();
	}

	/**
	 * Test that a valid nonce is required.
	 *
	 * @since 1.1.0
	 *
	 * @covers ::wordpoints_points_logs_regenerator_form
	 */
	public function test_submit_requires_valid_nonce() {

		$_REQUEST['_wpnonce'] = 'invalid';

		try {
			wordpoints_points_logs_regenerator_form();
		} catch ( WPDieException $e ) {
			// Do nothing.
			unset( $that );
		}

		$this->assertTrue( isset( $e ) );

		$this->assertLogsNotRegenerated();
	}

	/**
	 * Test that the form must have been submitted.
	 *
	 * @since 1.1.0
	 *
	 * @covers ::wordpoints_points_logs_regenerator_form
	 */
	public function test_submit_requires_post_var() {

		unset( $_POST['regenerate_points_logs'] );

		ob_start();
		wordpoints_points_logs_regenerator_form();
		$form = ob_get_clean();

		$document = new DOMDocument;
		$document->loadHTML( $form );
		$xpath = new DOMXPath( $document );
		$this->assertSame(
			0
			, $xpath->query( '//div[contains(@class, "notice")]' )->length
		);

		// Back-compat.
		$this->assertSame(
			0
			, $xpath->query( '//div[@id = "message"]' )->length
		);

		$this->assertLogsNotRegenerated();
	}

	/**
	 * Test that this function is deprecated but still works.
	 *
	 * @since 1.1.0
	 *
	 * @covers ::worpdoints_points_logs_regenerator_form
	 *
	 * @expectedDeprecated worpdoints_points_logs_regenerator_form
	 */
	public function test_deprecated_version_with_typo() {

		ob_start();
		worpdoints_points_logs_regenerator_form();
		$form = ob_get_clean();

		$document = new DOMDocument;
		$document->loadHTML( $form );
		$xpath = new DOMXPath( $document );
		$this->assertSame(
			1
			, $xpath->query( '//form' )->length
		);
	}

	//
	// Helpers.
	//

	/**
	 * Assert that the logs were not regenerated.
	 *
	 * @since 1.1.0
	 */
	protected function assertLogsNotRegenerated() {

		$query = new WordPoints_Points_Logs_Query();
		$logs = $query->get();

		$this->assertCount( 2, $logs );
		$this->assertSame( 'Hello world!', $logs[0]->text );
		$this->assertSame( 'Hello world!', $logs[1]->text );
	}

	/**
	 * Generates the points log text 'Hello world!'.
	 *
	 * @since 1.1.0
	 *
	 * @WordPress\filter wordpoints_points_log-test Added during the tests.
	 *
	 * @return string The log text 'Hello world!'.
	 */
	public function log_text_hello_world() {
		return 'Hello world!';
	}

	/**
	 * Generates the points log text 'Hello world!'.
	 *
	 * @since 1.1.0
	 *
	 * @WordPress\filter wordpoints_points_log-test Added during the tests.
	 *
	 * @return string The log test 'Hello tester!'.
	 */
	public function log_text_hello_tester() {
		return 'Hello tester!';
	}
}

// EOF
