<?php


require_once '../app/repositories/Repository.php';
require_once '../app/dto/DoctorId.php';
require_once '../app/dto/DoctorFullModel.php';

class DoctorsRepository extends Repository
{
    public function findAllIds(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id as id   
from doctors as d'
            )
            ->fetchAll(PDO::FETCH_CLASS, DoctorId::class);
    }

    public function findAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id as id,
       d.first_name as firstName,
       d.last_name as lastName,
       d.patronymic as patronymic
from doctors as d'
            )
            ->fetchAll(PDO::FETCH_CLASS, DoctorFullModel::class);
    }

    public function insertEntity(string ...$args) {
        $query = $this->getConnection()
            ->prepare("insert into doctors(first_name, last_name, patronymic, date_of_birth, speciality_id, earning_in_percents, employee_status_id)
 values (:first_name, :last_name, :patronymic, :date_of_birth, :speciality_id, :earning_in_percents, :employee_status_id)");
        $query->execute($args);
    }
}
