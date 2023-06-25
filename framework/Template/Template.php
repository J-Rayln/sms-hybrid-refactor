<?php

namespace JonathanRayln\Framework\Template;

use JonathanRayln\Framework\Http\Application;

/**
 * Class Template
 *
 * @package JonathanRayln\Framework\Template;
 */
class Template
{
    public const DEFAULT_LAYOUT = 'default';
    public const DEFAULT_ERROR_TEMPLATE = 'error';
    private const TEMPLATE_EXTENSION = '.phtml';

    /**
     * Renders the fully composed template view.
     *
     * @param string $template Template file to include as the {{content}} of
     *                         the layout view.
     * @param array  $params   Optional array of parameters to be passed to the
     *                         $template.
     * @return bool|string
     */
    public function renderTemplate(string $template, array $params = []): bool|string
    {
        $templateContent = $this->renderOnlyContent($template, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $templateContent, $layoutContent);
    }

    /**
     * Renders the layout wrapper for the fully composed view.
     *
     * @return bool|string
     */
    protected function layoutContent(): bool|string
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::TEMPLATE_DIR . 'layouts/' . $layout . self::TEMPLATE_EXTENSION;
        return ob_get_clean();
    }

    /**
     * Renders just the content that will replace the {{content}} tag in the
     * layout view template.
     *
     * @param string $template Template to be called.  Do not include the leading
     *                         slash or the file extension.
     * @param array  $params   Optional associative array of parameters to be
     *                         passed to the final composed template rendering.
     * @return bool|string
     */
    protected function renderOnlyContent(string $template, array $params): bool|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::TEMPLATE_DIR . $template . self::TEMPLATE_EXTENSION;
        return ob_get_clean();
    }
}