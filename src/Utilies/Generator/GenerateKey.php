<?php

namespace GhaniniaIR\Interactive\Utilies\Generator;

use Illuminate\Foundation\Http\FormRequest;

class GenerateKey
{
    /**
     * @param FormRequest $request
     */
    public function __construct(
        protected FormRequest $request
    ) {
    }

    /**
     * generate key 
     * @return string
     */
    public function generate()
    {
        return md5(
            implode( $salt = "-=*=-", [
                $ip = $this->request->ip(),
                $userAgent = $this->request->userAgent(),
            ])
        );
    }
}
