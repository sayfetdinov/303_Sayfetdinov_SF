<?php declare(strict_types=1);

class DoctorFullModel
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public ?string $patronymic;
    public string $dateOfBirth;
    public int $specialityId;
    public string $earning;
    public int $statusId;
    public string $status;
    public string $speciality;
}
