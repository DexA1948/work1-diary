<?php

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $viewpage_query = $conn->prepare("SELECT * from `mydiary`.`page_table` WHERE id=?");
    $viewpage_query->bind_param("i", $id);
    $viewpage_query->execute();
    $result = $viewpage_query->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows !== 1) {
        echo "<p class='text-warning'>Please select a post to view it, valid id is required.<p>";
        require_once('includes/homepage.php');
    } else {
?>
        <div class="container-fluid w-75 my-3">
            <h2>
                <?php echo $row['heading']; ?>
                &nbsp;
                <a href="index.php?&action=editpage&id=<?php echo $row['id']; ?>" >
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                        </svg>
                    </span>
                </a>
                &nbsp;
                <a href="index.php?&action=deletepage&id=<?php echo $row['id']; ?>">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z" />
                        </svg>
                    </span>
                </a>
            </h2>
            <p class="text-end fst-italic"><?php echo $row['last_edited_date']; ?></p>
            <p style="text-align: justify;"><?php echo $row['content']; ?></p>
            <div class="row" id="Photo1">
                <div class="col-md-6">
                    <img src="<?php echo $row['photopath1']; ?>" alt="Photo1" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <img src="<?php echo $row['photopath2']; ?>" alt="Photo2" class="img-fluid">
                </div>
            </div>
        </div>

<?php
    }
} else {
    echo "<p class='text-warning'>Please select a post to view it, id is required.<p>";
    require_once('includes/homepage.php');
}

?>
<div class="container-fluid">
    <h1></h1>
</div>