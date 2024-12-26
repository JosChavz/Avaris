<?php

namespace Middleware;

class BaseMiddleware {
    private $middlewares = [];
    
    public function add(callable $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function handle($request, $next) {
        $middleware = array_shift($this->middlewares);
        if ($middleware) {
            return $middleware($request, function($request) use ($next) {
                return $this->handle($request, $next);
            });
        }
        return $next($request);
    }
}

?>
