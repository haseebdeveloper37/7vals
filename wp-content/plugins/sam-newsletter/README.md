# SAM Newsletter Plugin

A WordPress plugin for collecting and managing newsletter subscriptions with a Gutenberg block.

## Features

- Custom Gutenberg block for newsletter signup forms
- AJAX form submission with client-side validation
- Dedicated admin dashboard for managing subscriptions
- Search and filter functionality
- CSV export capability
- Responsive design matching WordPress UI

## Installation

1. Download the plugin ZIP file
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Upload the ZIP file and click "Install Now"
4. Activate the plugin

## Usage

### Adding the Newsletter Form

1. Edit a post or page with the Gutenberg editor
2. Add the "SAM Newsletter" block
3. Customize the block settings (title, description, button text)
4. Publish or update the page

### Managing Subscriptions

1. Go to WordPress Admin → SAM Newsletter
2. View all subscriptions in the table
3. Use the search box to filter subscriptions
4. Click "Export CSV" to download all subscriptions

## Development

### Requirements

- WordPress 5.0+ with Gutenberg editor
- PHP 7.0+
- Node.js (for block development)

### Building the Block

1. Navigate to the plugin directory
2. Run `npm install` to install dependencies
3. Run `npm run build` to build the block assets

## Screenshots

1. [Newsletter block in the editor]
2. [Frontend newsletter form]
3. [Admin dashboard with subscriptions]

## Changelog

### 1.0.0
- Initial release