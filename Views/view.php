<?php

namespace View;

Interface view
{
    static function show(array $data) : string;
}