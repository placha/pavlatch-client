<?php

namespace pavlatch\Support;

interface SupportInterface
{
    public function upload(string $filename, string $source): bool;

    public function exist(string $filename): bool;
}
