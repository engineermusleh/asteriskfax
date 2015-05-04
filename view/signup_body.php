<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header">
                    <h1>User Registration Form</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form role="form" action="register.php" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="inputEmail3" class="control-label" contenteditable="true">Name</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="inputEmail3" class="control-label" contenteditable="true">Username</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Username" name="username"
                                   required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="inputEmail3" class="control-label">Password</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="Password" required=""
                                   name="password">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="col-sm-2">
                            <label class="control-label">Email</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" placeholder="example@example.com"
                                   required="" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="inputEmail3" class="control-label">Caller ID</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Example <1234567890?>"
                                   required="" name="callerid">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>