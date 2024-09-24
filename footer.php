<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #main div and all content after.
 *
 * @package Prueba_Wordpress
 */
?>

<footer>
    <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>

<?php wp_footer(); ?>

</body>
</html>
