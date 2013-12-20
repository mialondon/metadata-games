<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/miaridge/museumgames.org.uk/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'gameswp');

/** MySQL database username */
define('DB_USER', 'gameswp');

/** MySQL database password */
define('DB_PASSWORD', '377qRH46!Ta');

/** MySQL hostname */
define('DB_HOST', 'mysql.museumgames.org.uk');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'F&/+gy+W2t>odk]/OXM!oYMfrqT%Go|L-{M|X1pl3=1n^T Sx%Yzlgpa:UQ{m5h&');
define('SECURE_AUTH_KEY',  '#`PP7uxY+@Z]c0@tnY>L-6i[M63;V>{xDJL-+!9df^d/a9vs*DhrG^|YOPvnV+uY');
define('LOGGED_IN_KEY',    'VjZ<+O&O<|>l)pn`FUDo6}iu=~=Si=8-ycje,Gjm8ORmaXz2Cc7SEX9]1(2Ma-WC');
define('NONCE_KEY',        'r$!Un4OPl}8~)5>)nRX]U?YU:?JR#ZM #9-D9P||H<oQv_[F|}.X,xs@eI/EJ^2m');
define('AUTH_SALT',        'XpI885w3@Ruq^-R hI>xk+MX5E^Xtsb,,{L&uD7u~yPk8>&AXp47+OG>U[<NCKoK');
define('SECURE_AUTH_SALT', ';L+r&5%fZRxu43}%&2X*ETG|Q&vF?ng`}k8lMsAN;uBFz9JMAFJ[lkS(DE_>UQAC');
define('LOGGED_IN_SALT',   ' |f`+$6}Ga4b]@8z^];W|_/+P[YM9O5Y+.LB.HM^wLIdA*_HIp0`-TL?i+M(kU62');
define('NONCE_SALT',       '+BD7<5q-wHf,i[#E{aEl+v7.dA,$wyAO|X[>V9%CR0}{|MrN{g$-B%bj&|1)8zsV');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
