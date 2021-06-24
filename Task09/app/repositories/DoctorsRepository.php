<?php

require_once '../app/repositories/Repository.php';
require_once '../app/dto/DoctorId.php';
require_once '../app/dto/DoctorFullModel.php';
require_once '../app/dto/DoctorCreateModel.php';
require_once '../app/dto/DoctorUpdateModel.php';

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

    /**
     * @return DoctorFullModel[]
     */
    public function findAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id as id,
       d.first_name as firstName,
       d.last_name as lastName,
       d.patronymic as patronymic,
       d.date_of_birth as dateOfBirth,
       d.speciality_id as specialityId,
       d.employee_status_id as statusId,
       d.earning_in_percents as earning,
       es.title as status,
       s.title as speciality
from doctors as d
join employee_statuses es on d.employee_status_id = es.id
join specialties s on d.speciality_id = s.id'
            )
            ->fetchAll(PDO::FETCH_CLASS, DoctorFullModel::class);
    }

    public function create(DoctorCreateModel $model): void
    {
        $query = $this->getConnection()
            ->prepare("
insert into doctors
    (first_name, last_name, patronymic, date_of_birth, speciality_id, earning_in_percents, employee_status_id)
 values (?, ?, ?, ?, ?, ?, ?)");

        $query->execute(
            [
                $model->firstName,
                $model->lastName,
                $model->patronymic,
                $model->dateOfBirth,
                $model->specialityId,
                $model->earningInPercents,
                $model->statusId
            ]
        );
    }

    public function deleteById(int $id)
    {
        $query = $this->getConnection()
            ->prepare('
delete from doctors where id = ?
            ');

        $query->execute([
            $id,
        ]);
    }

    public function update(DoctorUpdateModel $model): void
    {
        $connection = $this->getConnection();

        $query = $connection
            ->prepare('
update doctors
set first_name = ?,
    last_name = ?,
    patronymic = ?,
    date_of_birth = ?,
    speciality_id = ?,
    employee_status_id = ?,
    earning_in_percents = ?
where id = ?');

        $query->execute([
            $model->firstName,
            $model->lastName,
            $model->patronymic,
            $model->dateOfBirth,
            $model->specialityId,
            $model->statusId,
            $model->earningInPercents,
            $model->id
        ]);
    }
}
