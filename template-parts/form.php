<?php
/**
 * Template part for showing the search form
 *
 * @package Test_Wordpress
 */
?>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" class="test-wordpress__form">
    <?php wp_nonce_field( 'search_form_nonce', 'search_nonce' ); ?>
    <div class="test-wordpress__form-wrapper">

        <div class="test-wordpress__form-container">
            <label for="name"><?php esc_html_e( 'Name', 'prueba_wordpress' ); ?></label>
            <input type="text" name="name" id="name">
        </div>

        <div class="test-wordpress__form-container">
            <label for="surname"><?php esc_html_e( 'Surname', 'prueba_wordpress' ); ?></label>
            <input type="text" name="surname" id="surname">
        </div>

        <div class="test-wordpress__form-container">
            <label for="email"><?php esc_html_e( 'Email', 'prueba_wordpress' ); ?></label>
            <input type="email" name="email" id="email">
        </div>

        <div>
            <button type="submit" class="test-wordpress__form-button">
                <?php esc_html_e( 'Search', 'prueba_wordpress' ); ?>
            </button>
        </div>

    </div>
</form>
