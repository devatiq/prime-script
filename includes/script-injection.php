<?php
namespace PrimeScript;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Script_Injection {

    public static function init() {
        add_action( 'wp_head', [ __CLASS__, 'inject_header_script' ], 10 );
        add_action( 'wp_footer', [ __CLASS__, 'inject_footer_script' ], 10 );
    }

    public static function inject_header_script() {
        $header_script = get_option( 'primescript_header_script', '' );
        if ( ! empty( $header_script ) ) {
            echo $header_script; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    public static function inject_footer_script() {
        $footer_script = get_option( 'primescript_footer_script', '' );
        if ( ! empty( $footer_script ) ) {
            echo $footer_script; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}

Script_Injection::init();
