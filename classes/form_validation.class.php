<?php
/*
	FILE: form_validation.class.php
	AUTHOR: risanbagja
	DATE: July 31th 2013
*/

// Load generic class to extended
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Form_validation extends Generic 
{
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected $formProperties = array();	// Hold form properties value
	protected $formFields = array();		// Hold input fields in forms
	protected $inputData = array();			// Hold value of form wizard submitted data
	protected $submitButtonText;			// Hold value of text for our submit button
	protected $resetButtonText;				// Hold value of text for our reset button

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
		// Initialize default formProperties value
		$this->formProperties = [
			'method' => 'get',	// Form method: HTTP GET
			'action' => '',		// No action file
			'id' => '',			// No elemet ID
			'class' => 'form-horizontal form-validate',	// Set class property, 'form-validate' class needed to make the design matched
		];
		// Set default text for out action button
		$this->setSubmitButtonText('Submit');
		$this->setResetButtonText('Reset');
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
	// FUNCTION TO APPEND INPUT FIELDS TO OUR FORM
	// $fields['name'] = name property for the current input field
	// $fields['label_text'] = displayed label for the current input field
	// $field['html'] = HTML element of the appended input field
	public function setFormFields($fields) {
		$this->formFields = array();

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

			// Append each imput field to our formFields class variable
			$this->formFields[] = [
				'name' => $name, 
				'label_text' => $label_text, 
				'html' => $html
			];
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO SET TEXT DISPLAYED IN OUR SUBMIT BUTTON
	public function setSubmitButtonText($text) {
		$this->submitButtonText = $text;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO SET TEXT DISPLAYED IN OUR RESET BUTTON
	public function setResetButtonText($text) {
		$this->resetButtonText = $text;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO DISPLAY FORM VALIDATION
	public function displayFormValidation() { ?>

		<form 
		  method="<?php echo $this->formProperties['method']; ?>" 
		  action="<?php echo $this->formProperties['action']; ?>" 
		  id="<?php echo $this->formProperties['id']; ?>" 
		  class="<?php echo $this->formProperties['class']; ?>">

		  	<?php for($i = 0; $i < count($this->formFields); $i++) : ?>

		  		<div class="control-group">
		  			<label class="control-label" for="<?php $this->formFields[$i]['name']?>">
		  				<?php echo $this->formFields[$i]['label_text'] ?>
		  			</label>
		  			<div class="controls">
		  				<?php echo $this->formFields[$i]['html'] ?>
		  			</div>
		  		</div>

		  	<?php endfor; ?>

			<!-- FORM CONTROL BUTTONS ////////////////////////////////////////////////////////////////////-->
			<div class="form-actions">
				<input type="submit" class="btn btn-primary" value="<?php echo $this->submitButtonText; ?>">
				<input type="reset" class="btn" value="<?php echo $this->resetButtonText; ?>">
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

		// Loop through each input field 
		foreach ($this->formFields as $field) {
			// Skip! If the current field has no 'name' property
			if (is_null($field['name'])) continue;

			$input_name = $field['name'];	// Get the current input field's name
			$input_value;					// This variable would hold submitted value
			// Use eval function to retrieve submitted value. Using $_GET or $_POST
			eval('if (isset(' . $method . '["' . $input_name . '"]' . ')) $input_value=' . $method . '["' . $input_name . '"];');
			// Append to inputData class variable
			$this->inputData["$input_name"] = $input_value;
		}

		// Return back inputData
		return $this->inputData;
	}
}