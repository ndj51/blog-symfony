<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // On crée le filtre "optimize_images" utilisable dans Twig
            new TwigFilter('optimize_images', [$this, 'optimizeImages'], ['is_safe' => ['html']]),
        ];
    }

    public function optimizeImages(string $content): string
    {
        // Cette fonction cherche les balises img et remplace le chemin
        // On remplace /uploads/media/ par le chemin du cache de LiipImagine
        return preg_replace_callback(
            '/<img src="\/uploads\/media\/(.*?)"/',
            function ($matches) {
                $fileName = $matches[1];
                // On construit l'URL vers le filtre 'article_view' (celui qui fait du WebP)
                return '<img src="/media/cache/resolve/article_view/uploads/media/' . $fileName . '"';
            },
            $content
        );
    }
}