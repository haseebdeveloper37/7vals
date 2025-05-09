<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '7vals' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '}:N#q?MSe(n&L[NO5q7=]gdLw`dzh,ODuNu+wlb `~VC:$5DS0C+*4L0pxoSDVd0' );
define( 'SECURE_AUTH_KEY',  '-x[*>`X:z/<6nU{BAM&8=tj5RF!miv po-6sz(;-#0?qr@QNq:nZ)f5siQQDzCb6' );
define( 'LOGGED_IN_KEY',    'hn7LZ>?+:.g|h/:WlK`c9Q)?Wg%.>AxIQ4H $1o!+31Bye8f>74^~V0~wUQe/v30' );
define( 'NONCE_KEY',        '*CSq}7%OSehTbIBx;gE4^n&U5p+<_.4%k,#H+@KFl#s{x[S(W$=q@PtS|OYZp-UB' );
define( 'AUTH_SALT',        '/1r^%Pyt<Qka|.|Sx[Q<oLQ]Y+OPN~j,SN*ZL*^p&.?-MUN7f`!#)XCkI^{#p!5b' );
define( 'SECURE_AUTH_SALT', 'qZvubqFk{TrC%G^S;uk^h @(^Q6(j5$LcMi Fsj)s}zt=o9bBMVd^`nZQ/@uXuaX' );
define( 'LOGGED_IN_SALT',   'I/wZug:3Q4:;VTExeC3NmLBibwmd+,z-Zm:H$*7HHk*kfdDgaF5azBKcUQez|ec+' );
define( 'NONCE_SALT',       '8>Qgmk3d$L6A=b{[h,R75VB#dY[{wmaqN}9z,(c$sns=MzlV7UDWM%g,NLn?Gjza' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );
// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
