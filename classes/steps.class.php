<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Steps extends Generic {

    public function getSteps($count,$active){
        $steps = '<ul class="wizard-steps steps-'.$count.'">';
        for ($x=1; $x<=$count; $x++){
            if($x==$active){
                $steps = $steps.'<li class="active">';
            } else {
                $steps = $steps.'<li>';
            }
            $steps = $steps.'<div class="single-step">';
            $steps = $steps.'<span class="title">'.$x.'</span>';
            $steps = $steps.'<span class="circle">';
            if($x==$active){
                $steps = $steps.'<span class="active"></span>';
            }
            $steps = $steps.'</span>';
            if($x==$count){
                $steps = $steps.'<span class="description">Verify</span></div></li>';
            } else {
                $steps = $steps.'<span class="description">Step '.$x.'</span></div></li>';
            }
        }
        $steps = $steps.'</ul>';
		return $steps;
	}

}
$steps = new Steps();
?>