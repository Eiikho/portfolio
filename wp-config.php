<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'remi-adriano' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'oEyiz{,do[0<r!l/`wYT%, !`%DGb?U?Fo4T}i+G2 b{D^/|G]d-q5}rhg6z-(qM' );
define( 'SECURE_AUTH_KEY',  'oPhoLFl8vW_KEVK`0+cFoJ>/HJ2{J<qd*;$/vzDv@]&XT`4*fKU^8wDqBeSCBK_,' );
define( 'LOGGED_IN_KEY',    'Z@<G UC6#U5ydCMlfT?7:UaQ/h 2Nj!(/^S~G))lsqkEp Z5[#5I98?v!,_<x|E(' );
define( 'NONCE_KEY',        'WYG{Nccb0-^CgXVq1-mogK@cO,:y>PS_E8A,E<BAD[b}%4B4 cMi(1~pK*oSIJ?^' );
define( 'AUTH_SALT',        '6-7%KT-:RHi%ITdF$h(Hj^f6aJ>kC.jQxKGR_i= ;2V~6GsqJJCVl=1=:gMqBbAv' );
define( 'SECURE_AUTH_SALT', '{i3T%O0Zku^+r`Uairla-ERWU.k*c$ldU^d#68 j k^7PI841Im90ui[Q#8LnX4h' );
define( 'LOGGED_IN_SALT',   '27I6ur~k7pdaEM6d=z!t,{:CHR/23$j>xAF-]TA=1?&tE nG.k}*[>U`ngEbS5(+' );
define( 'NONCE_SALT',       'vzDzQri8kg&1zhb2cSe[0/QHDkKfu2C>_H2S&XN!`tHAy#ZTT6p}F]>Iiu8J6p}4' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
