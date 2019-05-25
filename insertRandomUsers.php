<?php
//// Including required file for connecting to database.
//require_once './includes/Connection.php';
//
//$name = array("Ioannis", "Nicolas", "Dimitris", "Tasos", "Theoklis", "Elisseos", "Zenios", "Renos", "Kiriakos", "Ioulios");
//$surname= array("Ioardanous", "Nikolaou", "Anastasiou", "Nearchou", "Georgiou", "Charalambous", "Kyprianou", "Konstantinou", "Gregoriou");
//$bday = date("Y-01-01", strtotime('-40 years'));
//$currentDate = date("Y-02-01");
//$gender = array("Male", "Female");
//$district = array("Mandria, Limassol", "Tala, Paphos", "Latsia, Nicosia", "Pervolia, Larnaca", "Protaras, Famagusta", "Karavas, Kerynia");
//$education = array("Technical School", "UNIC","European University", "Neapolis University", "College", "Graphic Arts", "Multimedia");
//$occupation = array("Architecture", "Barman", "Security", "Lifeguard", "Waiter", "Supervisor", "Lawyer", "Graphic Designer");
//$hashToStoreInDb = password_hash('12345678', PASSWORD_DEFAULT);
//
//for ($i = 0; $i <=10; $i++) {
//    $randNum=rand(100,9999);
//    $newName = strtolower($name[rand(0,9)]);
//    $email = $newName.$randNum."@mail.uuy";
//    $currentDate = date('Y-m-d', strtotime($currentDate.'+2 days'));
////    $currentDate = date('Y-m-d', strtotime($currentDate.'+1 month'));
//    $bday = date('Y-m-d', strtotime($bday."+2 years"));
//    $bday = date('Y-m-d', strtotime($bday."+1 month"));
//    $bday = date('Y-m-d', strtotime($bday."+2 days"));
//    if ($stmt = $conn->prepare("INSERT INTO users
//                            (Name, Surname, Birthdate, Gender, District, Education, Occupation, Email, Password, RegistrationDate, LastLogin)
//                             VALUES (?,?,?,?,?,?,?,?,?,?,?)")) {
//        // Bind the variables to the parameters.
//        $stmt->bind_param("sssssssssss", $newName, $surname[rand(0,8)], $bday, $gender[rand(0,0)], $district[rand(0,5)], $education[rand(0,6)], $occupation[rand(0,7)], $email, $hashToStoreInDb, $currentDate, $currentDate);
//
//        // Execute the statement.
//        $stmt->execute();
//
//        // Close the prepared statement.
//        $stmt->close();
//    }
//}
//
//$conn->close();