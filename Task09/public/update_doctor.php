<?php

require_once '../app/repositories/SpecialitiesRepository.php';
require_once '../app/repositories/DoctorsRepository.php';
require_once '../app/repositories/EmployeeStatusesRepository.php';
require_once '../app/dto/DoctorFullModel.php';
require_once '../app/Validator.php';

const DB_NAME = '../data/hospital.db';

$pdo = preparePDO(DB_NAME);
$specialitiesRepository = new SpecialitiesRepository($pdo);
$doctorRepository = new DoctorsRepository($pdo);
$employeeStatusesRepository = new EmployeeStatusesRepository($pdo);
$validator = new Validator();

$id = $_POST['doctorId'] ?? null;
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$patronymic = $_POST['patronymic'];
$dateOfBirth = $_POST['dateOfBirth'];
$specialityId = $_POST['specialityId'];
$earning = $_POST['earning'];
$status = $_POST['status'] ?? null;
$speciality = $_POST['speciality'] ?? null;
$statusId = $_POST['statusId'];

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

if (isset($_POST['update-doctor'])) {
    update($validator, $doctorRepository);
}

function update(Validator $validator, DoctorsRepository $doctorRepository) {
    [$result, $erroredParameter, $reason] = $validator->validatePost([
        'firstName' => ['string', 'userName'],
        'lastName' => ['string', 'userName'],
        'patronymic' => ['string', 'userName'],
    ]);

    if (!$result) {
        echo "$erroredParameter is not $reason";

        return;
    }

    $doctorRepository->update(
        new DoctorUpdateModel(
            (int)$_POST['id'],
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['patronymic'],
            $_POST['dateOfBirth'],
            (int)$_POST['specialityId'],
            (int)$_POST['earning'],
            (int)$_POST['statusId']
        )
    );

    echo 'Success!';
}

$specialities = $specialitiesRepository->findAllSpecialities();

$employeeStatuses = $employeeStatusesRepository->findAllEmployeeStatuses();

?>
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
<h1>Update doctor</h1>
<form name="update-doctor" method="POST" action="update_doctor.php">
    <label hidden="true"><input type="text" name="id" value="<?= $id ?>"></label><br><br>
    <label>First name: <input type="text" name="firstName" value="<?= $firstName ?>"></label><br><br>
    <label>Last name: <input type="text" name="lastName" value="<?= $lastName ?>"></label><br><br>
    <label>Patronymic: <input type="text" name="patronymic" value="<?= $patronymic ?>"></label><br><br>
    <label>Date of birth: <input type="date" name="dateOfBirth" value="<?= $dateOfBirth ?>"></label><br><br>
    <label>Earning in percent: <input type="text" name="earning" value="<?= $earning ?>"></label><br><br>
    <label>Speciality:
        <select name="specialityId">
            <option value=<?= $speciality ?>><?= $speciality ?></option>
            <?php foreach ($specialities as $iSpeciality): ?>
                <option value=<?= $iSpeciality->id ?>>
                    <?= $iSpeciality->title ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <label>Employee status:
        <select name="statusId">
            <option value=<?= $status ?>><?= $status ?></option>
            <?php foreach ($employeeStatuses as $iStatus): ?>
                <option value=<?= $iStatus->id ?>>
                    <?= $iStatus->title ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <input type="submit" name="update-doctor" value="Update">
</form>
</body>
</html>