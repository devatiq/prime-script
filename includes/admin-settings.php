<?php
namespace PrimeScript;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin_Settings {

    public static function init() {
        add_action( 'admin_menu', [ __CLASS__, 'add_settings_page' ] );
        add_action( 'admin_init', [ __CLASS__, 'register_settings' ] );
    }

    public static function add_settings_page() {
        add_menu_page(
            __( 'PrimeScript Settings', 'prime-script' ),
            __( 'PrimeScript', 'prime-script' ),
            'manage_options',
            'prime-script-settings',
            [ __CLASS__, 'render_settings_page' ],
            'dashicons-editor-code',
            100
        );
    }

    public static function register_settings() {
        register_setting( 'primescript_settings', 'primescript_header_script' );
        register_setting( 'primescript_settings', 'primescript_footer_script' );
    }

    public static function add_settings_link( $links ) {
        $settings_link = '<a href="' . admin_url( 'admin.php?page=prime-script-settings' ) . '">' . __( 'Settings', 'prime-script' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public static function render_settings_page() {
        // Check if form was submitted and verify nonce.
        if ( isset( $_POST['primescript_nonce'] ) ) {
            if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['primescript_nonce'] ) ), 'primescript_save_settings' ) ) {
                // Settings updated notice.
                if ( isset( $_GET['settings-updated'] ) && 'true' === sanitize_text_field( wp_unslash( $_GET['settings-updated'] ) ) ) {
                    echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
                            <p><strong>' . esc_html__( 'Settings have been updated.', 'prime-script' ) . '</strong></p>
                          </div>';
                }
            } else {
                // Nonce verification failed.
                wp_die( esc_html__( 'Nonce verification failed. Please try again.', 'prime-script' ) );
            }
        }
    
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'PrimeScript Settings', 'prime-script' ); ?></h1>
            <?php settings_errors( ); ?>
            <form method="post" action="options.php">
                <?php
                wp_nonce_field( 'primescript_save_settings', 'primescript_nonce' );
                // Output nonce, action, and option fields for the settings page.
                settings_fields( 'primescript_settings' );
                do_settings_sections( 'primescript_settings' );
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="primescript_header_script">
                                <?php esc_html_e( 'Header Script', 'prime-script' ); ?>
                            </label>
                        </th>
                        <td>
                            <textarea
                                id="primescript_header_script"
                                name="primescript_header_script"
                                rows="10"
                                cols="50"
                                class="large-text code"
                            ><?php echo esc_textarea( get_option( 'primescript_header_script', '' ) ); ?></textarea>
                            <p class="description">
                                <?php esc_html_e( 'Scripts added here will be injected into the <head> section.', 'prime-script' ); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="primescript_footer_script">
                                <?php esc_html_e( 'Footer Script', 'prime-script' ); ?>
                            </label>
                        </th>
                        <td>
                            <textarea
                                id="primescript_footer_script"
                                name="primescript_footer_script"
                                rows="10"
                                cols="50"
                                class="large-text code"
                            ><?php echo esc_textarea( get_option( 'primescript_footer_script', '' ) ); ?></textarea>
                            <p class="description">
                                <?php esc_html_e( 'Scripts added here will be injected just above the </body> tag.', 'prime-script' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }      
    
}

Admin_Settings::init();
