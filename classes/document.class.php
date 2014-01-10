<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Document extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {

            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

        if (!empty($_POST['action'])){
            $action = parent::secure($_POST['action']);
            switch ($action) {
                case 'attroney':
                    $this->attroney();
                    echo $this->result;
                    return;
                case 'getattroney':
                    $this->getDocumentAttroney();
                    echo $this->result;
                    return;
                case 'setting':
                    $this->setting();
                    echo $this->result;
                    return;
                case 'getsetting':
                    $this->getDocumentSetting();
                    echo $this->result;
                    return;
               case 'dl':
                    $this->dl();
                    echo $this->result;
                    return;
                case 'getdl':
                    $this->getDocumentDl();
                    echo $this->result;
                    return;
                case 'employer':
                    $this->employer();
                    echo $this->result;
                    return;
                case 'getemployer':
                    $this->getDocumentEmployer();
                    echo $this->result;
                    return;
                case 'indemnify':
                    $this->indemnify();
                    echo $this->result;
                    return;
                case 'getindemnify':
                    $this->getDocumentIndemnify();
                    echo $this->result;
                    return;
               
			    case 'posted':
                    $this->posted();
                    echo $this->result;
                    return;
                case 'getposted':
                    $this->getDocumentPosted();
                    echo $this->result;
                    return;
			    case 'mugshot':
                    $this->mugshot();
                    echo $this->result;
                    return;
                case 'getmugshot':
                    $this->getDocumentMugshot();
                    echo $this->result;
                    return;
			    case 'supplement':
                    $this->supplement();
                    echo $this->result;
                    return;
                case 'getsupplement':
                    $this->getDocumentSupplement();
                    echo $this->result;
                    return;
					
            }
        }
        }
	}

    private function attroney() {
       
	    $name	      = $this->options['attroney-friendly-name'];
        $filename     = $this->options['attroney-upload'];
        $id           = $this->options['attrony-bond-id'];
		
		
		if($filename != '' && $name !='' ){
			$sql1 = 'SELECT  * FROM agency_bonds WHERE agency_bonds.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_attorney'];
		
			$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_bonds` SET `document_attorney` = '$document'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
    private function getDocumentAttroney() {
       
        $id        = $this->options['id'];
		$clientid  = $this->options['clientid'];
		
		$sql = 'SELECT  * FROM agency_bonds WHERE agency_bonds.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_attorney'];
		
                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						  $documentname .= '<li><a href="documents/'.$clientid.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Arronyupload()" class="document-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                         $documentname ='<li><a href="#" onclick="Arronyupload()" class="document-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
		
		$this->result = $documentname;
		
	}
	
    private function setting() {
       
	    $name	      = $this->options['setting-friendly-name'];
        $filename     = $this->options['setting-upload'];
        $id           = $this->options['setting-bond-id'];
		
		
		if($filename != '' && $name !='' ){
			$sql1 = 'SELECT  * FROM agency_bonds WHERE agency_bonds.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_setting'];
		
			$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_bonds` SET `document_setting` = '$document'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
    private function getDocumentSetting() {
       
        $id        = $this->options['id'];
		$clientid  = $this->options['clientid'];
		
		$sql = 'SELECT  * FROM agency_bonds WHERE agency_bonds.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_setting'];
		
                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						  $documentname .= '<li><a href="documents/'.$clientid.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Settingupload()" class="document-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                         $documentname ='<li><a href="#" onclick="Settingupload()" class="document-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
		
		$this->result = $documentname;
		
	}
	
	
    private function dl() {
       
	    $name	      = $this->options['dl-friendly-name'];
        $filename     = $this->options['dl-upload'];
        $id           = $this->options['dl-client-id'];
		
		
		if($filename != '' && $name !='' ){
			$sql1 = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_dl'];
		
			$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_clients` SET `document_dl` = '$document'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
    private function getDocumentDl() {
       
        $id        = $this->options['id'];
		
		$sql = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_dl'];
		
                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						  $documentname .= '<li><a href="documents/'.$id.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Dlupload()" class="dl-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                         $documentname ='<li><a href="#" onclick="Dlupload()" class="dl-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
		
		$this->result = $documentname;
		
	}
	
    private function employer() {
       
	    $name	      = $this->options['employer-friendly-name'];
        $filename     = $this->options['employer-upload'];
        $id           = $this->options['employer-client-id'];
		
		
		if($filename != '' && $name !='' ){
			$sql1 = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_employer'];
		
			$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_clients` SET `document_employer` = '$document'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
    private function getDocumentEmployer() {
       
        $id        = $this->options['id'];
		$sql = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_employer'];
		
                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						  $documentname .= '<li><a href="documents/'.$id.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Employerupload()" class="employer-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                         $documentname ='<li><a href="#" onclick="Employerupload()" class="employer-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
		
		$this->result = $documentname;
		
	}
	
	
	
    private function indemnify() {
       
	    $name	      = $this->options['indemnify-friendly-name'];
        $filename     = $this->options['indemnify-upload'];
        $id           = $this->options['indemnify-client-id'];
		
		
		if($filename != '' && $name !='' ){
			$sql1 = 'SELECT  * FROM agency_clients_references WHERE agency_clients_references.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_indemnitor'];
		
			$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_clients_references` SET `document_indemnitor` = '$document'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
    private function getDocumentIndemnify() {
       
        $id              = $this->options['id'];
        $clientid        = $this->options['clientid'];
		
		$sql = 'SELECT  * FROM agency_clients_references WHERE agency_clients_references.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_indemnitor'];
		
                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						  $documentname .= '<li><a href="documents/'.$clientid.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Indemnifyupload()" class="indemnify-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                         $documentname ='<li><a href="#" onclick="Indemnifyupload()" class="indemnify-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
		
		$this->result = $documentname;
		
	}
	
	
    private function posted() {
       
	    $name	      = $this->options['posted-friendly-name'];
        $filename     = $this->options['posted-upload'];
        $id           = $this->options['posted-client-id'];
		
		
		if($filename != '' && $name !='' ){
			$sql1 = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_posted'];
		
			$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_clients` SET `document_posted` = '$document'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
    private function getDocumentPosted() {
       
        $id              = $this->options['id'];
       // $clientid        = $this->options['clientid'];
		
		$sql = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_posted'];
		
                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						   $documentname .= '<li><a href="documents/'.$id.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Postedupload()" class="posted-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                           $documentname ='<li><a href="#" onclick="Postedupload()" class="posted-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
		
		$this->result = $documentname;
		
	}
	
	
	
    private function mugshot() {
       
	   // $name	      = $this->options['mugshot-friendly-name'];
        $filename     = $this->options['mugshot-upload'];
        $id           = $this->options['mugshot-client-id'];
		
		
		
/*			$sql1 = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
			$stmt1 = parent::query($sql1);
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$doc = $row1['document_mugshot'];
*/		
			//$document = $doc.'#'.$name.'|'.$filename;
			
			$sql = "UPDATE `agency_clients` SET `document_mugshot` = '$filename'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		
		
		
	}
	
    private function getDocumentMugshot() {
       
        $id              = $this->options['id'];
       // $clientid        = $this->options['clientid'];
		
		$sql = 'SELECT  * FROM agency_clients WHERE agency_clients.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$docu = $row['document_mugshot'];
		
/*                     if(!empty($docu)){
						  $document = array_filter(explode("#", $docu));
						  $documentname= '';
                           foreach ($document as $doc) {
							   $doc2 =  explode("|",$doc);
							   //$documentsetting[] = $doc2[0];
						   $documentname .= '<li><a href="documents/'.$id.'/root/'.$doc2[1].'" target="_blank">'.$doc2[0].'</a></li>';
						   }
						   
						   $documentname .='<li><a href="#" onclick="Postedupload()" class="posted-upload" ><i class="icon-upload"></i> Upload</a></li>' ;
					 }else{
					     
                           $documentname ='<li><a href="#" onclick="Postedupload()" class="posted-upload"><i class="icon-upload"></i> Upload</a></li>' ;
					 }
*/		
		$this->result = $docu;
		
	}
	
	
    private function supplement() {
       
        $filename     = $this->options['supplement-upload'];
        $id           = $this->options['supplement-id'];
		
		
		if($filename != ''){
			
			$sql = "UPDATE `agency_clients_references` SET `document_contract` = '$filename'  WHERE `id` = $id;";
			parent::query($sql);
			$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
		}
		
		
		
	}
	
	
	
 private function getDocumentSupplement() {
       
        $id              = $this->options['id'];
        $clientid        = $this->options['clientid'];
		
		$sql = 'SELECT  * FROM agency_clients_references WHERE agency_clients_references.id = '.$id ;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$application = $row['document_application'];
		$contract    = $row['document_contract'];
		
						  $documentname= '';
						  if(!empty($contract)){ 
						     $documentname .= '<li><a href="documents/'.$clientid.'/'.$application.'" target="_blank">Application</a></li>';
						     $documentname .= '<li><a href="documents/'.$clientid.'/'.$contract.'" target="_blank">Contract</a></li>';     
						  }else{
						 	$documentname .= '<li><a href="documents/'.$clientid.'/'.$application.'" target="_blank">Application</a></li>';

						     $documentname .= '<li><a href="javascript://"  onclick="Supplementupload()"><i class="icon-upload"></i>Upload</a></li>';						  
						  }
		
		$this->result = $documentname;
		
	}
	
}

$document = new Document();
?>