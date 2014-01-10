<?php
/*
	FILE: form_wizard.class.php
	AUTHOR: risanbagja
	DATE: July 30th 2013
*/

// Load generic class to extended
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Form_wizard extends Generic 
{
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected $formProperties = array();	// Hold form properties value
	protected $stepsInfo = array();			// Hold steps info that would be displayed on the form header
	protected $stepsCount = array();		// Hold total numbers of step
	protected $stepsFields = array();		// Hold input fields for each step
	protected $inputData = array();			// Hold value of form wizard submitted data

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
		// Initialize default formProperties value
		$this->formProperties = [
			'method' => 'get',	// Form method: HTTP GET
			'action' => '',		// No action file
			'id' => '',			// No elemet ID
			'class' => 'form-horizontal form-wizard',	// Set class property, 'form-wizard' class needed to make the design matched
		];
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNTION TO SET FORM PROPERTIES
	// $properties['method'] = 'POST' or 'GET'
	// $properties['id'] = Form element Id
	// $properties['class'] = Form element class
	// $properties['action'] = Form action file
	public function setFormProperties($properties) {
		// Set Form's method property
		if (isset($properties['method'])) {
			$method = strtolower( $properties['method'] );
			$method = $method == 'post' ? 'post' : 'get';
			$this->formProperties['method'] = $method;
		}

		// Set Form's element Id
		if (isset($properties['id'])) {
			$this->formProperties['id'] = $properties['id'];
		}

		// Set Form's element class
		if (isset($properties['class'])) {
			//Note that 'form-wizard' class always included
			$this->formProperties['class'] = $properties['class'] . ' form-wizard';
		}

		// Set Form's action file
		if (isset($properties['action'])) {
			$this->formProperties['action'] = $properties['action'];
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO SETUP STEPS INFO
	// $details[step number]['title'] = Title of the current step (e.g. 1, 2, 3)
	// $details[step number]['id'] = Element Id to display steps info header (e.g. 'firstStep', 'secondStep', 'lastStep')
	// $details[step number]['description'] = Description of the current step (e.g. 'Basic Info', 'Additional Info')
	// 'step number' is a positive integer value. 0 => for first step, 1 => for second step, and soon
	public function setStepsInfo($details) {
		$this->stepsInfo = array();
		// Loop through each step's details
		foreach ($details as $detail) {
			$this->stepsInfo[] = [
				'title' => $detail[0],			// Step's title
				'id' => $detail[1],				// Step's element Id
				'description' => $detail[2]		// Step's description
			];
		}
		// Set stepsCount field based on the number of a given $details
		$this->stepsCount = count($details);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO APPEND INPUT FIELDS TO EACH STEP
	// $num = number of the current step (e.g. 0 => for the first step, 1 => for the second step)
	// $fields[index]['name'] = name property for the current input field
	// $fields[index]['label_text'] = displayed label for the current input field
	// $field[index]['html'] = HTML element of the appended input field
	// 'index' is a positive integer value. 0 => for the first input filed in the current step, 1 => for the second input, and soon
	public function setStepsFields($num, $fields) {
		$this->stepsFields[$num] = array();

		// Loop through each input field
		foreach ($fields as $field) {
			// As default name and label_text is null
			$name = null;
			$label_text = null;

			// If 'name' value is set, get it!
			if (isset($field['name'])) $name = $field['name'];
			// If 'label_text' is set, get it!
			if (isset($field['label_text'])) $label_text = $field['label_text'];
			// Get HTML element of the appended input field
			$html = $field['html'];

			// Append each imput field to our stepFields class variable
			$this->stepsFields[$num][] = [
				'name' => $name, 
				'label_text' => $label_text, 
				'html' => $html
			];
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO DISPLAY FORM WIZARDS
	public function displayFormWizard() { ?>

		<form 
		  method="<?php echo $this->formProperties['method']; ?>" 
		  action="<?php echo $this->formProperties['action']; ?>" 
		  id="<?php echo $this->formProperties['id']; ?>" 
		  class="<?php echo $this->formProperties['class']; ?>">
		  	<!-- PRINT EACH STEP /////////////////////////////////////////////////////////////////////////-->
			<?php for ($i = 0; $i < $this->stepsCount; $i++) : ?>

		  		<div class="step" id="<?php echo $this->stepsInfo[$i]['id'] ?>">
		  			<!-- PRINT STEP HEADER ///////////////////////////////////////////////////////////////-->
		  			<ul class="wizard-steps steps-<?php echo $this->stepsCount; ?>">

		  			<?php for ($j = 0; $j < $this->stepsCount; $j++) : ?>

		  				<li <?php echo($i == $j ? 'class="active"' : ''); ?>>
		  					<div class="single-step">
		  						<span class="title"><?php echo $this->stepsInfo[$j]['title'] ?></span>
		  						<span class="circle"></span>
		  						<span class="description"><?php echo $this->stepsInfo[$j]['description'] ?></span>
		  					</div>
		  				</li>

		  			<?php endfor; ?>

		  			</ul>

		  			<!-- PRINT STEP FORM FIELDS //////////////////////////////////////////////////////////-->
		  			<div class="step-forms">

		  			<?php for($j = 0; $j < count($this->stepsFields[$i]); $j++) : ?>

		  				<div class="control-group">
		  					<label class="control-label" for="<?php $this->stepsFields[$i]['name']?>">
		  						<?php echo $this->stepsFields[$i][$j]['label_text'] ?>
		  					</label>
		  					<div class="controls">
		  						<?php echo $this->stepsFields[$i][$j]['html'] ?>
		  					</div>
		  				</div>

		  			<?php endfor; ?>

		  			</div>
		  		</div>

			<?php endfor; ?>

			<!-- FORM CONTROL BUTTONS ////////////////////////////////////////////////////////////////////-->
			<div class="form-actions">
				<input type="reset" class="btn" id="back">
				<input type="submit" class="btn btn-primary" id="next">
			</div>
		</form>

<?php
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO GRAB INPUTED DATA IN WIZARD FORM
	public function getInputData() {
		// Default method to retrieve inputed data
		$method = '$_GET';
		// If formProperties method is set to 'post'
		if ($this->formProperties['method'] == 'post') $method = '$_POST';

		// Clear inpuData array value
		$this->inputData = array();

		// Loop through each step
		for ($i = 0; $i < $this->stepsCount; $i++) {
			// Loop through each input field in each step
			foreach ($this->stepsFields[$i] as $field) {
				// Skip! If the current field has no 'name' property
				if (is_null($field['name'])) continue;

				$input_name = $field['name'];	// Get the current input field's name
				$input_value;					// This variable would hold submitted value
				// Use eval function to retrieve submitted value. Using $_GET or $_POST
				eval('$input_value=' . $method . '["' . $input_name . '"];');
				// Append to inputData class variable
				$this->inputData["$input_name"] = $input_value;
			}
		}

		// Return back inputData
		return $this->inputData;
	}
}