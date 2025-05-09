import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <div className="sam-newsletter-form" id='sam-newsletter-form'>
                <RichText
                    tagName="h3"
                    value={attributes.title}
                    onChange={(title) => setAttributes({ title })}
                    placeholder={__('Enter title...', 'sam-newsletter')}
                />
                <RichText
                    tagName="p"
                    value={attributes.description}
                    onChange={(description) => setAttributes({ description })}
                    placeholder={__('Enter description...', 'sam-newsletter')}
                />
                <div className="sam-newsletter-fields">
                    <TextControl
                        label={__('Name', 'sam-newsletter')}
                        placeholder={__('Your name', 'sam-newsletter')}
                        disabled
                    />
                    <TextControl
                        label={__('Email', 'sam-newsletter')}
                        placeholder={__('Your email', 'sam-newsletter')}
                        type="email"
                        disabled
                    />
                </div>
                <RichText
                    tagName="button"
                    value={attributes.buttonText}
                    onChange={(buttonText) => setAttributes({ buttonText })}
                    placeholder={__('Button text...', 'sam-newsletter')}
                    className="wp-block-button__link"
                    withoutInteractiveFormatting
                />
            </div>
        </div>
    );
}