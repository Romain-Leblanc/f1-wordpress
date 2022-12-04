<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'f1-wordpress' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '[5]8*ajf5BEy(<_Z.u0tV&6X5WLLx>,2alYw%40i|W~j*+^;@:AM6G>k:bJ>}4uH' );
define( 'SECURE_AUTH_KEY',  'HQIg^aRkAxgKTPc@F:k)+yAYi~tgp9{pnx~`aA#cAtvZxWJvwti{t0&/Bb(?T%~,' );
define( 'LOGGED_IN_KEY',    'a{{TF_HHp|3cA.L@9PC3cP!>!5(*<h:TL4Ak!I:wqR-L_f.Or*Q$-I_30r_ UTE9' );
define( 'NONCE_KEY',        '+J()RRCB8z~`&L_WY:`0=BUK?]m]Lf*vNR:gC4?f0.<2Vi/nb7wKw_yetnZ?0:f8' );
define( 'AUTH_SALT',        '$+yOtx.^c{}{S3..lGp&#K8w7-y(sQ@D}^{{NZtkz(^A<@;.sIE.dvv3#[bL>VbN' );
define( 'SECURE_AUTH_SALT', '_y%!zb1<s[8z56P`2!TO. Kr;jC0H;89DtvF,,7(WEJ$A4 ._.8+E)[/l0tU.`?&' );
define( 'LOGGED_IN_SALT',   '}l,Po@6L3OLNy8ov3J6(_0.G88_!!.x#_-qFZSGlQ/(B`PdJByAS>#@hnd.bo}Rz' );
define( 'NONCE_SALT',       '8Y*|K>|cvP3>t#bu]=i,]>5,hgJPhx%0$pSUh{j*vspJ:`5f6wblQ(D$*lDms3oO' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
