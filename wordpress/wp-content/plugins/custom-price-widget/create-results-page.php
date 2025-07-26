<?php
/**
 * Script temporaire pour créer la page de résultats
 * 
 * Ce script crée une page WordPress qui utilise le shortcode [results_page]
 * Il doit être exécuté une seule fois, puis peut être supprimé
 */

// Charger WordPress
require_once(dirname(__FILE__, 4) . '/wp-load.php');

// Vérifier si la page existe déjà
$existing_page = get_page_by_title('Résultats du chiffrage');

if (!$existing_page) {
    // Créer la page
    $page_id = wp_insert_post(array(
        'post_title'    => 'Résultats du chiffrage',
        'post_content'  => '[results_page]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_name'     => 'resultats-chiffrage'
    ));
    
    if ($page_id && !is_wp_error($page_id)) {
        echo "Page de résultats créée avec succès! ID: " . $page_id;
    } else {
        echo "Erreur lors de la création de la page: ";
        if (is_wp_error($page_id)) {
            echo $page_id->get_error_message();
        }
    }
} else {
    echo "La page 'Résultats du chiffrage' existe déjà avec l'ID: " . $existing_page->ID;
}
