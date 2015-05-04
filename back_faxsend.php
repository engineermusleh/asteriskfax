<?php
error_reporting(E_ALL);
	session_start();
// HELPERS -------------------
   function unique_name($path, $suffix) 
   { 
      $file = $path."/".mt_rand().$suffix; 
      return $file; 
   } 
   // error list 
   $ERROR_CONVERTING_DOCUMENT = 1; 
   $ERROR_CREATING_CALL_FILE = 2; 
   $ERROR_NO_ERROR = 0;
// END HELPERS --------------

// generate a new name for the PDF. 
$input_file_noext = unique_name("/tmp", "");
$input_file = $input_file_noext . ".pdf";
$input_file_tif = $input_file_noext . ".tif";
$input_file_doc = $input_file_noext . ".doc";
$error = $ERROR_NO_ERROR;  // no error at beginning

$script_local_path = $_REAL_BASE_DIR = realpath(dirname(__FILE__));


$input_file_orig_name = basename($_FILES['faxFile']['name']);
$ext = substr($input_file_orig_name, strrpos($input_file_orig_name, '.') + 1);


// IF it was originally a PDF 
//print_r($ext);
//print_r($_FILES);
if ($ext == "pdf")  {
	if(move_uploaded_file($_FILES['faxFile']['tmp_name'], $input_file)) {
		$input_file_type = "pdf";
	}else{
		echo "There was an error uploading the file, please try again!";
	}
}
// we should now have a PDF file which we will convert to tif 

if($error == $ERROR_NO_ERROR && $input_file_type == "pdf") {

	// convert the attached PDF to .tif using ghostsccript ... 
	$gs_command = "gs -q -dNOPAUSE -dBATCH -dSAFER -sDEVICE=tiffg3 -sOutputFile=${input_file_tif} -f $input_file " ;
	$gs_command_output = system($gs_command, $retval);
	$doc_convert_output = $gs_command_output;
	
	if ($retval != 0) {
		echo "There was an error converting your PDF file to TIF. Try uploading the file again or with an older version of PDF"; 
		$error = $ERROR_CONVERTING_DOCUMENT; 
		// die();
	}
	else  {
	
		// call the faxout.awk script to send the fax through AMI.
				
		$faxHeader = $_POST["faxHeader"];
		$callerid = $_SESSION["callerid"];
		//$email = $_POST["email"];
		$dest = $_POST["dest"];
		$faxid = uniqid();
       		$clean_dest=preg_replace('/[^0-9,]+/i', '', $dest);


		
		// ----------------------- AWK SCRIPT ------- 		// setting up the options required by faxout.awk 
		$faxout_command = $script_local_path . "/faxout.awk " . $clean_dest . " " . $input_file_tif . " " . $faxid . " " . "'".$callerid."'" . " " . "'".$faxHeader."'" . " try=1";


		
		$_SESSION['start_time']=time();
		// calling faxout.awk now 
		exec($faxout_command, $faxout_output, $retval);

$fax_op=explode(":",$faxout_output[20]);
$fax_status= $fax_op[count($fax_op)-1];
//		if ($retval != 0)
		if(strtolower($fax_status)!="success")
		{
		//	echo "Error sending Fax. Please try again.";
			echo "the fax number provided is not valid, please provide a valid 10 digit fax number.";
		}
		else {

			
			$_SESSION['faxid'] = $faxid;
			header("Location: faxstatus.php?faxid=$faxid");
			die("Redirecting to faxstatus.html");
		}

		// END call faxout.awk 
		// ------------------------------------------------------------------------------------------------------
		
		// ----------------------- END AWK SCRIPT ------- 
	}
}
if(strtolower($ext)=="tif") {
    move_uploaded_file($_FILES['faxFile']['tmp_name'], $input_file_tif);
	$faxHeader = $_POST["faxHeader"];
		$callerid = $_SESSION["callerid"];
		//$email = $_POST["email"];
		$dest = $_POST["dest"];
		$faxid = uniqid();
        $clean_dest=preg_replace('/[^0-9,]+/i', '', $dest);

		// ----------------------- AWK SCRIPT ------- 		// setting up the options required by faxout.awk 
		$faxout_command = $script_local_path . "/faxout.awk " . $clean_dest . " " . $input_file_tif . " " . $faxid . " " . "'".$callerid."'" . " " . "'".$faxHeader."'" . " try=1";

		#echo $faxout_command; 
		
		
		// calling faxout.awk now 
		exec($faxout_command, $faxout_output, $retval); 
		
		// echo $retval . " <br />\n";   // should be 0 for correct output by faxout.awk  
		// echo $faxout_output;
		
		if ($retval != 0)
		{
		//	echo "Error sending Fax. Please try again.";
			echo "the fax number provided is not valid, please provide a valid 10 digit fax number.";
		}
		else {		
			$_SESSION['faxid'] = $faxid;
			header("Location: faxstatus.php?faxid=$faxid");
			die("Redirecting to faxstatus.html");
		}
}
