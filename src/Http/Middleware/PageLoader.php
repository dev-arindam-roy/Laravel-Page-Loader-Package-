<?php

namespace CreativeSyntax\PageLoader\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use CreativeSyntax\PageLoader\Traits\PageLoader as PL;

class PageLoader
{   
    use PL;

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $isActive = true;
        $color = '#0277BD';
        $publishedConfigFilePath = config_path('page-loader.php');
        if (file_exists($publishedConfigFilePath)) {
            $isActive = !empty(config('page-loader.is-active')) ? config('page-loader.is-active') : $isActive;
            $color = !empty(config('page-loader.loader-no')) ? config('page-loader.loader-no') : $color; 
        }
        if ($isActive) {
            $content = $response->getContent();
            $hiBody = '<body>';
            preg_match('/<(body|i)\s.*(class|data-id)="([^"]+)"[^>]*>/i', $content, $match);
            if (!empty($match[0])) {
                $hiBody = $match[0];
            }
            $bodyPosition = strripos($content, $hiBody);
            if (false !== $bodyPosition) {
                $bodyPosition = $bodyPosition + strlen($hiBody);
                $content = substr($content, 0, $bodyPosition) . self::loaderHtml($color) . substr($content, $bodyPosition);
                //$content = str_replace('<body','<body style="height: 100%;"', $content);
                $response->setContent($content);
            }
        }
        return $response;
    }
}