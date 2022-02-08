<!-- head with title, favicon and links to be loaded (bootstrap n jquery) -->
<?php require_once('includes/head.php'); ?>


<!-- body section -->

<body class="bg-dark text-white text-center">
    <?php

    require_once('includes/bannerbar.php');

    // establishing object-oriented connection to database, connection named $conn
    require_once('includes/dbConnection.php');

    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        switch ($action) {
            case 'viewpage':
                require_once('includes/viewpage.php');
                break;
            case 'addpage':
                require_once('includes/addpage.php');
                break;
            case 'editpage':
                require_once('includes/editpage.php');
                break;
            case 'deletepage':
                require_once('includes/deletepage.php');
                break;
            default:
                require_once('includes/homepage.php');
        }
    } else {
        require_once('includes/homepage.php');
    }
    ?>
</body>


<!-- footer -->
<?php $conn->close(); ?>

</html>