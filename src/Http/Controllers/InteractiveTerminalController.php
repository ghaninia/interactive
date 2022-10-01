<?php

namespace GhaniniaIR\Interactive\Http\Controllers;

use Throwable;
use Illuminate\Routing\Controller;
use GhaniniaIR\Interactive\Utilies\Command\Table;
use GhaniniaIR\Interactive\Utilies\Generator\GenerateKey;
use GhaniniaIR\Interactive\Http\Requests\InteractiveTerminalRequest;

class InteractiveTerminalController extends Controller
{

    public function __construct()
    {
        $middlewares = config("interactive.route.middlewares" , []);
        $this->middleware($middlewares) ;
    }

    /**
     * Server-side query processing
     * @param InteractiveTerminalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(InteractiveTerminalRequest $request)
    {

        $sentence = $request->input("sentence");
        $key = (new GenerateKey($request))->generate();
        $result = (new Table)->setSentence($sentence)->setCacheKey($key)->result();
    
        return match(true) {

            $result instanceof Throwable => response()->json([
                "result" => $result->getMessage() ,
                "ok" => false
            ]) ,

            default => response()->json([
                "result" => $result
            ])

        };


    }
}
