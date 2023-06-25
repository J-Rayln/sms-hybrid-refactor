<?php

namespace JonathanRayln\Framework\Http;

use JonathanRayln\Framework\Template\Template;

/**
 * Class Controller
 *
 * @package JonathanRayln\Framework\Http;
 */
class Controller
{
    /** @var string The default layout as defined in \Framework\Template\Template */
    public string $layout = Template::DEFAULT_LAYOUT;

    /**
     * Renders the fully composed template view.
     *
     * @param string $template Template file to include as the {{content}} of
     *                         the layout view.
     * @param array  $params   Optional array of parameters to be passed to the
     *                         $template.
     * @return $this
     */
    public function render(string $template, array $params = []): static
    {
        echo Application::$app->template->renderTemplate($template, $params);
        return $this;
    }

    /**
     * Sets the layout to be used instead of the default layout defined.  Call
     * in the action method of the controller with `$this->setLayout($layout)`
     * prior to rendering the template.
     *
     * @param string $layout
     * @return void
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
}