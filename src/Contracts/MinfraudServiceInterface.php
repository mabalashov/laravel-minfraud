<?php
namespace LaravelMinfraud\Contracts;

use Illuminate\Http\Request;
use MaxMind\MinFraud\Model\Score;

interface MinfraudServiceInterface
{
    public function isProxiedRequest(Request $request): bool;

    public function getRiskScoreValue(Request $request): float;

    public function getRiskScore(Request $request): Score;
}