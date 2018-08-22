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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/sites/f/franchiselocal.co.uk/public_html/news/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'franchise_local');

/** MySQL database username */
define('DB_USER', 'franchisemaster');

/** MySQL database password */
define('DB_PASSWORD', 'Azjk3lsy20!8');

/** MySQL hostname */
define('DB_HOST', 'franchiselocal-db-server.cwkbzezl5tlb.eu-west-2.rds.amazonaws.com');

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
define('AUTH_KEY',         'LO.v|{nKaAaZ?85[y{1C-YK^FWdV->- 6*fy>zUJKS-?`YCvo<9$p;UUncV=tA_+');
define('SECURE_AUTH_KEY',  '_YjN%wn$q$yW#]%Vl`dyA%3jwsmr!MN|Nq@Uy@PMJBFx]iXszym~jXCkV|t37b&.');
define('LOGGED_IN_KEY',    '.JB, ;:5>z+zdU55$oo@v>>=,Ogjs?Xp8 x6{c)-6nD/t1>y2S30g?+~^Z EUhD ');
define('NONCE_KEY',        'B=pp|y<:+X|3v3nT;l*i:*mq2+EB{xq>_N{>F {!ku=D)ON*n&9(BCGb@&=t{Hii');
define('AUTH_SALT',        'wOh*`v4rMqiiJzS9nkTZ&s_q-BTdYcK7ayl.{- :{/(5-jjw2&;vj`O$O)KOXDze');
define('SECURE_AUTH_SALT', 'v{tK%wEydL99(mIXc|g2IL]6Y#Zj>=3q& #;ly6(!.TI?LDgxtsG:(gDOUi7;Nb6');
define('LOGGED_IN_SALT',   '?X8sj7cK8YvOssKB-(lv*MF&5qU$fB7SLbN5dlb%!6]p:RH+>pBD^b~b`.XAa5@g');
define('NONCE_SALT',       'tF/o>0l1nh4CHQ^$ht`74scE;<Yn0]+a4+KMY!,!wB`ed{?WIYKeo7%aNL~[uw]6');

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
