<?php

namespace View\General;

use View\view;

class Title implements view
{
    static function show(array $data) : string
    {
        $output = <<<HTML
                        <div class="note note-info"><h4 class="block"><strong>{$data['title']}</h4>
                        <div class="tabbable-line">{$data['description']}</div>
                        </div>
                        HTML;
        return $output;
    }
}