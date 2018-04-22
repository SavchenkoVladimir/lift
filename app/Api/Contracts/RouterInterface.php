<?php

namespace App\Api\Contracts;

interface RouterInterface
{
    /**
     * Executes program in accordance to a request
     */
    public function execute();
}