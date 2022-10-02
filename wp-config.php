<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fictional' );

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
define( 'AUTH_KEY',         'CCK*:_V%Ku6NUX0)pZ#1F.z`d|8|Jk4?4D8nN7a9$=iOD6o)KSuUht<PI@h>%GVU' );
define( 'SECURE_AUTH_KEY',  '=+rmj?1ki@75F~kaYX<Yn)mn<+&>FU`J)Un6/pX.eA/~Qo5| dOErN*9Kq`H7w++' );
define( 'LOGGED_IN_KEY',    ')H9*3T@$:U2eo<dl%~+KrH]qK7o$uPU{6q_VM$gJAw)*H%&8F?YwAu)#B aqBy(8' );
define( 'NONCE_KEY',        '(kYKT]4).r]Y!=wp{IsB1^<$;x{yeb]7.:Ta^m}EE%pC=C6#JV^/ 32AvTjaSIP?' );
define( 'AUTH_SALT',        '7`zgQ.wB[v=.Ko<#k*=|<5|:QLBRZQaWgM6G{dH.fB2bU`k FedvI_p <1w!heY ' );
define( 'SECURE_AUTH_SALT', ';&uY&Iy.dN+MPgWI>5%Fs[6l}Bv Nk Og%6FH]HIP1W,+aN&dlo/Vyy4z9CDL&Fo' );
define( 'LOGGED_IN_SALT',   '_q};[Ri|B!(Ul*Z1ebPry=H4C#0:/fI&vr<I]|ZMo%(Kl|n03p7Yw_L#xv!%}2=:' );
define( 'NONCE_SALT',       'uYk~~9ZxxY)(n60HbnP>!fhsMw^1 >Q&QL:<N:nn}_2SxG`+zZ?(q1-pEW|Uzql_' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fc_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
