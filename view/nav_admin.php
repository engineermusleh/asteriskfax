<div class="section">
    <div class="container">
        <div class="row" style="margin:15px 0px;">
            <div class="col-md-12">
                <ul class="nav nav-justified nav-pills">
                    <li <?php if($menu=="home"){?>class="active"<?php }?>>
                        <a href="nimda.php">Users List</a>
                    </li>
                    <li <?php if($menu=="req_user"){?>class="active"<?php }?>>
                        <a href="registration_request.php">Registration Requests</a>
                    </li>
                    <li <?php if($menu=="add_user"){?>class="active"<?php }?>>
                        <a href="adduser.php">Add User</a>
                    </li>
                    <?php if($menu=="edit_user"){?>
                    <li class="active">
                        <a href="edituser.php">Edit User</a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>