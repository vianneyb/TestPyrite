<?php

namespace TestPyrite\Framework\Layer;

use Pyrite\Response\ResponseBag;
use Pyrite\Layer\AbstractLayer;
use Pyrite\Layer\Layer;

/**
 * configure layout and inject view
 * config:
 *     -
 */
class LayoutLayer extends AbstractLayer implements Layer
{
    protected function before(ResponseBag $bag)
    {

        $layout = $this->config['layout'];
        $bag->set('layout',$layout);

        // ddie($bag->getResult());
    }
}
