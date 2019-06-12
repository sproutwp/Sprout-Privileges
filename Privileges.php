<?php
/**
 * @package Sprout
 * @subpackage SproutPrivileges
 * @since 1.0.0
 */
namespace Sprout\SproutPrivileges;

/**
 * Class that contains methods relating to user privileges.
 */
class Privileges
{
    /**
     * Determines if the current user can load Sprout or Sprout Functions.
     *
     * @return boolean
     */
    public static function canLoadSprout()
    {
        if( !function_exists( 'current_user_can' ) ) {
            require_once ABSPATH . 'wp-includes/capabilities.php';
        }

        if( !function_exists( 'wp_get_current_user' ) ) {
            require_once( ABSPATH . 'wp-includes/pluggable.php' );
        }

        return current_user_can( 'administrator' );
    }

    /**
     * Determines if the current user has a certain capability.
     *
     * @internal The reasoning for wrapping this is to include the files, in case the functions aren't available.
     *
     * @return boolean
     */
    public static function hasCapability( $capability )
    {
        if( !is_string( $capability )  ) {
            return new \WP_Error(
                'capability-is-not-string',
                esc_html__( 'The capability you provided is not a string.', 'sprout' )
            );
        }

        if( !function_exists( 'current_user_can' ) ) {
            require_once ABSPATH . 'wp-includes/capabilities.php';
        }

        if( !function_exists( 'wp_get_current_user' ) ) {
            require_once( ABSPATH . 'wp-includes/pluggable.php' );
        }

        return current_user_can( $capability );
    }

    /**
     * Determines if Sprout's view control screen should be visible.
     *
     * @return boolean
     */
    public static function shouldDisplaySproutView()
    {
        if( !function_exists( 'is_customize_preview' ) ) {
            require_once ABSPATH . 'wp-includes/theme.php';
        }

        $rules = array_merge( apply_filters( 'sprout\sprout_privileges\sprout_view\load_view_rules', [] ), [
            is_customize_preview(),
        ]);

        return in_array( False, $rules );

    }

    /**
     * Checks if the currently logged-in user can create other users.
     *
     * @return boolean
     */
    public static function canCreateUsers()
    {
        if( !function_exists( 'current_user_can' ) ) {
            require_once ABSPATH . 'wp-includes/capabilities.php';
        }
        return current_user_can( 'create_users' );
    }
}