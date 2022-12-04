<?php
/**
 * @package F1_PLUGIN
 */
/*
Plugin Name: F1 Plugin
Description: Plugin pour afficher des données concernant la Formule 1.
Version: 1.0
Author: LEBLANC Romain
*/

/**
 * Variables globales
 */
$arraySettingsContent['classement-pilotes'] = "Afficher la page du classement des pilotes";
$arraySettingsContent['classement-equipes'] = "Afficher la page du classement des équipes";

/* Inclus les fichiers JS dans l'en-tête de la page */
function f1_admin_head()
{
    wp_enqueue_script('script-classement-pilotes-js', plugin_dir_url(__FILE__) . '/includes/scripts/scriptClassementPilotes.js', ['jquery'], '1.0', true);
    wp_enqueue_script('script-classement-equipes-js', plugin_dir_url(__FILE__) . '/includes/scripts/scriptClassementEquipes.js', ['jquery'], '1.0', true);
    wp_enqueue_script('bootstrap-js', plugin_dir_url(__FILE__) . '/includes/bootstrap-5.1.3/js/bootstrap.min.js');
    wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__) . '/includes/bootstrap-5.1.3/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'f1_admin_head');

/* Ajoute le plugin dans le menu principal en administrateur */
function f1_admin_menu()
{
    add_menu_page('F1', 'F1_PLUGIN', 'administrator', 'f1plugin', 'f1_admin_page', 'dashicons-rest-api', 59);
}
add_action('admin_menu', 'f1_admin_menu');

/* Création du contenu admin du plugin */
function f1_admin_section_settings()
{
    global $arraySettingsContent;

    // Création section
    add_settings_section('f1_admin_section', '', null, "f1-plugin");

    // Ajout des champs
    add_settings_field('f1plugin-classement-pilotes', $arraySettingsContent['classement-pilotes'], "f1_classement_pilotes_switch", "f1-plugin", "f1_admin_section");
    add_settings_field('f1plugin-classement-equipes', $arraySettingsContent['classement-equipes'], "f1_classement_equipes_switch", "f1-plugin", "f1_admin_section");

    // Enregistrement de ces champs
    register_setting("f1_admin_section", "f1plugin-classement-pilotes");
    register_setting("f1_admin_section", "f1plugin-classement-equipes");
}

/* Formulaire administrateur du plugin */
function f1_admin_page()
{
    ?>
    <div class="container">
        <h1>Réglages du plugin F1</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields("f1_admin_section");
            do_settings_sections("f1-plugin");
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function f1_front($attr) {
    return "<h2>test affichage</h2>";
}

// Ajout du shortcode dans la liste des shortcodes
add_shortcode("f1plugin", "f1_front");