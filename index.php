<?php

    define("SERVER_NAME", "localhost");
    define("USER_NAME", "dharnee");
    define("PASSWORD", "dharnee");
    define("DATABASE_NAME", "event_details");
    define("SUBJECT", "Event Registration");
    define("MESSAGE", "You have been registered for the ticked events.");

    $conn = mysqli_connect(SERVER_NAME, USER_NAME, PASSWORD, DATABASE_NAME);
    if (!$conn) {
        die("connection failed");
    }

    function test_input($data, $conn) {
        $data = mysqli_real_escape_string($conn, $data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = $email = $college = $gender = $contact = $err = "";
    $events = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
                $err .= "Name is required\n";
        } else {
            $name = test_input($_POST["name"], $conn);
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $err .= "Only letters and white space allowed\n";
            }
        }

        if (empty($_POST["email"])) {
                $err .= "Email is required\n";
        } else {
            $email = test_input($_POST["email"], $conn);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $err = "Invalid email format\n";
            }
        }

        if (empty($_POST["contact"])) {
            $err .= "Contact Number is required";
        } else {
            $contact = test_input($_POST["contact"], $conn);
        }

        if (empty($_POST["college"])) {
            $err .= "College is required";
        } else {
            $college = test_input($_POST["college"], $conn);
        }

        if (empty($_POST["gender"])) {
            $err .= "Gender is required";
        } else {
            $gender = $_POST["gender"];
        }

        if (empty($_POST["events"])) {
            $err .= "Events is required";
        } else {
            $events = $_POST["events"];
        }

        if (!$err)  {
            $query = "SELECT id FROM users WHERE email = '" . $email . "'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id = $row["id"];
                foreach ($events as $event) {
                    $query = "INSERT INTO " . $event . " (id) VALUES ('" . $id . "')";
                    mysqli_query($conn, $query);
                }
                mail($email, SUBJECT, MESSAGE);
            } else {
                $query = "INSERT INTO users (name, email, college, gender, contact) VALUES ('" . $name . "', '" . $email . "', '" . $college . "', '" . $gender . "', '" . $contact . "')";
                if (mysqli_query($conn, $query)) {
                    $query = "SELECT id FROM users WHERE email = '" . $email . "'";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $id = $row["id"];
                        foreach ($events as $event) {
                            $query = "INSERT INTO " . $event . " (id) VALUES ('" . $id . "')";
                            mysqli_query($conn, $query);
                        }
                        mail($email, SUBJECT, MESSAGE);
                    }
                }
            }
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Page Title</title>
    </head>
    <body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name" value="" />
        <br><br>
        E-mail: <input type="text" name="email" value="" />
        <br><br>
        Contact No.: <input type="text" name="contact" value="" />
        <br><br>
        College: <input type="text" name="college" value="" />
        <br><br>
        Gender:
        <input type="radio" name="gender" value="male" />Male
        <input type="radio" name="gender" value="female" />Female
        <input type="radio" name="gender" value="other" />Other
        <br><br>
        Events:
        <br><br>
        <input type="checkbox" name="events[]" value="event1" />Event 1
        <input type="checkbox" name="events[]" value="event2" />Event 2
        <input type="checkbox" name="events[]" value="event3" />Event 3
        <input type="checkbox" name="events[]" value="event4" />Event 4
        <input type="checkbox" name="events[]" value="event5" />Event 5
        <br><br>
        <input type="submit" name="submit" />
    </form>
    </body>
</html>
