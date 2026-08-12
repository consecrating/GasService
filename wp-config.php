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
define( 'DB_NAME', 'sanctqeo_kavlekargas' );

/** Database username */
define( 'DB_USER', 'sanctqeo_kavlekargas' );

/** Database password */
define( 'DB_PASSWORD', '@_[$O6wi0vLv#' );

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
define( 'AUTH_KEY',         '}K3/>}VXu``-EcTic/u9?p![(RA,eR}8HUc4-<P dLyjC|iaI[_hK5Po(QxYje]4' );
define( 'SECURE_AUTH_KEY',  'ae_^HSySU3TDihL&I8Ube^j2mFB4/eC]oh;],T]Xp QX]i]i.3$PUHkV.9zrYVoW' );
define( 'LOGGED_IN_KEY',    ';I/(D?;n(bEdKgd!-j+T`R_kjlNkx)L;X|e)Ax;~1ii%(p#!>;o{Pi#.%e&0xa^m' );
define( 'NONCE_KEY',        '}a97=(Z&sGnrpxtO^>lscwKo2t6RiPkYqx(C6j2Ok*`Z+ehPrd7C8vGPw{^J:5fe' );
define( 'AUTH_SALT',        '-$^)y=i=xw!OU~iW*l!.E2ouSyro=WAfB!aT4[$R7BMjp9i@f#Wg)>Q,tb2CopbS' );
define( 'SECURE_AUTH_SALT', 'E*!`[1I[o8GRMz l2/ HJ(~xZa$ORtij}`^osPN>BOK^t(rX]wLQaH>+cPyS^mw?' );
define( 'LOGGED_IN_SALT',   'Lx/<XD{yfsE,2|5Vd,gM|?IbDi[UHSG61-$<ds5Ph{dMUxj|_M6eX;An#)6Pm=F~' );
define( 'NONCE_SALT',       '#oA%5/hg>&r[yP{+4n .2GN+X/aL~b!xL6@~`LG`Z}fXxIisgRLWu>qK})ZSv(!h' );

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
$table_prefix = 'kg_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
