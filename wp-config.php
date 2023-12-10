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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', '9c6c5a129ff5ab0d7eef5edf95d665cf');

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'Pxg)fkWDt*N#6}w<wd1`R3p,6%iey~3M|PxQJHbpo?,(?`9U(7x x{<PqLN?+5[^' );
define( 'SECURE_AUTH_KEY',   '</ {1AMJa:}`,KP{s[|PA3c=TBG=XegA4!I$by-5=&`Nh3#[-psdq{K1uvj:bL5v' );
define( 'LOGGED_IN_KEY',     '(dR-f(bYk^U.nik7*j-Xq._*yt`&6p;iCcSa}Zi#)4+kxsI}gH9ms@3O`g6qBW[]' );
define( 'NONCE_KEY',         '6KQ$5~Aa~S&~&>}=dJ%lWNzFKtb:G&fa?7l+UYpM3FN) oU*~(%Tqh#Xb(PeSxwm' );
define( 'AUTH_SALT',         '3VWZ28S5gdYiu>To[frG:<]?9`HS|F&Dc2)]N8mrPct-Zbv {M})6PYq9xmo|4I`' );
define( 'SECURE_AUTH_SALT',  'J6s%2BZl>x$ly}ledex&*.! ?[6kDX}6(uzuo]<ECI-.g[/:pnop!/qj]tM2<@?2' );
define( 'LOGGED_IN_SALT',    '9-k%%57vr& 8cc/GtadVOJ+cy-5EyG=2!.Px)?%VP7w`&*#hykq#ty4w-f:0z|s<' );
define( 'NONCE_SALT',        'zjk^jlb+49B5FAp8WVN&iJMfx>$:i9f~Kq`*,Vmj3B|Z^p} QOx2$tMk&>zL9kS^' );
define( 'WP_CACHE_KEY_SALT', 'zk.Amo&Cd[a8lEU#ZIn;yjS<b1+hA4gg(#]x[D>iR=QJsJvU~8n_jnG}&+|jnSxC' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_CACHE', true);
define('DISABLE_WP_CRON', true);

// WordPress debugging mode (for developers).
define('WP_DEBUG', false);

// WordPress update method
define('FS_METHOD', 'direct');

// WordPress update policy
define('AUTOMATIC_UPDATER_DISABLED', false);
define('WP_AUTO_UPDATE_CORE', 'minor');

// Workaround wp-cli issue with unset HTTP_HOST
// For more info  see https://github.com/wp-cli/wp-cli/issues/2431 &/or
// https://make.wordpress.org/cli/handbook/common-issues/#php-notice-undefined-index-on-_server-superglobal
if ( defined( 'WP_CLI' ) && WP_CLI && ! isset( $_SERVER['HTTP_HOST'] ) ) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}

// Single-Site (serves any hostname)
// For Multi-Site, see: https://www.turnkeylinux.org/docs/wordpress/multisite
define('WP_SITEURL', 'http://'.$_SERVER['HTTP_HOST']);
define('WP_HOME', 'http://'.$_SERVER['HTTP_HOST']);


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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
