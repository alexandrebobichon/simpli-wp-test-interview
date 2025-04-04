<?php

// Sortie sécurisée des attributs
$content = $attributes['content'] ?? 'Hello World';
$backgroundColor = $attributes['backgroundColor'] ?? 'transparent';
$borderColor = $attributes['borderColor'] ?? 'transparent';

// Style inline
$style = sprintf(
    'background-color: %1$s; border-color: %2$s; border-width: 2px; border-style: solid; padding: 20px;',
    esc_attr($backgroundColor),
    esc_attr($borderColor)
);

// ID unique pour le JavaScript
$unique_id = 'simpli-block-' . uniqid();
?>

<div 
    <?php echo get_block_wrapper_attributes(['style' => $style]); ?> 
    id="<?php echo esc_attr($unique_id); ?>"
    tabindex="0"
    role="button"
    aria-label="<?php esc_attr_e('Cliquez pour inverser le texte', 'simpli-block'); ?>"
>
    <p class="simpli-block-content"><?php echo esc_html($content); ?></p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const block = document.getElementById('<?php echo $unique_id; ?>');
        const content = block.querySelector('.simpli-block-content');
        
        // Fonction pour inverser le texte
        function reverseText() {
            const originalText = content.innerText;
            const reversedText = originalText.split('').reverse().join('');
            content.innerText = reversedText;
        }
        
        // Ajouter des écouteurs d'événements (souris et clavier pour l'accessibilité)
        block.addEventListener('click', reverseText);
        block.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                reverseText();
            }
        });
    });