<?php

define('DB_NAME', '{{ DB_NAME }}');
define('DB_USER', '{{ DB_USER }}');
define('DB_PASSWORD', '{{ DB_PW }}');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

define('AUTH_KEY', 'DjqDFfs5yaqII6Rtu*X*GRITUBJ/qs^[4/erzySZ0TyCKY,.t>0ih3KZt&r9E$A%');
define('SECURE_AUTH_KEY','N8 r%1UJ5R#>^&)faeBE1]c*eVaWt !fT3H6V2YU(brKT)IUKmgr1@+foewOI6<?');
define('LOGGED_IN_KEY','AG8c,H0w%]..(6}gGZ3Vnb7ezz2_oU;ny1S1@y:}[esplT2Y>Dr64Ebh/l`s~3+:');
define('NONCE_KEY','U~z5NGSnH~wZr?;QW8ZXBk.ECFjbb])RvM).~;h$+G!QIGN;yEA2yU:3p1+{(]lF');
define('AUTH_SALT','kFVL:5&k^tv.1H=4?7/yaTw]8_SNI59i/l^6y8[`-Hggn52Ara/?Wrb?$-J4t1Rx');
define('SECURE_AUTH_SALT', 'B=u)zF>(yPL*Hx{Kl,Qep:},Q|jAQ,i`M_>tfsz]RGSz_JfZc8Y[CKj+ LA/=+XL');
define('LOGGED_IN_SALT', '%@t)jOu$X{?Qi;$Z<3?p&74LbJEiwhVHRiiEncmWOSi*IMQ9P/oQ~T2e;kg1NF6,');
define('NONCE_SALT', '$}~|o$2km=`OyJZOW$BXB`2T,B~3@<)4JIWTg8fv-XPXlRhyf]eg4)pSAa33ms7z');

define('WP_DEBUG', false);

$table_prefix = 'wp_';

if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
