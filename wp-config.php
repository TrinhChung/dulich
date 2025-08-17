<?php
define( 'WP_CACHE', true );

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
define( 'DB_NAME', 'u586524151_0fZmL' );

/** Database username */
define( 'DB_USER', 'u586524151_amo' );

/** Database password */
define( 'DB_PASSWORD', 'Chinyeu@1994' );

/** Database hostname */
define( 'DB_HOST', '10.10.0.1' );

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
define( 'AUTH_KEY',          '0L:3`B#e$E5*dRI~gO2VP^wxffF3Jct6]iCmSu{J&lZ`7hGY}[v,ZB*udjpE(,Bz' );
define( 'SECURE_AUTH_KEY',   '/ko4{ Qc0E^~d4=GOjU)iNkM9fD42{ajn:+D=8caa^[!8z4D@8_Gq4z>c([zKGEE' );
define( 'LOGGED_IN_KEY',     't0i)R)1z&1mEbI QBlTR4<985a$etC)#u9{Y8EwCNiy9rA_a7(z#&($lrv$DON4C' );
define( 'NONCE_KEY',         '2EF-}9nDqgK;U>Ru,=XsNl~hMGqZMfYA;%7p&h^`t/RRsP<EKnZvF%5K`i%wZHG,' );
define( 'AUTH_SALT',         '96y$3X#~1`9mG$)8:#GRN6|P !;:S%rrdN4X0 B7W3Z.+wv@T,`Adk$a^0%nfmWL' );
define( 'SECURE_AUTH_SALT',  ':=6o<G(M9t/5^l#:#3|K2=kH}Ci8vSS4OK|tSYMfQJ+|0kct8:b^^i-jjkF|Y&-Y' );
define( 'LOGGED_IN_SALT',    'S|c>tW/~JyT;mV(X1#RKqJn*M6R.Eb!Dy,@Swr|1(KJBTL7#8I1;clWeYmz{Ij<o' );
define( 'NONCE_SALT',        'x.q6P}`U(~rFvBOa>])zJdx>gHA<o?+q/HYXC1r%7s`AM7aqj$g91 ~at^@`OU:8' );
define( 'WP_CACHE_KEY_SALT', '^sa >,yL:9z)vQE.94=WoL;j7v27P=1?nK{lq6SZgS<CZ+ERJn<F{xI^?ToKA,?A' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'bz_';


/* Add any custom values between this line and the "stop editing" line. */



/** === Dynamic WP_HOME / WP_SITEURL for multi-domain (Cloudflare/Nginx proxy) === */
$raw_host = null;
if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    // Cloudflare/load balancer có thể gửi nhiều host, lấy cái cuối
    $parts    = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);
    $raw_host = trim(end($parts));
} elseif (!empty($_SERVER['HTTP_HOST'])) {
    $raw_host = $_SERVER['HTTP_HOST'];
} elseif (!empty($_SERVER['SERVER_NAME'])) {
    $raw_host = $_SERVER['SERVER_NAME'];
} else {
    $raw_host = 'localhost';
}

// Chuẩn hóa host (bỏ port, lower-case)
$host = strtolower(preg_replace('/:\d+$/', '', filter_var($raw_host, FILTER_SANITIZE_STRING)));

// Nhận diện HTTPS chính xác khi đứng sau proxy/Cloudflare
$is_https = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
);

// Báo cho WordPress biết request là HTTPS thật (tránh vòng 302)
if ($is_https) { $_SERVER['HTTPS'] = 'on'; }
$scheme = $is_https ? 'https' : 'http';

/**
 * Nếu site nằm trong thư mục con, set base, ví dụ: '/blog'
 * Nếu cài ở root, để chuỗi rỗng.
 */
$base = '';

define('WP_HOME',    $scheme . '://' . $host . $base);
define('WP_SITEURL', $scheme . '://' . $host . $base);

// Bảo vệ trang quản trị dùng HTTPS (không loop vì đã set $_SERVER['HTTPS']='on' ở trên)
if (!defined('FORCE_SSL_ADMIN')) {
    define('FORCE_SSL_ADMIN', true);
}
/** === End dynamic URL === */



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

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'dd07b3661895999c8b53e43bb9ca435c' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
