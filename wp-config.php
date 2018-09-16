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
define('DB_NAME', 'dongnam');

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
define('AUTH_KEY',         'y^i8{=ng8`&|h5(hfWU|*dv0>eH8%(c0MWZ$e[#kGHc[!nQJOW{A2x*Mic)^bb%t');
define('SECURE_AUTH_KEY',  '2SZrf`}miiQ >,u9Gf-;?6%YE!2K~)+`;!OX:ALYJy@!l.1]<``dBG=bvp!*{*5]');
define('LOGGED_IN_KEY',    '4@_W|ABI:LjwFTG9[fk*j42BIicz 5z{R@Cp>QyaD3a=9W6i:WxKbdiW98`?/>>#');
define('NONCE_KEY',        'yZ#3hC)`.6|kNP!xTeG;:J5/bAL-;VTb}1>?@a7;M0FUQ?KGe%}K]pUE$*i1$O_%');
define('AUTH_SALT',        'qS?1r[rQu>9OBrCAkbn{KXo:nBJy@+9JQfJk#r11>;BMR0oZy]^EFL~dDoRl{>:%');
define('SECURE_AUTH_SALT', '4y@z`iQvA8r{H2wl (qJgL(!R,.*I;t/F#<]aZwd)j-xj{P_o@Wb><p9agayH~9j');
define('LOGGED_IN_SALT',   'm2-r%|l*_V_c?@(goc+{|Z7Dk#a:0) {^wza635lBWZ#`IvD9]?j-C}SK(;M#E[X');
define('NONCE_SALT',       'oW#^Tsk~ni|61rQ>e* IWBHdK%}*) 2rd[^sZFn )KJFZ@{ M#Z>t8~a=zIv,Qy.');

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
