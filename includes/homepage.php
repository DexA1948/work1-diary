<div class="container-fluid">
    <div class="row">
        <?php
        $viewallpages_query = 'SELECT * FROM `mydiary`.`page_table` ORDER BY `id` DESC';

        $result = $conn->query($viewallpages_query);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                //   echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        ?>

                <div class='col-md-3 p-0 clickable-row' data-href='index.php?&action=viewpage&id=<?php echo $row["id"]; ?>'>
                    <div class="wrapper m-2 border border-white p-3" style="border-radius: 20px;">
                        <h3><?php echo $row['heading']; ?></h3>
                        <p><?php echo substr($row['content'], 0, 200); ?></p>
                    </div>
                </div>

        <?php
            }
        } else {
            echo "0 results";
        }

        ?>
    </div>
</div>
<script>
    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>