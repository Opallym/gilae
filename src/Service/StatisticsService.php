<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class StatisticsService
{
    private string $dataFile;
    private RequestStack $requestStack;

    private array $pages = [
        'accueil' => 'Accueil',
        'apropos' => 'À propos',
        'services' => 'Services',
        'tarifs' => 'Tarifs/Pitch',
        'faq' => 'FAQ',
        'avis' => 'Avis',
        'contact' => 'Contact',
        'formulaire' => 'Formulaire',
        'mentions' => 'Mentions Légales',
        '404' => '404'
    ];

    public function __construct(string $dataFile, RequestStack $requestStack)
    {
        $this->dataFile = $dataFile;
        $this->requestStack = $requestStack;
        $this->initializeStatsFile();
    }

    private function initializeStatsFile(): void
    {
        if (!file_exists($this->dataFile)) {
            $initialStats = [];
            foreach ($this->pages as $key => $name) {
                $initialStats[$key] = 0;
            }
            
            $dir = dirname($this->dataFile);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            file_put_contents($this->dataFile, json_encode($initialStats));
        }
    }

    public function recordVisit(string $page): bool
    {
        if (!array_key_exists($page, $this->pages)) {
            return false;
        }

        $session = $this->requestStack->getSession();
        $sessionKey = 'visited_' . $page;
        
        // Éviter les doubles comptages dans la même session
        if ($session->get($sessionKey)) {
            return false;
        }

        $stats = $this->getStats();
        $stats[$page]++;
        
        file_put_contents($this->dataFile, json_encode($stats));
        $session->set($sessionKey, true);
        
        return true;
    }

    public function getStats(): array
    {
        if (!file_exists($this->dataFile)) {
            $this->initializeStatsFile();
        }
        
        return json_decode(file_get_contents($this->dataFile), true) ?: [];
    }

    public function getStatsWithPercentages(): array
    {
        $stats = $this->getStats();
        $totalVisits = array_sum($stats);
        
        $result = [];
        foreach ($this->pages as $key => $name) {
            $visits = $stats[$key] ?? 0;
            $percentage = $totalVisits > 0 ? round(($visits / $totalVisits) * 100) : 0;
            
            $result[] = [
                'key' => $key,
                'name' => $name,
                'visits' => $visits,
                'percentage' => $percentage
            ];
        }
        
        return [
            'pages' => $result,
            'total' => $totalVisits
        ];
    }

    public function getPageNames(): array
    {
        return $this->pages;
    }
}