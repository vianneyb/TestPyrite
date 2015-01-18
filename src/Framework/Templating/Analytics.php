<?php

namespace Evaneos\Framework\Templating;

use Pyrite\Templating\Twig\Extension;

class Analytics implements Extension
{
    public function extend(\Twig_Environment $twig)
    {
        $twig->addFunction(new \Twig_SimpleFunction('trackEvent', array($this, 'trackEvent'), array('is_safe' => array('html'))));
    }

    public function trackEvent($params)
    {
        return ' data-tag="trackEvent" data-category="' . $params['category'] . '" data-action="' . $params['action'] . '" data-label="' . $params['label'] . '" ';
    }
}