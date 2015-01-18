<?php

namespace Evaneos\Framework\Layer;

use Pyrite\Response\ResponseBag;
use Pyrite\Layer\AbstractLayer;
use Pyrite\Layer\Layer;

class HttpHeadersLayer extends AbstractLayer implements Layer
{
    protected function after(ResponseBag $bag)
    {
        $bag->addHeader('X-Www-Pyrite', uniqid());
        $bag->addHeader('X-Human', 'Interested by HTTP headers and looking for a fun job ? We are recruiting ! -> yvan@evaneos.com');

        $ttl = isset($this->config['ttl']) ? $this->config['ttl'] : 0;
        if ($ttl && $bag->getResultCode() >= 200 && $bag->getResultCode() < 300) {
            try {
                $interval = new \DateInterval($ttl);
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf('TTL Parameter "%s" is invalid. Please refer to DateInterval doc', $ttl));
            }

            $now = new \DateTime('now', new \Datetimezone('GMT'));
            $bag->addHeader('Expires', $now->add($interval)->format('D, d M Y H:i:s') . " GMT");
        }
    }
}
