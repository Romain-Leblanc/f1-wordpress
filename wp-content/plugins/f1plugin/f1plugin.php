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
    // Si la page contient le shortcode et l'un des paramètres utilisé par le plugin
    if(f1_shortcode_content_exist() && f1_shortcode_inarray(f1_shortcode_getAttribute())) {
        // Les shortcodes "classement-pilotes" et "classement-equipes" n'utilisent pas de CSS personnalisé donc aucune importation nécessaire
        // Si le paramètre du shortcode est égale a une certaine valeur, on importe le fichier de style et/ou de script
        if (f1_shortcode_getAttribute() == "classement-pilotes" && get_option("f1plugin-classement-pilotes") == "activate") {
            wp_enqueue_script('script-classement-pilotes-js', plugin_dir_url(__FILE__) . '/includes/scripts/scriptClassementPilotes.js', ['jquery'], '1.0', true);
        }
        elseif (f1_shortcode_getAttribute() == "classement-equipes" && get_option("f1plugin-classement-equipes") == "activate") {
            wp_enqueue_script('script-classement-equipes-js', plugin_dir_url(__FILE__) . '/includes/scripts/scriptClassementEquipes.js', ['jquery'], '1.0', true);
        }
        wp_enqueue_script('bootstrap-js', plugin_dir_url(__FILE__) . '/includes/bootstrap-5.1.3/js/bootstrap.min.js');
        wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__) . '/includes/bootstrap-5.1.3/css/bootstrap.min.css');
    }
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
add_action("admin_init", "f1_admin_section_settings");

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
        <div>
            <h4 style="font-style: italic;">Pour afficher la page correspondante, veuillez insérer le shortcode suivant :</h4>
            <span style="color: blue;">[f1plugin page="classement-pilotes"]</span><br>
            <span>ou</span><br>
            <span style="color: blue;">[f1plugin page="classement-equipes"]</span>
        </div>
    </div>
    <?php
}

/* Retourne VRAI ou FAUX si le contenu de la page contient le nom du shortcode */
function f1_shortcode_content_exist()
{
    if (has_shortcode(get_the_content(), "f1plugin")) {
        return true;
    } else {
        return false;
    }
}

/* Champ formulaire classement pilotes */
function f1_classement_pilotes_switch()
{
    ?>
    <label class="switch">
        <input type="checkbox" name="f1plugin-classement-pilotes" value="activate" <?php checked("activate", get_option("f1plugin-classement-pilotes"), true); ?>>
    </label>
    <?php
}

/* Champ formulaire classement équipes */
function f1_classement_equipes_switch()
{
    ?>
    <label class="switch">
        <input type="checkbox" name="f1plugin-classement-equipes" value="activate" <?php checked("activate", get_option("f1plugin-classement-equipes"), true); ?>>
    </label>
    <?php
}

/* Retourne VRAI ou FAUX si le shortcode de la page fait parti de la liste des shortcodes du plugin */
function f1_shortcode_inarray($shortcodeName)
{
    global $arraySettingsContent;

    // Échange les clés et valeurs
    $tableauNomShortcode = array_flip($arraySettingsContent);

    if (in_array($shortcodeName, $tableauNomShortcode)) {
        return true;
    } else {
        return false;
    }
}

/* Récupère la valeur de l'attribut "page" du shortcode */
function get_attribute($tag, $text)
{
    // Récupère l'expression régulière du shortcode
    preg_match_all( '/' . get_shortcode_regex() . '/s', $text, $matches );
    $out = array();;
    if(isset($matches[2]))
    {
        // Si la clé n°2 est définie, on boucle dessus
        foreach( (array) $matches[2] as $key => $value )
        {
            // Si le nom du shortcode du plugin est égal à celui du nom du shortcode en paramètre
            if($tag === $value) {
                // On récupère la liste des shortcodes sous la forme clé "page" = valeur "classement-equipes"
                $out[] = shortcode_parse_atts($matches[3][$key]);
            }
        }
    }
    // On retourne ce tableau multidimensionnel
    return $out[0];
}

/* Extrait la valeur de l'attribut du shortcode puis la retourne */
function f1_shortcode_getAttribute()
{
    $key = "page";
    $value = "";

    // Récupère les attributs du shortcode sous la forme page = classement-equipes
    $arrayAttr = get_attribute("f1plugin", strip_tags(get_the_content()));

    // Vérifie si la clé du tableau contient l'attribut "page"
    if(!empty($arrayAttr) && $arrayAttr !== null) {
        if(array_key_exists($key, $arrayAttr)) {
            $value = $arrayAttr[$key];
        }
    }
    return $value;
}

/* Affichage HTML */
function f1_front($attr) {
    $html = "";

    if(isset($attr['page']) && trim($attr['page']) != "") {
        // Si le contenu de la page contient le shortcode, l'un des paramètres du shortcode et qu'il soit écrit sous la forme [f1plugin name="<nom_page>" ]
        if (f1_shortcode_content_exist() && f1_shortcode_inarray($attr['page']) && f1_shortcode_getAttribute() === $attr['page']) {

            // Le contenu des pages est généré avec les scripts importés correspondant à la page

            // Si la page appelée est le classement des pilotes
            if ($attr['page'] == "classement-pilotes") {
                // Si l'option est cochée en admin et que l'utilisateur n'est pas en train de visualiser la page côté administrateur, on retourne son contenu
                if (get_option("f1plugin-classement-pilotes") == "activate" && !is_admin() && empty($_GET['action'])) {
                    $html = "<table id='table' class='table'><thead>";
                    $html .= "<tr><th scope='col'>Position</th><th scope='col'>Pilote</th><th scope='col'>Date naissance</th><th scope='col'>Voiture</th><th scope='col'>PTS</th></tr></thead><tbody id='tbody'>";
                    $html .= "</tbody></table>";
                }
                // Sinon, on affiche un message d'erreur
                elseif (get_option("f1plugin-classement-pilotes") == "") {
                    $html = f1_page_disabled();
                }
            }
            // Sinon si la page appelée est le classement des équipes
            elseif ($attr['page'] == "classement-equipes") {
                // Si l'option est cochée en admin et que l'utilisateur n'est pas en train de visualiser la page côté administrateur, on retourne son contenu
                if (get_option("f1plugin-classement-equipes") == "activate" && !is_admin() && empty($_GET['action'])) {
                    $html = "<table id='table' class='table'><thead>";
                    $html .= "<tr><th scope='col'>Position</th><th scope='col'>Équipes</th><th scope='col'>PTS</th></tr></thead><tbody id='tbody'>";
                    $html .= "</tbody></table>";
                }
                // Sinon, on affiche un message d'erreur
                elseif (get_option("f1plugin-classement-equipes") == "") {
                    $html = f1_page_disabled();
                }
            }
        }
        // Sinon si la page contient seulement le shortcode mais que le reste indiqué est incorrect, on affiche un message
        elseif (f1_shortcode_content_exist()) {
            if (!is_admin() && empty($_GET['action'])) {
                $html = f1_page_attribute_error();
            }
        }
    }
    // Sinon si la page contient seulement le shortcode mais que le reste indiqué est incorrect, on affiche un message
    elseif (f1_shortcode_content_exist()) {
        if (!is_admin() && empty($_GET['action'])) {
            $html = f1_page_attribute_error();
        }
    }
    return $html;
}

/* Retourne une erreur que la page voulue est désactivée en administrateur */
function f1_page_disabled() {
    return "<p>Pour afficher cette page du plugin, veuillez l'activer côté administrateur.</p>";
}

/* Retourne une erreur que l'attribut du plugin n'est pas correct */
function f1_page_attribute_error() {
    return "<p>Le shortcode du plugin est correct mais son paramètre saisi ne l'est pas.<br>Veuillez à ce que l'écriture du shortcode soit constitué de la façon précisée dans les paramètres du plugin.</p>";
}

/* Ajout du shortcode dans la liste des shortcodes */
add_shortcode("f1plugin", "f1_front");