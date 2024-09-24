<?php
/**
 * Template part for showing the users list
 *
 * @package Prueba_Wordpress
 */
?>

<table class="prueba-wordpress__table">
    <thead class="prueba-wordpress__table-head">
        <tr>
            <th><?php esc_html_e( 'Username', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'Name', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'First Surname', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'Second Surname', 'prueba_wordpress' ); ?></th>
            <th><?php esc_html_e( 'Email', 'prueba_wordpress' ); ?></th>
        </tr>
    </thead>

    <tbody class="prueba-wordpress__table-body">
        <!-- Aquí se insertarán las filas de usuarios dinámicamente -->
    </tbody>
</table>

<div class="prueba-wordpress__pagination"></div>
