<?php declare(strict_types=1);

class DoctorCreateModel
{
    public string $firstName;
    public string $lastName;
    public string $patronymic;
    public string $dateOfBirth;
    public int $specialityId;
    public int $earningInPercents;
    public int $statusId;

    public function __construct(string $firstName, string $lastName, string $patronymic, string $dateOfBirth, int $specialityId, int $earningInPercents, int $statusId)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->patronymic = $patronymic;
        $this->dateOfBirth = $dateOfBirth;
        $this->specialityId = $specialityId;
        $this->earningInPercents = $earningInPercents;
        $this->statusId = $statusId;
    }
}
