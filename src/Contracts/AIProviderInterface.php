<?php
namespace SignalPilot\Contracts;
interface AIProviderInterface{public function evaluateOpportunity(array $marketData,array $settings,array $strategy=[]):array;}
