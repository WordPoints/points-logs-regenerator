<?php

/**
 * Module Name: Points Logs Regenerator
 * Author:      J.D. Grimes
 * Author URI:  http://codesymphony.co/
 * Version:     1.0.0
 * License:     GPLv2+
 * Description: Regenerates your points logs.
 *
 * ---------------------------------------------------------------------------------|
 * Copyright 2014-15  J.D. Grimes  (email : jdg@codesymphony.co)
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
 * @version 1.0.0
 * @author  J.D. Grimes <jdg@codesymphony.co>
 * @license GPLv2+
 */

/**
 * Regenerate the points logs.
 *
 * @since 1.0.0
 */
function wordpoints_points_logs_regenerator_regenerate() {

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

		wordpoints_show_admin_message( __( 'The points logs were regenerated.' ) );
	}

	?>

	<br />
	<form method="post">
		<?php wp_nonce_field( 'wordpoints_points_logs_regenerator' ); ?>
		<?php submit_button( __( 'Regenerate Points Logs' ), 'primary', 'regenerate_points_logs', false ); ?>
		<?php esc_html_e( 'Regenerating your logs may take a few moments depending on the number of them.' ); ?>
	</form>
	<br />

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
