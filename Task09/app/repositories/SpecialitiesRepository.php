<?php

require_once '../app/repositories/Repository.php';
require_once '../app/dto/SpecialitiesDto.php';

class SpecialitiesRepository extends Repository
{

    public function findSpecialityIdByTitle(string $title): int
    {
        $query = $this->getConnection()
            ->prepare(
                '
                select s.id as id
                from specialties as s
                where s.title = :title
                '
            );
        $query->execute([$title]);
        return $query->fetch(PDO::FETCH_OBJ)->id;
    }

    /**
     * @return SpecialitiesDto[]
     */
    public function findAllSpecialities(): array {
        return $this->getConnection()
            ->query(
                '
                select s.title as title,
                       s.id as id
                from specialties as s
                '
            )
            ->fetchAll(PDO::FETCH_CLASS, SpecialitiesDto::class);
    }
}