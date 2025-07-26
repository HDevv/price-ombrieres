<?php

/**
 * Plugin Name: Ombrière - JotForm Endpoint CSA
 * Description: Plugin permettant de finaliser les réponses saisies dans un formulaire JotForm
 * Version:     1.0
 * Author:      CSA Consultants
 * Author URI:  https://csaconsultants.fr
 * License:     GPL2
 */

// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}



/**
 * Définition du shortcode qui affichera le widget de chiffrage.
 */
function block_widg_chiffrage($atts, $content = null)
{
    $configPath = plugin_dir_path(__FILE__) . 'config.php';
    if (!file_exists($configPath)) {
        return '<p>Configuration introuvable.</p>';
    }
    include $configPath;

    $configPath = plugin_dir_path(__FILE__) . 'env.php';
    if (!file_exists($configPath)) {
        return '<p>Configuration introuvable.</p>';
    }
    include $configPath;

    $template_path = plugin_dir_path(__FILE__) . 'templates/widg_chiffrage.phtml';
    if (file_exists($template_path)) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    } else {
        return '<p>Template introuvable.</p>';
    }
}


/**
 * Définition du shortcode qui affichera le widget formulaire de test.
 */
function block_widg_test($atts, $content = null)
{
    // On a besoin du fichier env cette fois
    $configPath = plugin_dir_path(__FILE__) . 'env.php';
    if (!file_exists($configPath)) {
        return '<p>Configuration introuvable.</p>';
    }
    include $configPath;

    if ($pageTestActive) {
        // Ok
    } else {
        return '<p>Formulaire test désactivé</p>';
    }

    $template_path = plugin_dir_path(__FILE__) . 'templates/widg_test.phtml';
    if (file_exists($template_path)) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    } else {
        return '<p>Template introuvable.</p>';
    }
}

/**
 * Définition du shortcode qui affichera la page de résultats.
 */
function block_results_page($atts, $content = null)
{
    // On a besoin du fichier env cette fois
    $configPath = plugin_dir_path(__FILE__) . 'env.php';
    if (!file_exists($configPath)) {
        return '<p>Configuration introuvable.</p>';
    }
    include $configPath;

    $template_path = plugin_dir_path(__FILE__) . 'templates/results_page.phtml';
    if (file_exists($template_path)) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    } else {
        return '<p>Template de résultats introuvable.</p>';
    }
}

// Déclaration des shortcode [widg_chiffrage]
add_shortcode('widg_chiffrage', 'block_widg_chiffrage');
add_shortcode('widg_test', 'block_widg_test');
add_shortcode('results_page', 'block_results_page');

// Enregistrer les hooks pour traiter le formulaire
add_action('admin_post_process_widg_test_form', 'handle_widg_test_form');
add_action('admin_post_nopriv_process_widg_test_form', 'handle_widg_test_form');



// Ajouter les hooks pour traiter le formulaire de test
add_action('admin_post_process_widg_test_form', 'handle_widg_test_form');
add_action('admin_post_nopriv_process_widg_test_form', 'handle_widg_test_form');

/**
 * Fonction qui traite la soumission du formulaire de test
 */
function handle_widg_test_form() {
    // Activer l'affichage des erreurs pour le débogage
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // URL de la page de résultats
    $results_page_url = home_url('/resultats-chiffrage/');
    
    // Préparer les paramètres pour la page de résultats
    $params = array(
        'typeproduit' => isset($_POST['typeform']) ? sanitize_text_field($_POST['typeform']) : 'P',
        'longueur' => isset($_POST['jot_longueur_client']) ? sanitize_text_field($_POST['jot_longueur_client']) : '',
        'largeur' => isset($_POST['jot_largeur_client']) ? sanitize_text_field($_POST['jot_largeur_client']) : '',
        'matiere' => isset($_POST['niveau']) ? sanitize_text_field($_POST['niveau']) : '',
        'traverse' => isset($_POST['traverse']) ? sanitize_text_field($_POST['traverse']) : '',
        'ourlet' => isset($_POST['ourlet']) ? '1' : '0',
        'premium' => isset($_POST['premium']) ? '1' : '0',
        'quantite' => isset($_POST['quantite']) ? sanitize_text_field($_POST['quantite']) : '1',
        'prix' => number_format(floatval($_POST['jot_longueur_client']) * floatval($_POST['jot_largeur_client']) * 10, 2, '.', '')
    );
    
    // Stocker l'URL de référence pour la redirection en cas d'erreur
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : home_url();
    
    // Vérifier si les données du formulaire sont présentes
    if (!empty($_POST['typeform']) && !empty($_POST['jot_longueur_client']) && !empty($_POST['jot_largeur_client'])) {
        
        // Préparer les données pour la fonction csamail
        $_POST['typeproduit'] = isset($_POST['typeform']) ? sanitize_text_field($_POST['typeform']) : 'P';
        $_POST['longueur'] = isset($_POST['jot_longueur_client']) ? sanitize_text_field($_POST['jot_longueur_client']) : '';
        $_POST['largeur'] = isset($_POST['jot_largeur_client']) ? sanitize_text_field($_POST['jot_largeur_client']) : '';
        $_POST['matiere'] = isset($_POST['niveau']) ? sanitize_text_field($_POST['niveau']) : '';
        $_POST['traverse'] = isset($_POST['traverse']) ? sanitize_text_field($_POST['traverse']) : '';
        $_POST['ourlet'] = isset($_POST['ourlet']) ? '1' : '0';
        $_POST['premium'] = isset($_POST['premium']) ? '1' : '0';
        $_POST['nombre'] = isset($_POST['quantite']) ? sanitize_text_field($_POST['quantite']) : '1';
        
        // Calculer un prix fictif pour le test (surface x 10€)
        $surface = floatval($_POST['longueur']) * floatval($_POST['largeur']);
        $_POST['prix'] = number_format($surface * 10, 2, '.', '');
        
        $_POST['emailClient'] = isset($_POST['emailClient']) ? sanitize_email($_POST['emailClient']) : '';

        // Traiter les informations client
        $_POST['infosclient'] = '';
        if (isset($_POST['prenom'])) $_POST['infosclient'] .= sanitize_text_field($_POST['prenom']) . ' ';
        if (isset($_POST['nom'])) $_POST['infosclient'] .= sanitize_text_field($_POST['nom']) . "\n";
        if (isset($_POST['adresse'])) $_POST['infosclient'] .= sanitize_text_field($_POST['adresse']) . "\n";
        if (isset($_POST['descriptionprojet'])) $_POST['infosclient'] .= sanitize_text_field($_POST['descriptionprojet']);
        
        try {
            // Envoyer les e-mails
            csamail('mailcial');
            csamail('mailclient');
            
            // Préparer les paramètres pour la page de résultats
            $params = array(
                'typeproduit' => $_POST['typeproduit'],
                'longueur' => $_POST['longueur'],
                'largeur' => $_POST['largeur'],
                'matiere' => $_POST['matiere'],
                'traverse' => $_POST['traverse'],
                'ourlet' => isset($_POST['ourlet']) ? $_POST['ourlet'] : 0,
                'premium' => isset($_POST['premium']) ? $_POST['premium'] : 0,
                'quantite' => isset($_POST['nombre']) ? $_POST['nombre'] : 1,
                'prix' => $_POST['prix']
            );
            
            // Redirection vers la page de résultats avec les paramètres
            wp_redirect(add_query_arg($params, $results_page_url));
            exit();
        } catch (Exception $e) {
            // Afficher l'erreur
            echo '<h2>Erreur lors de l\'envoi des emails</h2>';
            echo '<p>' . $e->getMessage() . '</p>';
            echo '<p><a href="' . $referer . '">Retour au formulaire</a></p>';
            exit;
        }
    } else {
        // Rediriger vers la page précédente avec un message d'erreur
        wp_redirect(add_query_arg('form_error', '1', wp_get_referer()));
        exit;
    }
}


/**
 * Fonction commune d'envoi d'e-mails.
 * 
 * @param string $type "mailcial" pour l'envoi au commercial ou "mailclient" pour l'envoi au client.
 */


// Champs nom/prénom toujours nécessaires
//$prenom = sanitize_text_field($_POST['prenom']);
//$nom = sanitize_text_field($_POST['nom']);
//$nom_complet = trim($prenom . ' ' . $nom);

function libMatiere($intMatiere) {
    switch ($intMatiere) {
        case 1: return "Un tissage souple : agréable au toucher (pouvoir occultant 1/5)";
        case 3: return "Un tissage dense : pour une ombre naturelle (pouvoir occultant 3/5)";
        case 4: return "Un tissage ultra dense : protection maximale (pouvoir occultant 5/5)";
    }
}

function libTraverse( $intTraverse) {
    switch ($intTraverse) {
        case 1: return "Plus de 80cm";
        case 2: return "Moins de 80cm";
        case 3: return "Aucune";
    }
}
function libTypeProduit( $strTypeProduit) {
    switch ($strTypeProduit) {
        case "P": return "Pergola";
        case "R": return "Rideau";
        case "B": return "Brise-Vue";
        case "S": return "Voile Suspendu";
    }
}
function csamail($type)
{
     // On a besoin du fichier env 
    $configPath = plugin_dir_path(__FILE__) . 'env.php';
    if (!file_exists($configPath)) {
        return '<p>Configuration introuvable.</p>';
    }
    include $configPath;

    // Vérification des champs obligatoires
    if (!isset($_POST['prix']) || !isset($_POST['longueur']) || !isset($_POST['emailClient']) ) {
        wp_die("Données manquantes.");
    }
    
    // Récupérer l'URL de référence pour la redirection
    $redirect_url = isset($_POST['referer_url']) ? $_POST['referer_url'] : home_url();
    
    // Récupération des champs communs
    $mail_typeproduit = sanitize_text_field($_POST['typeproduit']);
    $mail_longueur     = sanitize_text_field($_POST['longueur']);
    $mail_largeur      = sanitize_text_field($_POST['largeur']) ;
    $mail_matiere      = intval($_POST['matiere']) ;
    $mail_traverse      = intval($_POST['traverse']) ;
    $mail_ourlet       = isset($_POST['ourlet']) ? boolval($_POST['ourlet']) : false ;
    
    $mail_jot_form_id  = sanitize_text_field($_POST['formID']) ;
    $mail_prix         = sanitize_text_field($_POST['prix']);
    $mail_mailclient = sanitize_text_field($_POST['emailClient']);
    $mail_infoClient = sanitize_text_field($_POST['infosclient']);
    $mail_premium = boolval($_POST['premium']);
    $mail_quantite = isset($_POST['nombre']) ? intval($_POST['nombre']) : 1;


    // Sélection du template et des paramètres d'e-mail selon type
    if ($type === 'mailcial') {
        ob_start();
        include plugin_dir_path(__FILE__) . 'templates/email-commercial.phtml';
        $message = ob_get_clean();
        $subject = "Projet sur mesure - formulaire internet";
        $destinataire = $cial_email;
    } elseif ($type === 'mailclient') {
        ob_start();
        include plugin_dir_path(__FILE__) . 'templates/email-client.phtml';
        $message = ob_get_clean();
        $subject = "Votre projet sur mesure - Les Ombrières De Provence";
        $destinataire = $mail_mailclient;
    } else {
        wp_die("Type d'email inconnu.");
    }


    if ($host != 'WORDPRESSNATIF') {

        // Envoi de l'e-mail via PHPMailer
        require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
        require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
        require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Port       = 587;
        $mail->Username   = $username ;
        $mail->Password   = $password;
        $mail->SMTPSecure = 'tls';
        $mail->setFrom($expediteur, $aliasExpediteur);
        $mail->addAddress($destinataire);
        $mail->Subject  = $subject;
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->Body     = $message;
        
        if (!$mail->send()) {
            wp_die("Erreur lors de l'envoi de l'e-mail" ); // si besoin de debug . $mail->ErrorInfo);
        }
        
        // Utiliser l'URL de référence pour la redirection
        if ($type === 'mailcial') {
            // envoi mail au cial ok
            wp_redirect(add_query_arg('mail_sent_commercial', '1', $redirect_url));
        } else {
            // email envoyé au client
            wp_redirect(add_query_arg('mail_sent_client', '1', $redirect_url));
        }
        exit();
    } else {
        // Mode démonstration - Simuler l'envoi d'email sans réellement l'envoyer
        if ($debug) {
            // Enregistrer le contenu de l'email dans un fichier pour vérification
            $log_file = plugin_dir_path(__FILE__) . 'email_log.html';
            $log_content = "\n\n--- Email envoyé le " . date('Y-m-d H:i:s') . " ---\n";
            $log_content .= "Destinataire: " . $destinataire . "\n";
            $log_content .= "Sujet: " . $subject . "\n";
            $log_content .= "Message: " . $message . "\n";
            file_put_contents($log_file, $log_content, FILE_APPEND);
            
            // Utiliser l'URL de référence pour la redirection
            if ($type === 'mailcial') {
                // simulation envoi mail au commercial
                wp_redirect(add_query_arg('mail_sent_commercial', '1', $redirect_url));
            } else {
                // simulation envoi mail au client
                wp_redirect(add_query_arg('mail_sent_client', '1', $redirect_url));
            }
            exit();
        } else {
            // Wordpress envoie l'email
            $headers = array('Content-Type: text/html; charset=UTF-8');

            if ( !wp_mail($destinataire, $subject, $message, $headers) ) {
                wp_die("Erreur lors de l'envoi de l'e-mail" ); // si besoin de debug . $mail->ErrorInfo);
            };

            // Utiliser l'URL de référence pour la redirection
            if ($type === 'mailcial') {
                // envoi mail au cial ok
                wp_redirect(add_query_arg('mail_sent_commercial', '1', $redirect_url));
            } else {
                // email envoyé au client
                wp_redirect(add_query_arg('mail_sent_client', '1', $redirect_url));
            }
            exit();
        }
    }
}



/**
 * Fonction commune d'ajout au panier.
 */
function csa_wc_ajoutpanier()
{

    // Pour éviter d'ajouter plusieurs fois (par ex. lors du rechargement)
    if (is_admin() || !isset($_POST['productname'])) return;


    $custom_name     = $_POST['productname'];
    $custom_price    = sanitize_text_field($_POST['price']);
    $qte = $_POST['qty'];

    // ID d’un produit WooCommerce existant (virtuel ou caché)
    $product_id = 9999; // Crée un produit conteneur avec prix à 0 si nécessaire

    // Données personnalisées à passer
    $custom_data = array(
        'nom_personnalise' => $custom_name,
        'prix_personnalise' => $custom_price,
    );

    // Vide les notices précédentes
    //wc_clear_notices();

    $resAjout = false; // WC()->cart->add_to_cart($product_id, $qte ) ; //, 0, array(), $custom_data);
    $notices = "Fonction pas en place pour le moment";

    if ($resAjout) {
        // Redirection après envoi        
        wp_redirect(add_query_arg('product_added', '1', $_SERVER['REQUEST_URI']));
    } else {

        // Récupère les notices de type "error"
        //$notices = wc_get_notices( 'error' );
       
        wp_redirect(add_query_arg('erreur', $notices, $_SERVER['REQUEST_URI']));
    }
    exit();
}

// Modifier le nom affiché
add_filter('woocommerce_cart_item_name', 'personnaliser_nom_produit_panier', 10, 3);
function personnaliser_nom_produit_panier($nom, $cart_item, $cart_item_key)
{
    if (isset($cart_item['nom_personnalise'])) {
        return $cart_item['nom_personnalise'];
    }
    return $nom;
}

// Forcer le prix personnalisé
add_action('woocommerce_before_calculate_totals', 'appliquer_prix_personnalise', 10, 1);
function appliquer_prix_personnalise($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['prix_personnalise'])) {
            $cart_item['data']->set_price($cart_item['prix_personnalise']);
        }
    }
}

// ***********************************************
// Fonctions utilitaires
// ***********************************************





function jotStringToNum($p)
{

    $tmp = preg_replace('/[^0-9]/', '', $p);

    return strval($tmp);
}
function obtenirValeur($source, $cléCherchée, $defaut = null)
{
    
    $resValeur = $defaut;
    
    foreach ($source as $cleTestée => $valtestée) {
        
        if ( strpos( strtolower($cleTestée) , strtolower($cléCherchée) ) !== false ) {
            
            // Attention ici il faut aussi vérifier que valTestée n'est pas null
            $valOk = true;
            
            switch ( gettype( $defaut) ) {
                case "array":
                    $valOk = is_array($valtestée);
                    break;
                case "string":
                    $valOk = is_string( $valtestée) && $valtestée <> "";
                    break;
                case "boolean":
                        
                    if ( is_bool( $valtestée ) ) {
                        $valOk = $valtestée;
                    } 
                    elseif ( is_string( $valtestée ) ) {
                        if ( str_contains( strtolower($valtestée), "oui") || str_contains($valtestée, "1")) {
                            $valOk = true;
                        } else {
                            $valOk = false;
                        }
                       
                    } else {
                        $valOk = $valtestée;
                    }


            }


            if ( $valOk ) {   
                
                $resValeur = $valtestée;
                break;
            }
        }


    }


    return $resValeur;
    


}
