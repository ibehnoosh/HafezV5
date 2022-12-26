<?php
namespace View\Js;

class User
{
    static public function  addInfo($input)
    {
        $output= <<<JS
                    <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
                    <script src="../assets/global/plugins/jquery-validation/js/localization/messages_fa.js"></script>
                    <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
                    <script src="../assets/pages/{$input}"></script>
                    JS;

        return $output;
    }
}

