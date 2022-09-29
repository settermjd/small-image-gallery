<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container;

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->add(TwigMiddleware::create(
    $app,
    Twig::create(
        __DIR__ . '/../src/templates/',
        ['cache' => false]
    )
));

/**
 * The default route
 */
$app->map(['GET','POST'], '/',
    function (Request $request, Response $response, array $args)
    {
        return Twig::fromRequest($request)
            ->render($response, 'default.html.twig', []);
    }
);

$app->run();