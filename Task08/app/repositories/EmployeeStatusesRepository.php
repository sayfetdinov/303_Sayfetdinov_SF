<?php

require_once '../app/repositories/Repository.php';
require_once '../app/dto/EmployeeStatusesDto.php';

class EmployeeStatusesRepository extends  Repository
{
    public function findEmployeeStatusById(string $title): int {
        $query = $this->getConnection()
            ->prepare(
                '
                select e.id as id
                from employee_statuses as e
                where e.title = :title
                '
            );
        $query->execute([$title]);
        return $query->fetch(PDO::FETCH_OBJ)->id;
    }

    /**
     * @return EmployeeStatusesDto[]
     */
    public function findAllEmployeeStatuses(): array {
        return $this->getConnection()
            ->query(
                '
                select s.title as title,
                       s.id as id
                from employee_statuses as s
                '
            )
            ->fetchAll(PDO::FETCH_CLASS, EmployeeStatusesDto::class);
    }
}