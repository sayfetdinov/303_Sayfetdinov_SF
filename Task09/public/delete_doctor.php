<?php

require_once '../app/repositories/DoctorsRepository.php';

const DB_NAME = '../data/hospital.db';

$pdo = preparePDO(DB_NAME);
$doctorRepository = new DoctorsRepository($pdo);

$id = (int)$_POST['doctorId'];

$doctorRepository->deleteById($id);

echo 'Doctor deleted' . PHP_EOL;
echo '<a href="doctors.php">Return bach.</a>';

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
