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
                        <th>Fax Header</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <?php

                    $query = "SELECT id, name, username, email, callerid,fax_header FROM users";
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
                            <td><?php echo $row['fax_header']; ?></td>
                            <td><a class="btn btn-default" href="javascript:edit_id(<?php echo $row['id']; ?>)">Edit</a></td>
                            <td><a class="btn btn-default" href="javascript:delete_id(<?php echo $row['id']; ?>)">Delete</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function delete_id(id){
        if(confirm('Sure To Delete This ID ?')){
            window.location.href='nimda.php?delete_id='+id;
        }
    }
    function edit_id(id){
        window.location.href='editprofile.php?edit_id='+id;
    }
</script>