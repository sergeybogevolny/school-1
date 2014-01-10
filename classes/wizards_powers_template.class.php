<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_distribute extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {

            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            $this->add();

        }
	}

    private function add() {

	    echo "<div class='alert alert-success' id='status'>".$id."</div>";


	}

}

$wizardspowersdistribute = new Wizards_powers_distribute();
?>