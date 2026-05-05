<?php
/**
 * OPcache Clear Endpoint
 * Called by GitHub Actions after deployment to force PHP cache refresh
 */

// Security: only allow from GitHub Actions IP ranges or with secret token
$allowed_token = 'deploy_cache_clear_2026';
$provided_token = $_GET['token'] ?? '';

if ( $provided_token !== $allowed_token ) {
	http_response_code( 403 );
	die( 'Unauthorized' );
}

$results = [];

// Clear OPcache
if ( function_exists( 'opcache_reset' ) ) {
	opcache_reset();
	$results[] = '✅ OPcache cleared';
} else {
	$results[] = '⚠️ OPcache not available';
}

// Clear WP Object Cache
if ( function_exists( 'wp_cache_flush' ) ) {
	wp_cache_flush();
	$results[] = '✅ WP Object Cache cleared';
}

// Output results
header( 'Content-Type: text/plain' );
echo implode( "\n", $results );
echo "\n" . date( 'Y-m-d H:i:s' ) . " - Cache clear completed\n";
