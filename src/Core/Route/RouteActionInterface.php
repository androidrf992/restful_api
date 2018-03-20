<?php

namespace Core\Route;

interface RouteActionInterface
{
    public function getAction();

    public function getArguments();
}