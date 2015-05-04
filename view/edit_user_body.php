<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Profile</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>Please don't remove fields that you don't want to update.</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form role="form" action="edit.php" class="form-horizontal" method="post">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="inputEmail3" class="control-label" contenteditable="true">Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Username" name="name" value="<?php echo $row['name']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="inputEmail3" class="control-label" contenteditable="true">Username</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $row['username']?>">
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="col-sm-2">
                                <label class="control-label">Email</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" placeholder="example@example.com"
                                       name="email" value="<?php echo $row['email']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="inputEmail3" class="control-label">Caller ID</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Example <1234567890?>"
                                       name="callerid" value="<?php echo $row['callerid']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="inputEmail3" class="control-label">Fax Header</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Example <1234567890?>"
                                       name="fax_header" value="<?php echo $row['fax_header']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="inputEmail3" class="control-label">Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="Leave blank if you do not need to change password."
                                       name="password" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>