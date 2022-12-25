<?php
class ieltsWriting
{
    public function upload($i, $ids)
    {
        $upload_dir = "../file/ielts/";
        $size_bytes = 5120000;
        $limitedext = array(".docx", ".DOCX");

        $new_file = $_FILES['file' . $i];
        $file_name = $new_file['name'];
        $file_name = str_replace(' ', '_', $file_name);
        $file_tmp = $new_file['tmp_name'];
        $file_size = $new_file['size'];
        $name_file_me = $ids . '_' . date("YmdHis") . '_' . $i;
        list($namefile, $prefix) = split('[.]', $file_name);
        $new_pic_name = $name_file_me . '.' . $prefix;
        $pic_stu = $new_pic_name;
        if (!is_uploaded_file($file_tmp)) {
            $mess = '';
            $pic_stu = '';
        } else {
            $ext = strrchr($file_name, '.');
            if (!in_array(strtolower($ext), $limitedext)) {
                $mess = '<div class="panel panel-danger">
					<div class="panel-heading"><h3 class="panel-title">خطا</h3></div>
					<div class="panel-body font-lg"><h4>فرمت فایل غیرمجاز است</h4><br>لطفا فایل رایتنیگ را فقط با قالب docx ارسال نمایید.</div>
					</div>';
                $pic_stu = '';
            } else {if ($file_size > $size_bytes) {
                $mess = '<div class="panel panel-danger">
					<div class="panel-heading"><h3 class="panel-title">خطا</h3></div>
					<div class="panel-body font-lg"><h4>حجم فایل بیشتر از حد مجاز است</h4><br> حداکثر حجم مجاز برای ارسال 500 کیلو بایت می باشد.</div>
					</div>';
                $pic_stu = '';
            } else {
                if (move_uploaded_file($file_tmp, $upload_dir . $new_pic_name)) {
                    $mess = '<div class="panel panel-info">
								<div class="panel-heading"><h3 class="panel-title">پیام تایید</h3></div>
								<div class="panel-body"><h4>فایل با موفقیت آپلود گردید</h4></div></div>';
                } else {
                    $mess = '<div class="panel panel-danger">
								<div class="panel-heading"><h3 class="panel-title">خطا</h3></div>
								<div class="panel-body font-lg"><h4>آپلود فایل با خطا مواجه بوده است</h4><br> لطفا مجددا تلاش نمایید.</div></div>';
                    $pic_stu = '';
                }
            }
            }
        }
        return array($pic_stu, $mess);
    }

    public function upload_answer($i)
    {
        $uploadDir = '../file/ielts/';
        $file_name = $_FILES['userfile']['name'];
        $name_file_me = 'A_' . $i . '_' . date("YmdHis");
        list($namefile, $prefix) = split('[.]', $file_name);
        $new_pic_name = $name_file_me . '.' . $prefix;
        $uploadFile = $uploadDir . basename($new_pic_name);

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
            // Prepare remote upload data
            $uploadRequest = array(
                'fileName' => basename($uploadFile),
                'fileData' => base64_encode(file_get_contents($uploadFile)),
            );

            // Execute remote upload
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://jahanelm.com/file/answer/reciver.php');
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
            $response = curl_exec($curl);
            curl_close($curl);
            return array(true, $new_pic_name);

            // Now delete local temp file
            //  unlink($uploadFile);
        } else {
            return array(false, '');
        }
    }
}