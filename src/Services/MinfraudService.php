<?php
namespace LaravelMinfraud\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use LaravelMinfraud\Contracts\MinfraudServiceInterface;
use MaxMind\MinFraud;
use MaxMind\MinFraud\Model\Score;
use Illuminate\Support\Facades\Cache;

class MinfraudService implements MinfraudServiceInterface
{
    /** @var Collection $config */
    private $config;

    /** @var MinFraud $minFraud */
    private $minFraud;

    public function __construct(Collection $config)
    {
        $this->config = $config;

        $this->minFraud = new MinFraud(
            $this->config->get('account_id'),
            $this->config->get('account_key')
        );
    }

    public function isProxiedRequest(Request $request): bool
    {
        $cacheKey = $this->hashRequest($request);

        return Cache::get($cacheKey, function() use ($request) {
            return $this->getRiskScoreValue($request);
        });
    }

    public function getRiskScoreValue(Request $request): float
    {
        return $this->getRiskScore($request)->riskScore;
    }

    public function getRiskScore(Request $request): Score
    {
        $sessionId = session_id();
        $sessionAge = fileatime(session_save_path() . '/sess_' . $sessionId);

        $minFraudRequest = $this->minFraud->withDevice([
            'ip_address' => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'accept_language' => $request->headers->get('Accept-Language'),
            'session_age' => $sessionAge,
            'session_id'  => $sessionId,
        ]);

        return $minFraudRequest->score();
    }

    private function hashRequest(Request $request): string
    {
        return md5($request->ip() . $request->userAgent() . $request->headers->get('Accept-Language'));
    }
}