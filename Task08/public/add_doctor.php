<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="navbar">
    <h1 class="title">Clinic</h1>
</div>
<div>
    <a href="index.php">Back</a>
</div>
<h1>Add doctor</h1>
<?php

require_once '../app/repositories/SpecialitiesRepository.php';
require_once '../app/repositories/DoctorsRepository.php';
require_once '../app/repositories/EmployeeStatusesRepository.php';
require_once '../app/Validator.php';

const DB_NAME = '../hospital.db';

$pdo = preparePDO(DB_NAME);
$specialitiesRepository = new SpecialitiesRepository($pdo);
$doctorRepository = new DoctorsRepository($pdo);
$employeeStatusesRepository = new EmployeeStatusesRepository($pdo);
$validator = new Validator();

function preparePDO(string $dbName): PDO
{
    return new PDO(
        'sqlite:' . realpath($dbName),
        '',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
}

if (isset($_POST['add-doctor'])) {
    addDoctor($validator, $doctorRepository);
}

function addDoctor(Validator $validator, DoctorsRepository $doctorRepository) {
    [$result, $erroredParameter, $reason] = $validator->validatePost([
        'first_name' => ['string', 'userName'],
        'last_name' => ['string', 'userName'],
        'patronymic' => ['string', 'userName'],
    ]);

    if (!$result) {
        echo "$erroredParameter is not $reason";

        return;
    }

    $doctorRepository->insertEntity(
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['patronymic'],
        $_POST['date_of_birth'],
        $_POST['speciality_id'],
        $_POST['earning_in_percents'],
        $_POST['employee_status']
    );

    echo 'Success!';
}

$specialities = $specialitiesRepository->findAllSpecialities();

$employeeStatuses = $employeeStatusesRepository->findAllEmployeeStatuses();

?>

<form name="add-doctor" method="POST" action="add_doctor.php">
    <label>First name: <input type="text" name="first_name"></label><br><br>
    <label>Last name: <input type="text" name="last_name"></label><br><br>
    <label>Patronymic: <input type="text" name="patronymic"></label><br><br>
    <label>Date of birth: <input type="date" name="date_of_birth"></label><br><br>
    <label>Earning in percent: <input type="text" name="earning_in_percents"></label><br><br>
    <label>Speciality:
        <select name="speciality_id">
            <option value=<?= null ?>></option>
            <?php foreach ($specialities as $speciality): ?>
                <option value=<?= $speciality->id ?>>
                    <?= $speciality->title ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <label>Speciality:
        <select name="employee_status">
            <option value=<?= null ?>></option>
            <?php foreach ($employeeStatuses as $status): ?>
                <option value=<?= $status->id ?>>
                    <?= $status->title ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <input type="submit" name="add-doctor" value="Add">
</form>
</body>
</html>