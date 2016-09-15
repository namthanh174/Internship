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
define('DB_NAME', 'efe36702_thanh_vo');

/** MySQL database username */
define('DB_USER', 'efe36702_dev');

/** MySQL database password */
define('DB_PASSWORD', 'melody123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'DoSA6[ks[M]TN{=o)g-M>i//nRA~liJVRxTxe3C,$4 (![N+29&$Zv5o+#?MPlJO');
define('SECURE_AUTH_KEY',  'e#lwGBwAddnm&x&;fpxJn^_(W?D_p9UPAQnm)7#TU``3xZN7_{ vUZ./3+eVFd;~');
define('LOGGED_IN_KEY',    'g10}G y;sX=c+xHrJpXYK[GH?oD`pEc&G)>uqM7QQu{TZj5R)uJb+HI^Ab.Nrr!a');
define('NONCE_KEY',        '&bPz5G8UpBYp>`XlP`!ekV %=Iw_!uzj]f`|-hc(WCteLlFt;*,=$Zj|8<A08,eq');
define('AUTH_SALT',        'Y TJrxTfiH[`90mYsiv `i9oZ)/(DaB>sA-::Jf*$m+KhLzGaGm9:u&&Jy{{;[ w');
define('SECURE_AUTH_SALT', 'i,V5P|6UMr)O+[`O+<xl2-LCW4h.hQ;Ymde^)DKi>Jv`Ayu}(^}uz,k8QB/bj(VY');
define('LOGGED_IN_SALT',   'WM|4u:$W/H1UytdzDWw*cDzU>|o+qu@;#)u~6|AN!Ww0DD1|$ml!q10wz0l{#|?l');
define('NONCE_SALT',       'ee`tt=g88,4;W!jpTWGyY0.d}spew.]2MM8)useQo`jRZ(1/dBu3&%fK $i&?1MI');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

