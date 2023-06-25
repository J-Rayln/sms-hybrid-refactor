<?php

/**
 * Returns the full path to the base directory (the directory above the
 * publicly available folder (usually 'public')).
 *
 * @param string $path Optional. Full path to access. Do not include a leading
 *                     slash (e.g. 'help' NOT '/help').
 * @return string
 */
function base_dir(string $path): string
{
    return BASE_PATH . $path;
}

/**
 * Returns the full URL to the application.
 *
 * @param string $path Optional. Full path to access. Do not include a leading
 *                     slash (e.g. 'help' NOT '/help').
 * @return string
 */
function base_url(string $path = ''): string
{
    return $_ENV['SITE_URL'] . $path;
}

function get_config(string $key): string
{
    return $_ENV[$key];
}