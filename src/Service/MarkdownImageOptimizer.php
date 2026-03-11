<?php

namespace App\Service;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class MarkdownImageOptimizer
{
    private $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function optimize(string $htmlContent): string
    {
        // On cherche toutes les images qui pointent vers notre dossier uploads
        return preg_replace_callback(
            '/<img src="\/uploads\/media\/(.*?)"/',
            function ($matches) {
                $fileName = $matches[1];
                $path = 'uploads/media/' . $fileName;
                
                // On génère l'URL optimisée via le filtre 'article_view' configuré tout à l'heure
                $optimizedPath = $this->cacheManager->getBrowserPath($path, 'article_view');
                
                return '<img src="' . $optimizedPath . '"';
            },
            $htmlContent
        );
    }
}