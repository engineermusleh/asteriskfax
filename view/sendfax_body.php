<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Web Fax</h1>
                    <br>Please use the form below to input the required information and click on "SendFax" below</div>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form role="form" action="faxsend.php" method="post" enctype="multipart/form-data" onsubmit="return validate()">
                    <div class="form-group">
                        <label class="control-label" for="exampleInputPassword1">Fax Destination</label>
                        <input class="form-control" id="exampleInputPassword1" type="text"  name="dest" placeholder="XXX-XXX-XXXX">
                        <!-- p class="help-block">Enter the destination fax number.(format: XXXXXXXX, XXX-XXX-XXXX, (XXX) XXX XXXX, XXX.XXX.XXXX)</p -->
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="exampleInputEmail1">Fax Header(Optional)</label>
                        <input class="form-control" id="exampleInputEmail1" type="text" name="faxHeader">
                        <p class="help-block">Type the header text you want to appear at the top of your fax.</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Fax File</label>
                        <input type="file" id="faxFile" name="faxFile" >
                        <p class="help-block">File types acceptable: PDF
                            <br>
                        </p>
                    </div>
                    <button type="submit" class="btn btn-default">Upload and Fax</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    var fileSize;
    //binds to onchange event of your input field
    $('#faxFile').bind('change', function() {
        var size=this.files[0].size/1000;
        fileSize=size;
    });

    function validate(){

        var fax_number=$("#exampleInputPassword1").val();
       // var numericReg = /\(?([2-9]{3})\)?([ .-]?)([2-9]{3})\2([0-9]{4})$/;
	var numericReg = /\(?([2-9]{1}[0-9]{2})\)?([ .-]?)([2-9]{1}[0-9]{2})\2([0-9]{4})$/;
        if(!numericReg.test(fax_number)) {
            alert("Please provide valid fax number.");
            return false;
        }

        var ext = $('#faxFile').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf']) == -1) {
            alert('Please upload pdf file!');
            return false;
        }

        if(fileSize>=9999) {
            alert('Please upload pdf file with MAX size 10MB!');
            return false;
        }

        return true;
    }

</script>
