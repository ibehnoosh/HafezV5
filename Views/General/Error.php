<?php

namespace View\General;

use View\view;

class Error implements view
{
    static function show(array $data) : string
    {
        // TODO: Implement show() method.
        $output = <<<HTML
                        <div class="note note-danger"><strong>{$data['title']}</strong>
                        <div class="tabbable-line">{$data['description']}</div>
                        </div>
                        HTML;
        return $output;
    }
}