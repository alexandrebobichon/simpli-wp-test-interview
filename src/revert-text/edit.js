import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ColorPalette } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { content, backgroundColor, borderColor } = attributes;

    const blockStyle = {
        backgroundColor: backgroundColor || 'transparent',
        borderColor: borderColor || 'transparent',
        borderWidth: '2px',
        borderStyle: 'solid',
        padding: '20px',
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres du style', 'simpli-block')}>
                    <p>{__('Couleur d\'arrière-plan', 'simpli-block')}</p>
                    <ColorPalette
                        value={backgroundColor}
                        onChange={(color) => setAttributes({ backgroundColor: color })}
                    />
                    <p>{__('Couleur de bordure', 'simpli-block')}</p>
                    <ColorPalette
                        value={borderColor}
                        onChange={(color) => setAttributes({ borderColor: color })}
                    />
                </PanelBody>
            </InspectorControls>
            
            <div {...useBlockProps({ style: blockStyle })}>
                <RichText
                    tagName="p"
                    value={content}
                    onChange={(content) => setAttributes({ content })}
                    placeholder={__('Hello World', 'simpli-block')}
                />
            </div>
        </>
    );
}