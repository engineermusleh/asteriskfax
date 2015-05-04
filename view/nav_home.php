<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <?php if(empty($_SESSION['username'])){ ?>
    <ul class="nav navbar-nav navbar-right">
        <li <?php if($menu=="index") { ?>class="active" <?php }?> >
            <a href="index.php">Home</a>
        </li>
        <li <?php if($menu=="signup") { ?>class="active" <?php }?>>
            <a href="signup.php">Register</a>
        </li>
    </ul>
    <?php } ?>
    <?php if(!empty($_SESSION['username'])){ ?>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="logout.php">Logout</a>
        </li>
    </ul>
    <?php } ?>
</div>