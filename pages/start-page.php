<!––Form––>
<div class="sizingFirstRow">
    <form  method="POST">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">New Blogpost</label>
            <textarea class="form-control" NAME="blogtext" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <input type="submit" id="btnAdd" NAME="newBlogPost" value="Add" class="btn btn-primary btn-sm"/>
    </form>
<div/>
<!––FormEnd––>

<!––NewBlogPost––>
<?php

include ("debugToConsole.php");
//see if button is pressed***
$user_id=$_SESSION['user_id'];
$loaded=false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newBlogPost'])) {

        //get the textfield input***
        $text = $_POST['blogtext'];
        //***
        //make te sql statement***
        $sql = "INSERT INTO blogeintrag (blogtext, blogbild,user_id)
                VALUES ('$text', 'Doe','$user_id')";
        //***
        //make the querry***
        if (!mysqli_query($db, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
        //***


        $abfrage = "SELECT blogText, user_id FROM blogeintrag";
        $ergebnis = mysqli_query($db, $abfrage);

        while ($row = mysqli_fetch_object($ergebnis)) {?>
            <!––Post––>
            <div class="secondRowSizing">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><?php echo $row->user_id; ?></span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea"><?php echo $row->blogText; ?></textarea>
                </div>
                <!––PostEnd––>

                <!––CommentSection––>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Comment" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Comment</button>
                    </div>
                </div>
            </div>
            <!––CommentSectionEnd––>
          <?php  echo "<br>";
        }
        $loaded=true;
    }
}
//<!––NewBlogPostEnd––>

//<!––Output––>
if(!$loaded) {
    $abfrage = "SELECT blogText,user_id FROM blogeintrag";
    $ergebnis = mysqli_query($db, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {?>
        <!––Post––>
    <div class="secondRowSizing">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><?php echo $row->user_id; ?></span>
            </div>
            <textarea class="form-control" aria-label="With textarea"><?php echo $row->blogText; ?></textarea>
        </div>
        <!––PostEnd––>
        <!––CommentSection––>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Comment" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Comment</button>
            </div>
        </div>
    </div>
        <!––CommentSectionEnd––>
        <?php echo "<br>";
    }
}
?>
<!––OutputEnd––>

