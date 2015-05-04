<?php
	error_reporting(E_ALL);
    require("config.php");
    if(empty($_SESSION['username'])) 
    {
        header("Location: index.php");
        die("Redirecting to index.php"); 
    }
$current_timestamp=time();
$total_time=$current_timestamp-$_SESSION['start_time'];
$fax_id_number=$_GET['faxid'];
$faxFailed=false;

if($total_time>0 && !file_exists("tmp/faxlog-$fax_id_number") ){
	$faxFailed=true;
}
$fp=fopen("tmp/faxlog-$fax_id_number","r");
$line_count=0;
$email_body="";
$sendEmail=false;
while(($line = fgets($fp)) !== false) {
	$lineArray=explode(" ",$line);
	if($line_count==0){
		$email_body.="Time Start: ".$lineArray[1]."\r\n";
		$email_body.="Date Sent: ".$lineArray[0]."\r\n";
		$email_body.="Destination: ".$lineArray[7]."\r\n";        
	}
	if($line_count==1){
		$email_body.="Time Sent: ".$lineArray[1]."\r\n";
                $email_body.="Fax Status: ".$lineArray[3]."\r\n";
		$email_body.="Pages sent: ".$lineArray[count($lineArray)-1]."\r\n";
		$sendEmail=true;
	}
	$line_count++;
}

fclose($fp);
    if($sendEmail) {
        $to      = 'musleh.duet@gmail.com';
        $subject = 'Fax details from '.$_SESSION['username'];
        $message = 'Fax details';
        $headers = 'From: support@ipfinity.com' . "\r\n" .
            'Reply-To: noreply@ipfinity.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

//        mail($to, $subject, $email_body, $headers);

//	mail("support-agent@ipfinity.com", $subject, $email_body, $headers);

    }
 
?>

<!DOCTYPE html>
<html>
    
    <head>
	<!-- meta http-equiv="refresh" content="60" -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
        rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
        rel="stylesheet" type="text/css">
	<script type="text/javascript">
	$(document).ready(function() {
    	setInterval( function(){
	var faxFail='<?php echo $faxFailed;?>';
	if(parseInt(faxFail)!=1){
    		jQuery.get('tmp/faxlog-<?php  echo $fax_id_number;//echo $_SESSION['faxid']?>', function(data) {

		var str = data;
        	var myvar = str
		var parts = myvar.split(/\n/);
		var line1 = parts[0];
		var line2 = parts[1];
		$("#fax_id").html('Fax ID:'+'<?php  echo $fax_id_number;?>');
		var l1 = line1.split(" ");
//console.log(l1);
		$('#target1').html("Date transmitted: "+l1[0]);
		$('#fax_file').html("FAX File: "+l1[l1.length-1].replace("tif","pdf"));
                var l2 = line2.split(" ");
		var ll=l2[2]+" "+ l2[3];
		if(l2[2]=="undefined" || l2[2]==undefined) ll="Loading...";
		$('#target2').html("Fax result: "+ll);
		
		});

	} else{

        	$('#target1').html("Cannot send fax to this number!!");
		$('#target2').html("");
	}
    
    }, 2000);
});
	</script>
    </head>
    
    <body>
	<div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="http://www.ipfinity.com"><img src="ipfinity_logo.png" height="200" class="center-block img-responsive" width="200"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <blockquote>
		            		
                            <footer id="target">Your fax has been submitted ...</footer>
			    <footer id="target">An email will follow shortly with your fax result.</footer>
			    <footer id="fax_file"></footer>
			    <footer id="fax_id">#</footer>
			    <footer id="target1"></footer>
			    <footer id="target2">Loading</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="sendfax.php"><i class="fa fa-3x fa-fw fa-arrow-circle-left"></i></a>
                        <label>Go Back</label>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
