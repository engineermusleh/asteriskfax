<div class="section">
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>CallerId</th>
                            <th>Activate</th>
                            <th>Reject</th>
                        </tr>
                        </thead>
                        <?php

                        $query = "SELECT id, name, username, email, callerid FROM register_requests";
                        $result = $db->prepare($query);
                        $result->execute();
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['callerid']; ?></td>
                                <td><a class="btn btn-default" href="javascript:activate_id(<?php echo $row['id']; ?>)">Activate</a></td>
                                <td><a class="btn btn-default" href="javascript:reject_id(<?php echo $row['id']; ?>)">Reject</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function activate_id(id){
        if(confirm('Sure To Activate This Request ?'))
        {
            window.location.href='registration_request.php?activate_id='+id;
        }
    }
    function reject_id(id){
        if(confirm('Sure To Reject This Request ?'))
        {
            window.location.href='registration_request.php?reject_id='+id;
        }
    }
</script>