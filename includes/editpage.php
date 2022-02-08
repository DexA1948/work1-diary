<?php
//validation and posting
function test_input($data)
{
    global $conn;
    $data = trim($data); //remove whitespaces, newline, tabs
    $data = stripslashes($data); //remove \
    $data = htmlspecialchars($data); //convert <, > to &lt;, &gt;
    $data = $conn->real_escape_string($data);
    return $data;
}

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $viewpage_query = $conn->prepare("SELECT * from `mydiary`.`page_table` WHERE id=?");
    $viewpage_query->bind_param("i", $id);
    $viewpage_query->execute();
    $result = $viewpage_query->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows !== 1) {
        echo "<p class='text-warning'>Please select a post to edit it, valid id is required.<p>";
        require_once('includes/homepage.php');
    } else {
        $heading = $row['heading'];
        $content = $row['content'];
        $photo1 = $row['photopath1'];
        $photo2 = $row['photopath2'];
        $headingErr = $photo1Err = $photo2Err = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "hello";

            if (empty(trim($_POST["heading"]))) {
                $headingErr = "Please insert a heading";
            } else {
                $heading = test_input($_POST["heading"]);

                if (strlen($heading) > 255) {
                    $headingErr = "Too long (required length <= 255)";
                }
            }

            $content = test_input($_POST["content"]);

            //######## IMAGE UPLOAD ##################//
            if (!empty($_FILES["photo1"]["tmp_name"])) {
                $target_dir = "images/";
                $photo1 = $target_dir . basename($_FILES["photo1"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($photo1, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["photo1"]["tmp_name"]);
                if ($check !== false) {
                    $photo1Err = "";
                } else {
                    $photo1Err = "File is not an image.";
                }

                // Check file size
                if ($_FILES["photo1"]["size"] > 10000000) {
                    $photo1Err = "Sorry, file is too large. (filesize < 10MB)";
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $photo1Err =  "Sorry, only JPG, JPEG & PNG files are allowed.";
                }

                if ($photo1Err == "") {
                    // Check if file already exists
                    if (file_exists($photo1)) {
                        unlink($photo1);
                    }
                }
            }

            if (!empty($_FILES["photo2"]["tmp_name"])) {
                $target_dir = "images/";
                $photo2 = $target_dir . basename($_FILES["photo2"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($photo2, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["photo2"]["tmp_name"]);
                if ($check !== false) {
                    $photo2Err = "";
                } else {
                    $photo2Err = "File is not an image.";
                }

                // Check file size
                if ($_FILES["photo2"]["size"] > 10000000) {
                    $photo2Err = "Sorry, file is too large. (filesize < 10MB)";
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $photo2Err =  "Sorry, only JPG, JPEG & PNG files are allowed.";
                }

                if ($photo2Err == "") {
                    // Check if file already exists
                    if (file_exists($photo2)) {
                        unlink($photo2);
                    }
                }
            }

            if ($headingErr == "" && $photo1Err == "" && $photo2Err == "") {
                move_uploaded_file($_FILES["photo1"]["tmp_name"], $photo1);
                move_uploaded_file($_FILES["photo2"]["tmp_name"], $photo2);

                $submittedDate = date("Y-m-d l");
                $page_edit_query = "UPDATE `page_table` SET heading='$heading', content='$content', photopath1='$photo1', photopath2='$photo2', last_edited_date='$submittedDate' WHERE id='$id'";

                if ($conn->query($page_edit_query)) {
                    echo "<script>alert('Page Edited Succesfully');</script>";
                } else {
                    echo "<script>alert('Couldn't Edit Page, Try Again');</script>";
                }
            }
        }
?>

        <style>
            td:nth-child(1) {
                width: 20%;
            }

            td:nth-child(2) {
                width: 80%;
            }
        </style>
        <div class="container-fluid w-75">
            <h3>Edit Page</h3>
            <form class="w-100 p-3" action="index.php?&action=editpage&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <label for="heading">Heading</label>
                        </td>
                        <td>
                            <div class="text-warning"><?php echo $headingErr; ?></div>
                            <input class="w-100" type="text" id="heading" name="heading" value="<?php echo $heading; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="content">Content</label>
                        </td>
                        <td>
                            <textarea class="w-100" type="text" id="content" name="content" rows="10"><?php echo $content; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>Reselect photos to change them</td>
                    </tr>
                    <tr>
                        <td>
                            <label for="photo1">Photo 1</label>
                        </td>
                        <td>
                            <div class="text-warning"><?php echo $photo1Err; ?></div>
                            <input class="w-100" type="file" name="photo1" id="photo1">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="photo2">Photo 2</label>
                        </td>
                        <td>
                            <div class="text-warning"><?php echo $photo2Err; ?></div>
                            <input class="w-100" type="file" name="photo2" id="photo2">
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <button class="btn btn-light">Edit Page</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

<?php
    }
} else {
    echo "<p class='text-warning'>Please select a post to edit it, id is required.<p>";
    require_once('includes/homepage.php');
}

?>