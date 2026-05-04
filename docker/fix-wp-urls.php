<?php
$f = '/var/www/html/wp-config.php';
$c = file_get_contents($f);

if (strpos($c, 'WP_HOME') !== false) {
    echo "Ya configurado — WP_HOME ya existe en wp-config.php\n";
    exit(0);
}

$inject = <<<'PHP'

/* URL dinámica: funciona con localhost, DDNS o cualquier dominio */
$_proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
define('WP_HOME',    $_proto . '://' . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', $_proto . '://' . $_SERVER['HTTP_HOST']);

PHP;

$patched = str_replace("<?php\n", "<?php\n" . $inject, $c, $count);

if ($count === 0) {
    $patched = str_replace("<?php", "<?php\n" . $inject, $c);
}

file_put_contents($f, $patched);
echo "✅ wp-config.php parcheado — URL dinámica activada.\n";
