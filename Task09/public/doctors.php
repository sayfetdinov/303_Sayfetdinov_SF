<?php

require_once '../app/repositories/DoctorsRepository.php';
require_once '../app/repositories/ReceptionsRepository.php';
require_once '../app/repositories/Repository.php';
require_once '../app/Validator.php';

const DB_NAME = '../data/hospital.db';

$pdo = preparePDO(DB_NAME);
$doctorsRepository = new DoctorsRepository($pdo);
$receptionsRepository = new ReceptionsRepository($pdo);
$validator = new Validator();

$doctors = $doctorsRepository->findAll();

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
<h1>Doctors</h1>
<h2 class="form-title"><a href="add_doctor.php">Add new one</a></h2>
<h3>Total: <?= count($doctors) ?> </h3>
<div class="doctor-cards">
    <?php foreach ($doctors as $doctor): ?>
        <div class="doctor-card">
            <div class="card-fields">
                <span class="card-field">ID: <?= $doctor->id ?></span>
                <span class="card-field">First name: <?= $doctor->firstName ?></span>
                <span class="card-field">Last name: <?= $doctor->lastName ?></span>
                <span class="card-field">Patronymic: <?= $doctor->patronymic ?></span>
                <span class="card-field">Date of Birth: <?= $doctor->dateOfBirth ?></span>
                <span class="card-field">Status: <?= $doctor->status ?></span>
                <span class="card-field">Specialty: <?= $doctor->speciality ?></span>
                <span class="card-field">Earning: <?= $doctor->earning . '%' ?></span>
            </div>
            <div class="action-buttons">
                <form action="delete_doctor.php" method="post">
                    <input type="text" value="<?= $doctor->id ?>" hidden="true" name="doctorId">
                    <input class="action-button action-button-delete" type="submit" value="Delete">
                </form>
                <form action="update_doctor.php" method="post">
                    <input type="text" value="<?= $doctor->id ?>" hidden="true" name="doctorId">
                    <input type="text" value="<?= $doctor->firstName ?>" hidden="true" name="firstName">
                    <input type="text" value="<?= $doctor->lastName ?>" hidden="true" name="lastName">
                    <input type="text" value="<?= $doctor->patronymic ?>" hidden="true" name="patronymic">
                    <input type="text" value="<?= $doctor->dateOfBirth ?>" hidden="true" name="dateOfBirth">
                    <input type="text" value="<?= $doctor->status ?>" hidden="true" name="status">
                    <input type="text" value="<?= $doctor->earning ?>" hidden="true" name="earning">
                    <input type="text" value="<?= $doctor->specialityId ?>" hidden="true" name="specialityId">
                    <input type="text" value="<?= $doctor->statusId ?>" hidden="true" name="statusId">
                    <input type="text" value="<?= $doctor->speciality ?>" hidden="true" name="speciality">
                    <input class="action-button action-button-update" type="submit" value="Update">
                </form>
                <form action="index.php" method="post">
                    <input type="text" value="<?= $doctor->id ?>" hidden="true" name="doctorId">
                    <input class="action-button action-button-view" type="submit" value="View receptions">
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>