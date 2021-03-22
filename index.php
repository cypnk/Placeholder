<?php 

// HTML Placeholder content (use your own)
$html	=<<<HTML
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Soon</title>
</head>
<body>
	<p>Website coming soon</p>
</body>
</html>	
HTML;

// Common headers
$headers	= [
	'X-Frame-Options: SAMEORIGIN',
	'X-XSS-Protection: 1; mode=block',
	'X-Content-Type-Options: nosniff',
	'Referrer-Policy: no-referrer, strict-origin-when-cross-origin',
	"Content-Security-Policy: default-src 'none'"
];

// Add font-src 'self'; style-src 'self'; script-src 'self' etc... 
// in content security policy if using stylesheets and scripts


/**
 *  Caution editing below
 **/

// Options header
$options	= 'Allow: GET, HEAD, OPTIONS';

// Content type header (leave as UTF-8 unless there's a good reason to change it)
$content	= 'Content-type: text/html; charset=UTF-8';

// Request method
$method		= \strtolower( \trim( $_SERVER['REQUEST_METHOD'] ?? '' ) );


/**
 *  Begin
 **/

// Scrub output buffer
\ob_clean();
\header_remove( 'Pragma' );

// This is best done in php.ini : expose_php = Off
\header( 'X-Powered-By: nil', true );
\header_remove( 'X-Powered-By' );

// This isn't succssful sometimes, but try anyway
\header_remove( 'Server' );

// Send appropriate content and end execution
switch ( $method ) {
	
	// Only send response, but nothing else
	case 'head':
		\http_response_code( 200 );
		die();
	
	// Send allowed methods
	case 'options':
		\http_response_code( 204 );
		\header( $options, true );
		die();
	
	// Send content	
	case 'get':
		\http_response_code( 200 );
		// Send common headers
		foreach ( $headers as $h ) {
			\header( $h, true );
		}
		
		// Send content header
		\header( $content, true );
		
		// End with sending HTML
		die( $html );
		
	// Send allowed methods header for everything else
	default:
		\http_response_code( 405 );
		\header( $options, true );
		die();
}

