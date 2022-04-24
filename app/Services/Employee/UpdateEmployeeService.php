<?php

namespace App\Services\Employee;

use App\Models\Employee;
use Barryvdh\Debugbar\Facades\Debugbar;

class UpdateEmployeeService
{
    public function __construct(array $employeeInformation, Employee $employee)
    {
        Debugbar::info($employeeInformation);
        $this->employee = $employee;

        $this->person = array(
            'firstName' => $employeeInformation['firstName'],
            'middleName' => $employeeInformation['middleName'],
            'lastName' => $employeeInformation['lastName'],
            'suffix' => $employeeInformation['suffix'],
            'position_id' => $employeeInformation['position'],
            'department_id' => $employeeInformation['department'],
            'status_id' => $employeeInformation['employeeStatus'],
            'degree_id' => $employeeInformation['degree'],
            'school_id' => $employeeInformation['school'],
            'yearGraduated' => $employeeInformation['yearGraduated'],
        );

        $this->contactNumber = $employeeInformation['contactNumber'];

        $this->address = array(
            'houseNumber' => $employeeInformation['houseNumber'],
            'streetName' => $employeeInformation['streetName'],
            'region' => $employeeInformation['region'],
            'province' => $employeeInformation['province'],
            'city' => $employeeInformation['city'],
            'barangay' => $employeeInformation['barangay'],
        );

        $this->emailAddress = array(
            'businessEmail' => $employeeInformation['businessEmail'],
            'alternateEmail' => $employeeInformation['alternateEmail'],
        );
    }

    public function updateEmployee(): void
    {
        $this->employee->update($this->person);
        $this->updateAddress($this->address);
        $this->updateEmailAddress($this->emailAddress);
        $this->updateContactNumber($this->contactNumber);
    }

    private function updateAddress(array $address): void
    {
        $this->employee->address()->update([
            'houseNumber' => $address['houseNumber'],
            'streetName' => $address['streetName'],
            'region' => $address['region'],
            'province' => $address['province'],
            'city' => $address['city'],
            'barangay' => $address['barangay'],
        ]);
    }

    private function updateEmailAddress(array $emailAddress): void
    {
        $this->employee->emailAddress()->update([
            'businessEmail' => $emailAddress['businessEmail'],
            'alternateEmail' => $emailAddress['alternateEmail'],
        ]);
    }

    private function updateContactNumber(string $contactNumber): void
    {
        $this->employee->contactNumber()->update([
            'contactNumber' => $contactNumber,
        ]);
    }
}
