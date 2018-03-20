<?php

$container = new \Core\Container\AppContainer();

//core bind
$container->set(\Core\Pipeline\PipelineInterface::class, function ($c) {
   return new \Core\Pipeline\Pipeline();
});

$container->set(\Core\Sender\SenderInterface::class, function ($c) {
    return new \Core\Sender\SimpleHtmlSender();
});

$container->set(\Core\ActionRunner\ActionRunner::class, function ($c) {
    return new \Core\ActionRunner\ActionRunner();
});

return $container;