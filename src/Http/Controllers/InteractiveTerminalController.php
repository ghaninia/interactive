<?php

namespace GhaniniaIR\Interactive\Http\Controllers;

use Closure;
use Throwable;
use Illuminate\Routing\Controller;
use GhaniniaIR\Interactive\Utilies\Command\Table;
use GhaniniaIR\Interactive\Utilies\Generator\GenerateKey;
use GhaniniaIR\Interactive\Http\Requests\InteractiveTerminalRequest;

class InteractiveTerminalController extends Controller
{

    public function __construct()
    {
        $middlewares = config("interactive.route.middlewares", []);

        $this->middleware($middlewares);

        // $this->middleware(
        //     fn($request, Closure $next) => 
        //     $next($request)
        //         ->header('Access-Control-Allow-Origin', '*')
        //         ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        //         ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin')
        // );
    }

    /**
     * get index page 
     */
    public function index()
    {
        return view("interactive::index");
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

        return match (true) {

            $result instanceof Throwable => response()->json([
                "result" => $result->getMessage(),
                "ok" => false
            ]),

            default => response()->json([
                "result" => $result
            ])

        };


    }
}