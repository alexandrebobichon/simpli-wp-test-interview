<?php

function simpli_create_custom_page() {
    add_menu_page(
        'Créer un article',
        'Créer un article',
        'edit_posts',
        'simpli-create-post',
        'simpli_render_post_form',
        'dashicons-edit',
        30
    );
}
add_action('admin_menu', 'simpli_create_custom_page');

/**
 * Fonction pour afficher le formulaire
 */
function simpli_render_post_form() {
    // Traitement du formulaire si soumis
    if (isset($_POST['simpli_submit_post'])) {
        // Vérification du nonce
        if (!isset($_POST['simpli_post_nonce']) || !wp_verify_nonce($_POST['simpli_post_nonce'], 'simpli_create_post')) {
            wp_die('Action non autorisée');
        }

        // Récupération des données du formulaire
        $post_title = sanitize_text_field($_POST['post_title']);
        $post_content = wp_kses_post($_POST['post_content']);
        $post_meta = sanitize_text_field($_POST['post_meta']);

        // Création du post
        $post_id = wp_insert_post(array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_type'     => 'post'
        ));

        // Ajout de la métadonnée
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, 'mymeta', $post_meta);
            echo '<div class="notice notice-success is-dismissible"><p>Article créé avec succès !</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Une erreur est survenue lors de la création de l\'article.</p></div>';
        }
    }

    // Affichage du formulaire
    ?>
    <div class="wrap">
        <h1>Créer un nouvel article</h1>
        <form method="post" action="">
            <?php wp_nonce_field('simpli_create_post', 'simpli_post_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th><label for="post_title">Titre</label></th>
                    <td>
                        <input type="text" id="post_title" name="post_title" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th><label for="post_content">Contenu</label></th>
                    <td>
                        <?php
                        wp_editor('', 'post_content', array(
                            'media_buttons' => true,
                            'textarea_rows' => 10
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="post_meta">Métadonnée (mymeta)</label></th>
                    <td>
                        <input type="text" id="post_meta" name="post_meta" class="regular-text" required>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="simpli_submit_post" class="button button-primary" value="Créer l'article">
            </p>
        </form>
    </div>
    <?php
}