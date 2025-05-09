import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";

export default function save({ attributes }) {
	const blockProps = useBlockProps.save();

	return (
		<div {...blockProps}>
			<form className="sam-newsletter-form">
				{attributes.title && (
					<RichText.Content
						tagName="h3"
						value={attributes.title}
						className="sam-newsletter-title"
					/>
				)}
				{attributes.description && (
					<RichText.Content
						tagName="p"
						value={attributes.description}
						className="sam-newsletter-description"
					/>
				)}
				<div className="sam-newsletter-fields">
					<div className="sam-newsletter-field">
						<label htmlFor="sam-newsletter-name">
							{__("Name", "sam-newsletter")}
						</label>
						<input
							type="text"
							id="sam-newsletter-name"
							name="name"
							placeholder={__("Your name", "sam-newsletter")}
							required
						/>
						<div className="sam-newsletter-error" data-error="name"></div>
					</div>
					<div className="sam-newsletter-field">
						<label htmlFor="sam-newsletter-email">
							{__("Email", "sam-newsletter")}
						</label>
						<input
							type="email"
							id="sam-newsletter-email"
							name="email"
							placeholder={__("Your email", "sam-newsletter")}
							required
						/>
						<div className="sam-newsletter-error" data-error="email"></div>
					</div>
				</div>
				<button
					type="submit"
					className="sam-newsletter-submit wp-block-button__link"
				>
					<RichText.Content value={attributes.buttonText} />
				</button>
				<div className="sam-newsletter-message"></div>
			</form>
		</div>
	);
}
