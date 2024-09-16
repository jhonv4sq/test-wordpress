<?php
/**
 * Template part for showing users list
 *
 * @package Prueba_Wordpress
 */

$users = get_query_var( 'users_data' );
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
        <!-- <?php if ( ! empty( $users ) ) : ?>
            <?php foreach ( $users as $user ) : ?>
                <tr>
                    <td><?php echo esc_html( $user['username'] ); ?></td>
                    <td><?php echo esc_html( $user['name'] ); ?></td>
                    <td><?php echo esc_html( $user['surname1'] ); ?></td>
                    <td><?php echo esc_html( $user['surname2'] ); ?></td>
                    <td><?php echo esc_html( $user['email'] ); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5"><?php esc_html_e( 'No users found', 'prueba_wordpress' ); ?></td>
            </tr>
        <?php endif; ?> -->
    </tbody>
</table>
