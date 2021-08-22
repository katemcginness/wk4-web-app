<?php

//simple if/else statement to check if the id is available
if (isset($_GET['id'])) {
    //yes the id exists
    try {
        // include the config file that we created last week
        require "../config.php";
        require "common.php";
        
        // run when submit button is clicked
        if (isset($_POST['save'])) {
            try {
                $connection = new PDO($dsn, $username, $password, $options);  
                
                //grab elements from form and set as varaible
                $income =[
                    "id"         => $_POST['id'],
                    "incomename" => $_POST['incomename'],
                    "incomeamount"  => $_POST['incomeamount'],
                    "incomefrequency"   => $_POST['incomefrequency'],
                ];
            
                // create SQL statement
                $sql = "UPDATE `income` 
                        SET id = :id, 
                            incomename = :incomename, 
                            incomeamount = :incomeamount, 
                            incomefrequency = :incomefrequency, 
                            date = :date 
                        WHERE id = :id";
            
                //prepare sql statement
                $statement = $connection->prepare($sql);
            
                //execute sql statement
                $statement->execute($income);
  
                
                } catch(PDOException $error) {
                echo $sql . "<br>" . $error->getMessage();
            }
        }

        // standard db connection
        $connection = new PDO($dsn, $username, $password, $options);

        // set if as variable
        $id = $_GET['id'];

        //select statement to get the right data
        $sql = "SELECT * FROM income WHERE id = :id";

        // prepare the connection
        $statement = $connection->prepare($sql);

        //bind the id to the PDO id
        $statement->bindValue(':id', $id);

        // now execute the statement
        $statement->execute();

        // attach the sql statement to the new work variable so we can access it in the form
        $work = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOExcpetion $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
    // quickly show the id on the page
    // echo $_GET['id'];

    ?>

<?php
} else {
    // no id, show error
    echo "No id - something went wrong";
    //exit;
}
?>

<form method="post">

<label for="id">ID</label>
<input type="text" name="id" id="id" value="<?php echo escape($income['id']); ?>" >


<label for="incomename">Income name</label>
<input type="text" name="incomename" id="incomename" value="<?php echo escape($income['incomename']); ?>">

<label for="incomeamount">Income amount</label>
<input type="text" name="incomeamount" id="incomeamount" value="<?php echo escape($income['incomeamount']); ?>">

<label for="incomefrequency">Income frequency</label>
<input type="text" name="incomefrequency" id="incomefrequency" value="<?php echo escape($income['incomefrequency']); ?>">


<input type="submit" name="save" value="Save">

</form>

