<?php
// This file is generated. Do not modify it manually.
return array(
	'sam-newsletter' => array(
		'apiVersion' => 2,
		'name' => 'sam-newsletter/newsletter',
		'title' => 'SAM Newsletter',
		'category' => 'widgets',
		'description' => 'A newsletter subscription form.',
		'textdomain' => 'sam-newsletter',
		'attributes' => array(
			'title' => array(
				'type' => 'string',
				'default' => 'Subscribe to our newsletter'
			),
			'description' => array(
				'type' => 'string',
				'default' => 'Stay updated with our latest news and offers.'
			),
			'buttonText' => array(
				'type' => 'string',
				'default' => 'Subscribe'
			),
			'successMessage' => array(
				'type' => 'string',
				'default' => 'Thank you for subscribing!'
			)
		),
		'editorScript' => 'file:./index.js',
		'script' => 'file:./save.js',
		'style' => 'file:./save.css'
	)
);
