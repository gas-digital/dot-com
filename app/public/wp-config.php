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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'hj6HZriSULtKt2b09Yy+u2vbbR4+GBZFBJXWGJVziQuzTX7DCOPODkFeuK/sb2vukORfWfnok4N9NOK5pAYqkQ==');
define('SECURE_AUTH_KEY',  '6aRZYBZ2TB8XCcEbhNcgFS6Jc6cA3RqriqrPvQluDdRvaJbBcKYDqd5XQVpgy9+rL7xORXF+2NU8ecCf7SwzbQ==');
define('LOGGED_IN_KEY',    'RnKfK2anggt/lP9JXU5m2+xbCMxHadJWP5RL8XogHFMbNU68Ws2A5wmuJ24O29qkwhIgWpuKeyH8mXuHo7JixA==');
define('NONCE_KEY',        'dbBg8uhFVAl+Ire75i0oz5eidSaghti8wzSUhV52kD8cRG5KOBIr+qrMSWJ3goCbzA9s0hdfVPXruvnIMFirOg==');
define('AUTH_SALT',        '4yw/ClHYVa7k+vuwwUy/NyZQIagYCGKB8wZVsWhRy7g53UrsvlZZK+pTs0BCu50RXsE1roUI7ZjIsz5PjDZ95g==');
define('SECURE_AUTH_SALT', 'c05st/WZ0A/OHsof+v4E+mJo8/jSAF8mqOgseOghaY3HQijXCvspe4X54bgP0xtJyLyQSVvHo4Z362/z+yCsOg==');
define('LOGGED_IN_SALT',   'HBAPVwTXT2mWcb5VnGKl6jAFJJiTrnpun48sp1vYTHaxXVbzEHY9rOktVSNNx6lGAH5znhZE9Tzvd8kz6ajZsw==');
define('NONCE_SALT',       'p9lnaKLKPBHPj4QB/cIodmltd/e48c2PYt7cLqrKuBjHiOfA6XDtFqOKonrRyaDzWSXGa1gr+YFPml2wU0LX8A==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'scg_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
