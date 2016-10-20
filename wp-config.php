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
define('DB_NAME', 'efei-16');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'VEM7jYla-K|pK^RzSzQ~`r;pd|J2q~JiGUsk8N%.:AlK,z[=_7*oe0@TI8MC6:B-');
define('SECURE_AUTH_KEY',  'Gq[Yr/]a.#MjMIsC9V/7 /db@Rg1r6+UG600vAH_`*iEHTok[=MovdIpUO[0:-!:');
define('LOGGED_IN_KEY',    '.Ml*:l<5-n/z>y[G lY$PW{KUi722p(d$,mIqD7wLgWpNpOP)QI5mx phI/3^3k*');
define('NONCE_KEY',        '1KW>EgW>HG>6N8K#,%[RZ{#_]I8wJaam1*V|v/N|w+OR$<<:nnnLFdn*p 03/=;O');
define('AUTH_SALT',        'rwy$fW]~(UlX*j5ZQrrs_Jz)neT0n:(  4 VdrG 8|evZ~F.: 0)5I0nyq}f0c;.');
define('SECURE_AUTH_SALT', 'oiaXo?c#Jr5dVw%Kb~w$Cj#1N Cl1_-?>/_Vpzb9{q6.Xv4?3z;l0xj7LIIn,KUz');
define('LOGGED_IN_SALT',   'w;%d*2K`387&##om@avCY5)M6=b=sy;n[#_o[8qITYH9W-gZgb1 TY*K6yN}@ht=');
define('NONCE_SALT',       'n:yoqJ#MdKVE4+>%b@_>BmCS,x,2L|H|o~$Bjt[6~^mTc{NW$>oODjfvQiGT033N');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');





