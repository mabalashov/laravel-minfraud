<?php
namespace LaravelMinfraud\Middlewares;

use Closure;
use LaravelMinfraud\Contracts\MinfraudServiceInterface;
use LaravelMinfraud\Exceptions\ProxiesNotAllowedException;

class MinfraudDenyProxiesMiddleware
{
    /** @var MinfraudServiceInterface $minfraudService */
    private $minfraudService;

    public function __construct(MinfraudServiceInterface $minfraudService)
    {
        $this->minfraudService = $minfraudService;
    }

    public function handle($request, Closure $next)
    {
        if (!config('minfraud.enabled')) {
            return $next($request);
        }

        $isProxy = false;

        try {
            $isProxy = $this->minfraudService->isProxiedRequest($request);
        } catch (\Throwable $exception) {
            return $next($request);
        }

        if ($isProxy) {
            throw new ProxiesNotAllowedException;
        }

        return $next($request);
    }
}