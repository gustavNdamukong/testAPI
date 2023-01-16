<?php
@include ('./UserCollection.php');
@include ('./User.php');

    if (isset($_GET['print']))
    {
        $userCollection = getUserCollection();
        $columns = ['first name', 'last name', 'company name', 'email', 'phone', 'extension', 'city'];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, $columns,';', ' ');

        header("Content-type: text/csv; charset=utf-8"); // text/csv
        header('Content-disposition: attachment; filename=user_report.csv');
        header('Content-Length: ' . strlen($userCollection->getCount()));

        foreach ($userCollection as $object) {
            $row = [];
            $name = explode(' ',$object->getName());

            $row = [
                $object->getFirstName(),
                $object->getLastName(),
                $object->getCompany()['name'],
                $object->getEmail(),
                $object->getPhone(),
                $object->getPhoneExtension(),
                $object->getAddress()['city'],
            ];

            fputcsv($handle, $row, ';', ' ');
        }

        fclose($handle);
        die();
    }

    function getUserCollection()
    {
        $curl = curl_init();
        $endpoint = "https://jsonplaceholder.typicode.com/users";

        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        $decodedText = html_entity_decode($response);
        $responseArray = json_decode($decodedText, true);

        $userCollection = new UserCollection();
        foreach ($responseArray as $user)
        {
            $userCollection->add(new User($user));
        }

        return $userCollection;
    }
?>

<!DOCTYPE HTML>
<html class="no-js" lang="en-gb" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <style rel="stylesheet">
        .main {
            display: grid;
            place-items: center;
        }

        .createCSV {
            background-color: #00bfff;
            color: #fff;
            border-radius: 4px;
            width: 7rem;
            height: 1rem;
            text-decoration: none;
            text-align: center;
            padding: 0.5em 0;
            cursor: pointer;
            margin: 0 0 0.5em 0;
        }

        .createCSV:hover {
            background-color: #6495ed;
        }
    </style>
</head>
<body>
    <div class="main">
        <h1>Hello from TestAPI</h1>
        <a class="createCSV" href="<?=$_SERVER['PHP_SELF']?>?print=yes">Create CSV</a>
        <?php
        $curl = curl_init();
        $endpoint = "https://jsonplaceholder.typicode.com/users";

        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        $decodedText = html_entity_decode($response);
        $responseArray = json_decode($decodedText, true);

        $userCollection = new UserCollection();
        foreach ($responseArray as $user)
        {
            $userCollection->add(new User($user));
        }

        //Display users
        foreach ($userCollection as $object) {
            $row = [];
            $name = explode(' ',$object->getName());

            echo 'NAME PREFIX: '.$object->getNamePrefix().'<br>';
            echo 'FIRST NAME: '.$object->getFirstName().'<br>';
            echo 'SURNAME: '.$object->getLastName().'<br>';
            echo 'NUMBER IS: '.$object->getPhone().'<br>';
            echo 'EXTENSION IS: '.$object->getPhoneExtension().'<br>';
            echo 'EMAIL IS: '.$object->getEmail().'<br>';
            echo 'EMAIL VALID: '.$object->getEmailValid().'<br>';
            echo 'CITY: '.$object->getAddress()['city'];
            echo '<br>--------------------------------------------<br>';
        } ?>
    </div>
</body>
</html>
