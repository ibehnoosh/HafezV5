<?php
class timeguide
{
    public function upload()
    {
        $upload_dir = "../file/timeguide/";
        $size_bytes = 10240000000;
        $limitedext = array(".jpg", ".jpeg", ".mp3", ".zip", ".rar", ".pdf");
        //****************************************************
        for ($i = 1; $i <= 1; $i++) {
            //define variables to hold the values.
            $new_file = $_FILES['file' . $i];
            $file_name1 = $new_file['name'];
            //to remove spaces from file name we have to replace it with "_".
            $file_name = str_replace(' ', '_', $file_name1);
            $file_tmp = $new_file['tmp_name'];
            $file_size = $new_file['size'];

            $number = date("Ymd") . date("His");
            $namefile = preg_split('/[.]/', $file_name, -1);
            print_r($namefile);
            $items = count($namefile);
            $prefix = strtolower($namefile[$items - 1]);
            $new_pic_name = $number . '.' . $prefix;
            #-----------------------------------------------------------#
            # this code will check if the files was selected or not.    #
            #-----------------------------------------------------------#

            if (!is_uploaded_file($file_tmp)) {
                if ($i == 1) {
                    $new_pic_name = 'no';
                }
            } else {
                #-----------------------------------------------------------#
                # this code will check file extension                       #
                #-----------------------------------------------------------#

                $ext = strrchr($file_name, '.');
                if (!in_array(strtolower($ext), $limitedext)) {

                    $error_message = 'فرمت فایل' . '<b>';
                    $error_message .= "($file_name)</b>";
                    $error_message .= '.مجاز نمی باشد ';

                    if ($i == 1) {
                        $new_pic_name = 'no';
                    }
                } else {
                    #-----------------------------------------------------------#
                    # this code will check file size is correct                 #
                    #-----------------------------------------------------------#

                    if ($file_size > $size_bytes) {

                        $error_message = 'حجم فایل' . '<b>';
                        $error_message .= "($file_name)</b>";
                        $error_message .= 'بیشتر از <b>' . $size_bytes / 1024 . "</b> KB است.";

                        if ($i == 1) {
                            $new_pic_name = 'no';
                        }
                    } else {
                        if (move_uploaded_file($file_tmp, $upload_dir . $new_pic_name)) {
                            echo "";
                        } else {
                            $error_message = 'آپلود فایل ($file_name) خطا داشت';
                            if ($i == 1) {
                                $new_pic_name = 'no';
                            }
                        } #end of (move_uploaded_file).
                    } #end of (file_size).

                } #end of (limitedext).

            } #end of (!is_uploaded_file).

            if ($i == 1) {
                $file1 = $new_pic_name;
                $state1 = $new_pic_name;
                $file1_name = $file_name1;
            }
        } #end of (for loop).

        return array($file1, $file1_name, $state1, $error_message);
    }
}