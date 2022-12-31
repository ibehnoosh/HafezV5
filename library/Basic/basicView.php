<?php

namespace App\Basic;

class basicView
{
    public function inputText(array $param, string $selected): string
    {
        $out='';
        ($param['temp'])? $out.=$this->showLabel($param['label']): $out.='';
        $out.='<input class="form-control '.$param['className'].'" name="'.$param['name'].'" type="text" value="'.$selected.'" '.$param['setting'].'>';
        ($param['temp'])? $out.=$this->showEndLabel(): $out.='';

        return $out;
    }
    function selectOption(array $data,array $param, string $selected): string
    {
        $out='';
        ($param['temp'])? $out.=$this->showLabel($param['label']): $out.='';
        $out.='<select name="'.$param['className'].'" class="form-control" '.$param['setting'].'>
                          <option value=""> انتخاب </option>';
        foreach ($data as $key => $value)
        {
            ($key == $selected) ? $out.='<option value="'.$key.'" serlected>'.$value.'</option>' : $out.='<option value="'.$key.'">'.$value.'</option>' ;
        }
        $out.='</select>';
        ($param['temp'])? $out.=$this->showEndLabel() : $out.='';
        return $out;
    }
    function showLabel($label): string
    {
        $label1='<div class="form-group col-md-6"><label class="col-md-4 control-label">'.$label.'</label>
                <div class="col-md-6">';
        return $label1;
    }
    function showEndLabel(): string
    {
        $label1='</div></div>';
        return $label1;
    }
    function  div(array $param):string
    {
        $label1='<div class="form-group col-md-6"><label class="col-md-4 control-label">'.$param['label'].'</label>
                <div class="col-md-6">';
        $content=$param['content'];
        $label2='</div></div>';

        $out=$label1.$content.$label1;
        return $out;
    }
}