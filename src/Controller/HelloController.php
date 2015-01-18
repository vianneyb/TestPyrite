<?php
namespace TestPyrite\Controller;

use Pyrite\Response\ResponseBag;
use Symfony\Component\HttpFoundation\Request;
use Pyrite\Layer\Executor\Executable;

class HelloController implements Executable
{

    /**
     * @param Request $request The HTTP Request
     * @param ResponseBag $bag The Bag shared by all Layers of Pyrite
     * @return string               result identifier (success / failure / whatever / ...)
     */
    public function execute(Request $request, ResponseBag $bag)
    {
        $bag->set("name", $request->get('name'));
        return "success";
    }

    public function meta(Request $request, ResponseBag $bag)
    {

        // $bag->addMeta("title",$bag->get('toto'));
        return "success";
    }

    public function errorTest(Request $request, ResponseBag $bag)
    {
        $div = 1/0;
    }
}
