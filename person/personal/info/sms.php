<div class="page-content">
	<div class="note note-info"><strong>ارسال پیام کوتاه</strong></div>
<div class="tabbable-line">
<script src="../assets/pages/scripts/send_sms_master.js"></script>
    <div class="well hidden-print" style="min-height:120px;"><p>
			برای ارسال پیام کوتاه به پرسنل، متن پیام را درج نمایید.
			<br>
			به صورت پیش فرض پیام برای تمام پرسنل ارسال می گردد که در صورت تمایل می توانید لیست مورد نظر خود را انتخاب نمایید.
			<br></p>
			متن پیام: <input type="text" class="form-control " id="message" name="message" value="" style="width:680px;">
			<input type="hidden" name="sendig" value="yes"><button type="button" class="btn purple-studio btn-circle" name="send" id="sms_but" value="" onclick="send_sms()"><i class="fa fa-phone-square"></i>&nbsp; ارسال پیامک</button>
			</div><table class="table table-striped table-bordered sample_2">
        <tr>
            <th style="width:20px;"><input type="checkbox" id="checkall" checked onClick="checkAll()"></th>
        	<th style="width:20px;">#</th>
            <th>پرسنل</th>
            <th>تلفن همراه</th>
        </tr>
        <?php
	$res=mysql_query("SELECT `id_per`, `name_per`, `family_per`, `mobile_per` FROM `person_info` WHERE `active_per` LIKE 'yes' ORDER BY `person_info`.`family_per` ASC");
	while($row=mysql_fetch_array($res))
		{
			if($row[mobile_per]=='') {$class_chek_box='mobile_n'; $dis='disabled'; $check='';}
			else {$class_chek_box='mobile_y'; $dis=''; $check='checked';}
			$j++;
			print '<tr>
			<th><input type="checkbox" class="form-control '.$class_chek_box.'" '.$dis.'  '.$check.' name="c_'.$j.'" id="c_'.$j.'" value="'.$row[mobile_per].'"></th>
				<th>'.$j.'</th>
				<td align="right">'.$row[family_per].' '.$row[name_per].'</td>
				<td align="center" style="direction:ltr">'.$row[mobile_per].'</td>
			</tr>';
		}
	?><input name="max_i" type="hidden" value="<?=$j?>" />
        </table>
</div>
</div>