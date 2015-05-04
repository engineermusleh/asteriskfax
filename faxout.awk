#!/usr/bin/gawk -f

BEGIN {
#	sendMail("brainbangladesh@gmail.com",1);
	MAXTRY=3; #maximum tries allowed
	#if(ARGC < 7 || ARGC > 8) {
	#	invokedie();
	#}
	phone = ARGV[1]; 
	if(length(phone) != 10) { print "1"; invokedie(); }
	faxtiff = ARGV[2];
	if(faxtiff !~ /^\/tmp\//) {print "2"; invokedie(); }
	transid = ARGV[3];
	if(transid ~ /^[ \t]*$/) { invokedie(); }
	callerid = ARGV[4];
	faxheader = ARGV[5];
	faxuser= ARGV[6];
	faxemail=ARGV[7];
print faxuser " " faxemail;
	if((ARGC == 9) && (ARGV[8] ~ /^try=/))
	{ 
	try=ARGV[8]; 
	sub(/^try=/, "", try);
	try += 0;
	delete ARGV[6];
	}
	else invokedie();
	delete ARGV[1]; delete ARGV[2]; delete ARGV[3]; delete ARGV[4]; delete ARGV[5];
	if(try < 1) 
	{
	print "Invalid try value"; 
	invokedie();
	}

	if(try < 1) {print "Invalid try value"; invokedie();}
        if(try>MAXTRY) try=MAXTRY;

        ami="/inet/tcp/0/127.0.0.1/5038";


;
	print "**Logging in"
       	logincmd="action: login\nusername: admin\nsecret: cL78hWa2gYvKAx8Xaa\nevents: off\n\
"
	print logincmd |& ami
        if (ReadAMIPipe(ami, "Success")==0) {print "login failed. Exiting."; exit -1;}
        else { print "Logged in."}
	# AMI will return a value of success if originate was successful. This means on answer.
     	# AMI will return a value of fail if originate was unsuccessful due to no answer, busy, out of service, etc.
	# The do loop will retry if the originate failed. Otherwise retries are handled in the 	#dialplan.
	do {
                	# retries require sleep before starting
                	print "Try = " try
                	if(try<MAXTRY) {print "Sleeping before retry 1."; 
			system("sleep 5");} 
                	faxcmd=setamicmd(try);
                	actionid = "actid" transid
                	print faxcmd;
                	print faxcmd |& ami
                	# This try loop will count down
                	if(ReadAMIPipe(ami, "Response")==1) {
                        	#print "response = " amiresp["Response"]
                        	#print "action id = " amiresp["ActionID"]
                        	print "AMI Response:" amiresp["Response"];

				if((amiresp["Response"] == "Success")&&(amiresp["ActionID"]==actionid)) {
#                                s="/usr/bin/php /var/www/html/Musleh.WebFax-wHtDSxjivdiminVt/faxlogger.php 'Fax " transid " Originate successful.'"; 
		
#				system(s);
#			        sendMail("musleh.duet@gmail.com",1);
                              #print "Job started; work done, outta here" # Once call is originated, rest is handled in the dialplan
                                exit
                        } else {
                                print "Job failed"
                        }
                }
#                //s="/usr/bin/php /var/www/html/Musleh.WebFax-wHtDSxjivdiminVt/faxlogger.php 'Fax " transid " Job start failed, try=" try ".'"; 
#		//system(s);

        } while(--try >= 1)
#	//s="/usr/bin/php /var/www/html/Musleh.WebFax-wHtDSxjivdiminVt/faxlogger.php 'Fax " transid " Job start failed.'"; 
#	//system(s);
       	try=1; #fake try to 1 to get the word out


}	

function ReadAMIPipe(f,s) 
{
command++
found=0
delete amiresp;
#print ">>>>"
while ((f |& getline) > 0) {
                        if($0 !~ /[A-Za-z0-9]+/) return found; #blank line
                        if(NF==2) { k = $1; v=$2; gsub(/[^A-Za-z0-9]/,"",k); gsub(/[^A-Za-z0-9\.]/,"",v); amiresp[k] = v "";}
                        if ($0 ~ s) {found=1}
                        if ($0 ~ s){ print ">" k " = " v} else {print k " = " v} # comment line if not debug
                }
return found;
}

function setamicmd(t) {
if(try==1)
{ 
# Third route for last try, go analog
s="Action: Originate\n\
actionid: actid" transid "\n"
s = s "Channel: SIP/" phone "@IRIS-FAX\n\
Context: WEBFAX_OUT\n\
Exten: SFAX\n\
Priority: 1\n\
Timeout: 30000\n\
Variable: faxfile=" faxtiff ",transid=" transid ",DN=" phone ",callerid=" callerid ",faxheader=" faxheader ",faxuser=" faxuser ",faxemail=" faxemail ",try=" try "\n\
Callerid: " callerid "\n"
}
else if((try+1)%2 == 0) { # Primary: for EVEN numbered tries, use preferred route, T.38
s="Action: Originate\n\
actionid: actid" transid "\n"
s = s "Channel: SIP/" phone "@IRIS-FAX\n\
Context: WEBFAX_OUT\n\
Exten: SFAX\n\
Priority: 1\n\
Timeout: 30000\n\
Variable: faxfile=" faxtiff ",transid=" transid ",DN=" phone ",callerid=" callerid ",faxheader=" faxheader ",faxuser=" faxuser ",faxemail=" faxemail ",try=" try "\n\
Callerid: " callerid "\n"
}
else { # For even numbered tries, use analog channel
s="Action: Originate\n\
actionid: actid" transid "\n"
s = s "Channel: SIP/" phone "@IRIS-FAX\n\
Context: WEBFAX_OUT\n\
Exten: SFAX\n\
Priority: 1\n\
Timeout: 30000\n\
Variable: faxfile=" faxtiff ",transid=" transid ",DN=" phone ",callerid=" callerid ",faxheader=" faxheader ",faxuser=" faxuser ",faxemail=" faxemail ",try=" try "\n\
Callerid: " callerid "\n"
}
return s;		
}

function invokedie()
{
print "Invoke as faxout.awk <phone> </tmp/file.tiff> <transid> <callerid> <faxheader> [try=<n>]\n" > "/dev/stderr" ; exit -1;
#print ARGC;
}

function sendMail(email,status){
print "Sending ..";
p="Fax result for fax id \nTime Start: 09:49:42 \nDate Sent: 2015-04-27 Destination: 6474788676";

if(status==1) {
	print p >  "/tmp/a.txt";
}
if(status==0) {
        print p >  "/tmp/a.txt";
}

s="sendmail " email  "<  /tmp/a.txt";
system(s);
#return 1;
}
