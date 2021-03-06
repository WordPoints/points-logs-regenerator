<?php

/**
 * The extension's main file.
 *
 * ---------------------------------------------------------------------------------|
 * Copyright 2014-17  J.D. Grimes  (email : jdg@codesymphony.co)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * ---------------------------------------------------------------------------------|
 *
 * @package WordPoints_Points_Logs_Regenerator
 * @version 1.1.1
 * @author  J.D. Grimes <jdg@codesymphony.co>
 * @license GPLv2+
 * @copyright 2014-17 J.D. Grimes
 */

wordpoints_register_extension(
	'
		Extension Name: Points Logs Regenerator
		Extension URI:  https://wordpoints.org/extensions/points-logs-regenerator/
		Author:         J.D. Grimes
		Author URI:     https://codesymphony.co/
		Version:        1.1.1
		License:        GPLv2+
		Description:    Regenerate your points logs using a button at the top of the Points Logs screen.
		Text Domain:    wordpoints-points-logs-regenerator
		Domain Path:    /languages
		Namespace:      Points_Logs_Regenerator
		Server:         wordpoints.org
		ID:             530
	'
	, __FILE__
);

/**
 * Regenerate the points logs.
 *
 * @since 1.0.0
 */
function wordpoints_points_logs_regenerator_regenerate() {

	wordpoints_prevent_interruptions();

	$logs_query = new WordPoints_Points_Logs_Query();

	wordpoints_regenerate_points_logs( $logs_query->get() );
}

/**
 * Add a regenerate button to the points logs screen.
 *
 * @since 1.1.0
 */
function wordpoints_points_logs_regenerator_form() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['regenerate_points_logs'] ) ) {

		check_admin_referer( 'wordpoints_points_logs_regenerator' );

		wordpoints_points_logs_regenerator_regenerate();

		wordpoints_show_admin_message(
			__( 'The points logs were regenerated.', 'wordpoints-points-logs-regenerator' )
		);
	}

	?>

	<style>
		@media screen and (min-width: 550px) {
			#wordpoints-points-logs-regenerator {
				float: right;
				margin-top: -75px;
			}
		}
	</style>

	<div id="wordpoints-points-logs-regenerator">
		<form method="post">
			<?php wp_nonce_field( 'wordpoints_points_logs_regenerator' ); ?>
			<?php submit_button( __( 'Regenerate Points Logs', 'wordpoints-points-logs-regenerator' ), 'secondary', 'regenerate_points_logs', false ); ?>
		</form>
	</div>

	<?php
}
add_action( 'wordpoints_admin_points_logs', 'wordpoints_points_logs_regenerator_form' );

/**
 * Add a regenerate button to the points logs screen.
 *
 * @since 1.0.0
 * @deprecated 1.1.0 Use wordpoints_points_logs_regenerator_form() instead.
 */
function worpdoints_points_logs_regenerator_form() {

	_deprecated_function( __FUNCTION__, '1.1.0', 'wordpoints_points_logs_regenerator_form' );

	wordpoints_points_logs_regenerator_form();
}

// EOF
