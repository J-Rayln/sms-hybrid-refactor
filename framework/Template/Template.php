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
    private string $appName;

    public function __construct()
    {
        $this->appName = $_ENV['APP_NAME'];
    }

    /**
     * Renders the fully composed template view.  {{content}} and {{title}}
     * template tags are replaced with the page title passed to the render
     * method and the view templated called.
     *
     * If $title is provided, the value is passed through the $params array
     * and assigned a variable name of $pageTitle which can be called in the
     * template views to render the page title passed down through the
     * render method from the controller.  If null is provided for $title,
     * the variable is still created but with a null value.
     *
     * @param string      $template Template file to include as the {{content}} of
     *                              the layout view.
     * @param string|null $title    Optional. The title of the page that is
     *                              displayed in the &lt;title>&gt;&lt;/title&gt;
     *                              tags of the HTML markup.
     * @param array       $params   Optional array of parameters to be passed to
     *                              the $template.
     * @return bool|string
     */
    public function renderTemplate(string $template, ?string $title = null, array $params = []): bool|string
    {
        $params = array_merge($params, ['pageTitle' => $title]);
        $titleString = $this->renderPageTitle($title);
        $templateContent = $this->renderOnlyContent($template, $params);
        $layoutContent = $this->layoutContent();
        return str_replace(['{{content}}', '{{title}}'], [$templateContent, $titleString], $layoutContent);
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

    /**
     * Renders only the page title passed to the render method.
     *
     * @param string|null $title
     * @return string|null
     */
    protected function renderOnlyTitle(?string $title): ?string
    {
        return $title;
    }

    /**
     * Renders the full page title, if one is provided.  If no title is passed,
     * the site name is rendered alone.
     *
     * @param string|null $title Page title to be rendered
     * @return string
     */
    protected function renderPageTitle(?string $title): string
    {
        $titleString = $title ?? '';
        $separator = $title ? ' | ' : '';

        return $titleString . $separator . $this->appName;
    }
}