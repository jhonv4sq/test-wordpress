<?php
/**
 * Template part for showing the users list
 *
 * @package Test_Wordpress
 */
?>

<table class="test-wordpress__table">
    <thead class="test-wordpress__table-head">
        <tr>
            <th><?php esc_html_e( 'Username', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'Name', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'First Surname', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'Second Surname', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'Email', 'prueba_wordpress' ); ?></th>
        </tr>
    </thead>

    <tbody class="test-wordpress__table-body">
        <!-- Aquí se insertarán las filas de usuarios dinámicamente -->
    </tbody>
</table>

<div class="test-wordpress__pagination"></div>
