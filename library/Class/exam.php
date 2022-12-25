<?php
class exam
{
	function list_fld()
	{
		$fld=array();
		$result = mysql_query('SELECT * FROM `e_exam`, `edu_level` WHERE `level`=`id_e_level` LIMIT 0 ,1');
	  	
		for ($i = 0; $i < mysql_num_fields($result); $i++) 
		{
			$name=mysql_field_name($result, $i);
			array_push($fld,$name);
		}
		return $fld;
	}
	function show($id)//ok
	{
		$fld=array();
		$fld=$this->list_fld();
		$result = mysql_query('SELECT * FROM `e_exam`, `edu_level` WHERE `level`=`id_e_level` AND `id`= '.$id);
		$row=mysql_fetch_array($result);
		
		foreach($fld as $key =>$val)
		{
			if($row[$val]=='0000-00-00') $real_value='';
			else $real_value=$row[$val];
			
			$this->$val=$real_value;
		}
	}
	
	function save_ans($id_stu,$id_exam,$fit,$fiv)
	{
		
		preg_match('~q_(.*?)g~', $fit, $match);
		preg_match('~g_(.*?)_~', $fit, $match2);
		$id_que=$match[1];
		$id_inner=$match2[1];
		
		$value=htmlspecialchars($fiv,ENT_QUOTES);
		
		if($id_inner> 0)
		{
			$sql_search=mysql_query("SELECT * FROM `e_examan` WHERE
			`stu`=".$id_stu." AND `que`=".$id_que." AND `exam`=".$id_exam);
			$and_u=mysql_fetch_array($sql_search);
			$ansans=$and_u[ans];
			if($ansans <> '')
			{
			$periii="<".$id_inner.">";
				$ttttt=$this->replace_between($ansans,$periii);
				$new=$ttttt."-<".$id_inner.">".$value."</".$id_inner.">";
			}
				
			$sql="
			INSERT INTO `e_examan`( `stu`, `que`, `exam`, `ans`, `ip`, `when`)
			VALUES (".$id_stu.",".$id_que.",".$id_exam.",'-<".$id_inner.">".$value."</".$id_inner.">','".$_SERVER['SERVER_ADDR']."',NOW())
			ON DUPLICATE KEY UPDATE 
			`ans`='".$new."'"
				;
			mysql_query($sql);
		}
		
		else
		{
			$sql="
		INSERT INTO `e_examan`( `stu`, `que`, `exam`, `ans`, `ip`, `when`)
		VALUES (".$id_stu.",".$id_que.",".$id_exam.",'".$value."','".$_SERVER['SERVER_ADDR']."',NOW())
		ON DUPLICATE KEY UPDATE 
		`ans`='".$value."';
		";
		mysql_query($sql);
		}
		
		
	}

	function save_ans_t($id_stu,$id_exam,$fit,$fiv)
	{
		
		preg_match('~q_(.*?)g~', $fit, $match);
		preg_match('~g_(.*?)_~', $fit, $match2);
		$id_que=$match[1];
		$id_inner=$match2[1];
		
		$value=htmlspecialchars($fiv,ENT_QUOTES);
		
		if($id_inner> 0)
		{
			$sql_search=mysql_query("SELECT * FROM `e_examan_t` WHERE
			`stu`=".$id_stu." AND `que`=".$id_que." AND `exam`=".$id_exam);
			$and_u=mysql_fetch_array($sql_search);
			$ansans=$and_u[ans];
			if($ansans <> '')
			{
			$periii="<".$id_inner.">";
				$ttttt=$this->replace_between($ansans,$periii);
				$new=$ttttt."-<".$id_inner.">".$value."</".$id_inner.">";
			}
				
			$sql="
			INSERT INTO `e_examan_t`( `stu`, `que`, `exam`, `ans`, `ip`, `when`)
			VALUES (".$id_stu.",".$id_que.",".$id_exam.",'-<".$id_inner.">".$value."</".$id_inner.">','".$_SERVER['SERVER_ADDR']."',NOW())
			ON DUPLICATE KEY UPDATE 
			`ans`='".$new."'"
				;
			mysql_query($sql);
		}
		
		else
		{
			$sql="
		INSERT INTO `e_examan_t`( `stu`, `que`, `exam`, `ans`, `ip`, `when`)
		VALUES (".$id_stu.",".$id_que.",".$id_exam.",'".$value."','".$_SERVER['SERVER_ADDR']."',NOW())
		ON DUPLICATE KEY UPDATE 
		`ans`='".$value."';
		";
		mysql_query($sql);
		}
		
		
	}
	function update_ans($id_stu,$id_exam,$fit,$fiv)
	{
		
		preg_match('~q_(.*?)g~', $fit, $match);
		preg_match('~g_(.*?)_~', $fit, $match2);
		$id_que=$match[1];
		$id_inner=$match2[1];
		
		$value=htmlspecialchars($fiv,ENT_QUOTES);
		
		if($id_inner> 0)
		{
			$sql_search=mysql_query("SELECT * FROM `e_examan` WHERE
			`stu`=".$id_stu." AND `que`=".$id_que." AND `exam`=".$id_exam);
			$and_u=mysql_fetch_array($sql_search);
			$ansans=$and_u[ans];
			if($ansans <> '')
			{
			$periii="<".$id_inner.">";
				$ttttt=$this->replace_between($ansans,$periii);
				$new=$ttttt."-<".$id_inner.">".$value."</".$id_inner.">";
			}
				
			$sql="
			INSERT INTO `e_examan`( `stu`, `que`, `exam`, `ans`, `ip`, `when`)
			VALUES (".$id_stu.",".$id_que.",".$id_exam.",'-<".$id_inner.">".$value."</".$id_inner.">','".$_SERVER['SERVER_ADDR']."',NOW())
			ON DUPLICATE KEY UPDATE 
			`ans`='".$new."'";
			mysql_query($sql);
		}
		else
		{
			$sql="
		INSERT INTO `e_examan`( `stu`, `que`, `exam`, `ans`, `ip`, `when`)
		VALUES (".$id_stu.",".$id_que.",".$id_exam.",'".$value."','".$_SERVER['SERVER_ADDR']."',NOW())
		ON DUPLICATE KEY UPDATE 
		`ans`='".$value."';";
		mysql_query($sql);
		}
		
		
	}
	function replace_between($str,$ii) 
	{
			$arr = explode("-", $str);
			foreach ($arr as $key => $value) {
			if (strpos($value, $ii) !== false) {
    		$remove=$key;
				}
			}
			unset($arr[$remove]);
			$comma_separated = implode("-", $arr);
		return $comma_separated;
		}
	
	function start($stu,$exam)
	{
	 	$sql="
		INSERT INTO `e_exam_stu`(`stu`, `exam`, `start`, `ip`, `sys`)
		VALUES (".$stu.",".$exam.",NOW(),'".$_SERVER['SERVER_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."');";
		mysql_query($sql);
	}
	function start_t($stu,$exam)
	{
	 	$sql="
		INSERT INTO `e_exam_stu_t`(`stu`, `exam`, `start`, `ip`, `sys`)
		VALUES (".$stu.",".$exam.",NOW(),'".$_SERVER['SERVER_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."');";
		mysql_query($sql);
	}
	
	function over_ans($stu,$exam)
	{
		$sql="UPDATE `e_exam_stu` SET `end`=NOW() WHERE `stu`=".$stu." AND `exam`=".$exam.";";
		mysql_query($sql);
	}
	
	function over_ans2($stu,$exam)
	{
		$sql="UPDATE `e_exam_stu` SET `end`=NOW() WHERE `stu`=".$stu." AND `exam`=".$exam.";";
		mysql_query($sql);
	}
	
	function save_grade($master,$fit,$fiv)
	{
		$sql="UPDATE `e_examan` SET `gradec` = '".$fiv."' WHERE `ida`='".$fit."';";
		mysql_query($sql);
	}
	function save_grade_support($id_exam, $id_que, $value)
	{
		$sql = "
		INSERT INTO `e_quexam` (`exam`,`que`,`grade`)
		VALUES (" . $id_exam . "," . $id_que . "," . $value . ")
		ON DUPLICATE KEY UPDATE 
		`grade`=" . $value . ";";

		$logg = new logg();
		$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'Que-exam-Grade', '', $sql);

		mysql_query($sql);
	}
	function put_value($style, $idq, $answer)
	{
		$an = html_entity_decode($style);

		$input = substr_count($an, '<input');
		$checkbox = substr_count($an, '"checkbox"');
		$radio = substr_count($an, '"radio"');
		$textarea = substr_count($an, '<textarea');
		$text = substr_count($an, '"text"');

		if (($textarea > 0) && ($input == 0)) {
			$out = $this->textarea_a($an, $idq, $textarea, $answer);
		} elseif (($textarea == 0) && ($input > 0)) {
			if (($radio > 0) && ($checkbox == 0) && ($text == 0)) {
				$out = $this->input_radio_a($an, $style, $idq, $radio, $input, $answer);
			} elseif (($radio == 0) && ($checkbox == 0) && ($text > 0)) {
				$out = $this->input_text_a($an, $idq, $text, $input, $answer);
			}
		}

		return ($out);
	}

	function textarea_a($an,$idq,$textarea,$answer) //ok
	{
		$find2='<textarea name="q_'.$idq.'g_'.$i.'_"  class="form-control" disabled>'.$answer.'</textarea>';

		return $find2;
	}
	
	function input_text_a($an,$idq,$text,$input,$answer)//ok
	{
		$i=1;
		for($i;$i<=$text;$i++)
		{
			$find=$this->find_between($answer,$i);
			$name='<input name="q_'.$idq.'g_'.$i.'_"  type="text" class="form-control" onChange="save(this)"/>';
			$replace='<input name="q_'.$idq.'g_'.$i.'_"  type="text" disabled  value="'.$find.'"/>';
			
			$an=str_replace($name,$replace,$an);
		}
		
		return $an;
	}
	
	function input_radio_a($an,$an_html,$idq,$radio,$input,$answer)//ok
	{

		if($radio <=4)
		{
			$i=1;
			for($i;$i<=$radio;$i++)
			{
				if($i==$answer)
				$name='<input name="q_'.$idq.'g"  value="'.$i.'"  type="radio" checked disabled/>';
				else
				$name='<input name="q_'.$idq.'g"  value="'.$i.'"  type="radio" disabled/>';

				
				$find='<input name="q_'.$idq.'g"  value="'.$i.'"  type="radio" class="form-control" onChange="save(this)" />';


				$pos = strpos($an, $find);
				if ($pos !== false) {
					$an = substr_replace($an, $name, $pos, strlen($find));
				}
			}
		}
		else
		{
			$ttt='';
			preg_match_all('/<p>(.*?)<\/p>/s', $an, $matches);
			$result=$matches[0];
			$j=1;
			foreach( $result as $value )
			{
				$ppp=$value;
				$radio=substr_count($ppp , '"radio"');
				
				$i=1;
				for($i;$i<=$radio;$i++)
				{
					$find_between=$this->find_between($answer,$j);
					
				if($i==$find_between)
				$name='<input name="q_'.$idq.'g_'.$j.'_"  value="'.$i.'"  type="radio" class="form-control" checked/>';
				else
				$name='<input name="q_'.$idq.'g_'.$j.'_"  value="'.$i.'"  type="radio" class="form-control" />';
					
					
					$find='<input name="q_'.$idq.'g_'.$j.'_"  value="'.$i.'"  type="radio" class="form-control" onChange="save(this)"/>';


					$pos = strpos($ppp, $find);
					if ($pos !== false) {
						$ppp= substr_replace($ppp, $name, $pos, strlen($find));
					}
				}
					$ttt.=$ppp;
				$j++;
				
			}
			$an=$ttt;
		}
		
		return $an;
	}
	
	function find_between($str,$ii) 
	{
		$gg='<'.$ii.'>';
		$g2='</'.$ii.'>';
			$arr = explode("-", $str);
			foreach ($arr as $key => $value) {
			if (strpos($value, $gg) !== false) {
    				$val=$value;
				}
			}
		$val=str_replace($gg,'',$val);
		$val=str_replace($g2,'',$val);
			return $val;
	}
	function put_value_stu($style,$idq,$answer)
	{
		$an=html_entity_decode($style);

		$input=substr_count($an , '<input');
		$checkbox=substr_count($an , '"checkbox"');
		$radio=substr_count($an , '"radio"');
		$textarea=substr_count($an , '<textarea');
		$text=substr_count($an,'"text"');
		
		if(($textarea > 0)&&($input==0))
		{
			$out=$this->textarea_a2($an,$idq,$textarea,$answer);
		}
		
		elseif(($textarea == 0)&&($input>0))
		{
			if(($radio> 0) && ($checkbox==0) && ($text==0))
			{
				$out=$this->input_radio_a2($an,$style,$idq,$radio,$input,$answer);
			}
			elseif(($radio== 0) && ($checkbox > 0) && ($text==0))
			{
				$out=$this->input_check_a2($an,$idq,$checkbox,$input,$answer);
			}
			elseif(($radio== 0) && ($checkbox == 0) && ($text > 0))
			{
				$out=$this->input_text_a2($an,$idq,$text,$input,$answer);
			}
		}
		
		return($out);
	}
	
	function textarea_a2($an,$idq,$textarea,$answer) //ok
	{
		$find2='<textarea name="q_'.$idq.'g_'.$i.'_"  class="form-control"  onChange="save2(this)">'.$answer.'</textarea>';

		return $find2;
	}
	
	function input_text_a2($an,$idq,$text,$input,$answer)//ok
	{
		$i=1;
		for($i;$i<=$text;$i++)
		{
			$find=$this->find_between($answer,$i);
			$name='<input name="q_'.$idq.'g_'.$i.'_"  type="text" class="form-control" onChange="save(this)"/>';
			$replace='<input name="q_'.$idq.'g_'.$i.'_"  type="text" onChange="save2(this)"  value="'.$find.'"/>';
			
			$an=str_replace($name,$replace,$an);
		}
		
		return $an;
	}
	
	function input_radio_a2($an,$an_html,$idq,$radio,$input,$answer)//ok
	{

		if($radio <=4)
		{
			$i=1;
			for($i;$i<=$radio;$i++)
			{
				if($i==$answer)
				$name='<input name="q_'.$idq.'g"  value="'.$i.'"  type="radio" checked class="form-control"  onChange="save(this)"/>';
				else
				$name='<input name="q_'.$idq.'g"  value="'.$i.'"  type="radio" class="form-control"   onChange="save(this)"/>';

				
				$find='<input name="q_'.$idq.'g"  value="'.$i.'"  type="radio" class="form-control" onChange="save(this)" />';


				$pos = strpos($an, $find);
				if ($pos !== false) {
					$an = substr_replace($an, $name, $pos, strlen($find));
				}
			}
		}
		else
		{
			$ttt='';
			preg_match_all('/<p>(.*?)<\/p>/s', $an, $matches);
			$result=$matches[0];
			$j=1;
			foreach( $result as $value )
			{
				$ppp=$value;
				$radio=substr_count($ppp , '"radio"');
				
				$i=1;
				for($i;$i<=$radio;$i++)
				{
					$find_between=$this->find_between($answer,$j);
					
				if($i==$find_between)
				$name='<input name="q_'.$idq.'g_'.$j.'_"  value="'.$i.'"  type="radio" class="form-control" checked  onChange="save(this)"/>';
				else
				$name='<input name="q_'.$idq.'g_'.$j.'_"  value="'.$i.'"  type="radio" class="form-control" onChange="save(this)"/>';
					
					
					$find='<input name="q_'.$idq.'g_'.$j.'_"  value="'.$i.'"  type="radio" class="form-control" onChange="save(this)"/>';


					$pos = strpos($ppp, $find);
					if ($pos !== false) {
						$ppp= substr_replace($ppp, $name, $pos, strlen($find));
					}
				}
					$ttt.=$ppp;
				$j++;
				
			}
			$an=$ttt;
		}
		
		return $an;
	}

	function update($id, $fit, $fiv)
	{
		$logg = new logg();

		if ($fit == 'true') {
			$sql = "
		INSERT INTO `e_quexam` (`exam`,`que`)
		VALUES (" . $id . "," . $fiv . ")";

			$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'Que-exam-Insert', '', $sql);

			mysql_query($sql);
		} else {
			$sql = "
		DELETE FROM `e_quexam` WHERE `exam` = " . $id . " AND `que`=" . $fiv . ";";
			$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'Que-exam-Delete', $id, $sql);

			mysql_query($sql);
		}
	}
	function save_order($id_exam, $id_que, $value)
	{
		$sql = "
		INSERT INTO `e_quexam` (`exam`,`que`,`order`)
		VALUES (" . $id_exam . "," . $id_que . "," . $value . ")
		ON DUPLICATE KEY UPDATE 
		`order`=" . $value . ";";

		$logg = new logg();
		$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'Que-exam-Order', '', $sql);

		mysql_query($sql);
	}
	function update_pre_after($id, $fit, $fiv)
	{
		$sql = "UPDATE `e_quexam` SET `" . $fit . "` = '" . htmlspecialchars($fiv, ENT_QUOTES) . "' WHERE `id`='" . $id . "';";

		$logg = new logg();
		$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'Que-exam-pre', $id, $sql);

		mysql_query($sql);
	}

	function creat_answer($an_html, $idq)
	{
		$an = html_entity_decode($an_html);

		$input = substr_count($an, '<input');
		$checkbox = substr_count($an, '"checkbox"');
		$radio = substr_count($an, '"radio"');
		$textarea = substr_count($an, '<textarea>');
		$text = substr_count($an, '"text"');

		if (($textarea > 0) && ($input == 0)) {
			$out = $this->textarea($an, $idq, $textarea);
		} elseif (($textarea == 0) && ($input > 0)) {
			if (($radio > 0) && ($checkbox == 0) && ($text == 0)) {
				$out = $this->input_radio($an, $an_html, $idq, $radio, $input);
			} elseif (($radio == 0) && ($checkbox > 0) && ($text == 0)) {
				$out = $this->input_check($an, $idq, $checkbox, $input);
			} elseif (($radio == 0) && ($checkbox == 0) && ($text > 0)) {
				$out = $this->input_text($an, $idq, $text, $input);
			}
		}

		return ($out);
	}
	function input_text($an, $idq, $text, $input) //ok
	{
		$i = 1;
		for ($i; $i <= $text; $i++) {
			$find = '<input type="text" />';
			$name = '<input name="q_' . $idq . 'g_' . $i . '_"  type="text" class="form-control" onChange="save(this)"/>';


			$pos = strpos($an, $find);
			if ($pos !== false) {
				$an = substr_replace($an, $name, $pos, strlen($find));
			}
		}

		return $an;
	}
	function input_radio($an, $an_html, $idq, $radio, $input) //ok
	{

		if ($radio <= 4) {
			$i = 1;
			for ($i; $i <= $radio; $i++) {
				$find = '<input type="radio" />';
				$name = '<input name="q_' . $idq . 'g"  value="' . $i . '"  type="radio" class="form-control" onChange="save(this)" />';


				$pos = strpos($an, $find);
				if ($pos !== false) {
					$an = substr_replace($an, $name, $pos, strlen($find));
				}
			}
		} else {
			$ttt = '';
			preg_match_all('/<p>(.*?)<\/p>/s', $an, $matches);
			$result = $matches[0];
			$j = 1;
			foreach ($result as $value) {
				$ppp = $value;
				$radio = substr_count($ppp, '"radio"');

				$i = 1;
				for ($i; $i <= $radio; $i++) {


					$find = '<input type="radio" />';
					$name = '<input name="q_' . $idq . 'g_' . $j . '_"  value="' . $i . '"  type="radio" class="form-control" onChange="save(this)"/>';


					$pos = strpos($ppp, $find);
					if ($pos !== false) {
						$ppp = substr_replace($ppp, $name, $pos, strlen($find));
					}
				}
				$ttt .= $ppp;
				$j++;
			}
			$an = $ttt;
		}

		return $an;
	}

	function input_check($an, $idq, $checkbox, $input) //ok
	{
		$i = 1;
		for ($i; $i <= $checkbox; $i++) {
			$find = '<input type="checkbox" />';
			$name = '<input type="checkbox"  name="q_' . $idq . 'g[]"  value="' . $i . '"  class="form-control" onChange="save(this)">';
			$an = str_replace($find, $name, $an);
		}
		return $an;
	}

	function textarea($an, $idq, $textarea) //ok
	{
		$i = 1;
		for ($i; $i <= $textarea; $i++) {
			$find = '<textarea>';
			$name = '<textarea name="q_' . $idq . 'g_' . $i . '_"  class="form-control" onChange="save(this)">';
			$an = str_replace($find, $name, $an);
		}

		return $an;
	}

}
?>
