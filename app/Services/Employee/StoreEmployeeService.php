<?php

namespace App\Services\Employee;

use App\Models\Employee;
use Illuminate\Support\Carbon;

class StoreEmployeeService
{
    public function __construct(array $employee)
    {
        $this->person = array(
            'employeeNumber' => $this->generateEmployeeNumber(),
            'firstName' => $employee['firstName'],
            'middleName' => $employee['middleName'],
            'lastName' => $employee['lastName'],
            'suffix' => $employee['suffix'],
            'dateHired' => Carbon::now()->format('Y-m-d'),
            'position_id' => $employee['position'],
            'department_id' => $employee['department'],
            'status_id' => $employee['employeeStatus'],
            'degree_id' => $employee['degree'],
            'school_id' => $employee['school'],
            'created_by' => auth()->user()->employee_id,
            'yearGraduated' => $employee['yearGraduated'],
        );

        $this->contactNumber = $employee['contactNumber'];

        $this->address = array(
            'houseNumber' => $employee['houseNumber'],
            'streetName' => $employee['streetName'],
            'region' => $employee['region'],
            'province' => $employee['province'],
            'city' => $employee['city'],
            'barangay' => $employee['barangay'],
        );

        $this->emailAddress = array(
            'businessEmail' => $employee['businessEmail'],
            'alternateEmail' => $employee['alternateEmail'],
        );

        if (array_key_exists('achievements', $employee)) {
            $this->achievements = $employee['achievements'];
        }

        if (array_key_exists('skills', $employee)) {
            $this->skills = $employee['skills'];
        }

        if (array_key_exists('image', $employee)) {
            $this->profilePicture = $employee['image'];
        } else {
            $this->profilePicture = 'profile-pictures/default.png';
        }

        if (array_key_exists('files', $employee)) {
            $this->files = $employee['files'];
        }
    }

    public function storeEmployee(): void
    {
        $this->employee = Employee::create($this->person);
        $this->storeAddress($this->address);
        $this->storeEmailAddress($this->emailAddress);
        $this->storeContactNumber($this->contactNumber);
        $this->profilePicture();

        if (isset($this->achievements)) {
            $this->storeAchievements($this->achievements);
        }
        if (isset($this->skills)) {
            $this->storeSkills($this->skills);
        }
        $this->attachments();
    }

    private function storeAddress(array $address): void
    {
        $this->employee->address()->create([
            'houseNumber' => $address['houseNumber'],
            'streetName' => $address['streetName'],
            'region' => $address['region'],
            'province' => $address['province'],
            'city' => $address['city'],
            'barangay' => $address['barangay'],
        ]);
    }

    private function storeEmailAddress(array $emailAddress): void
    {
        $this->employee->emailAddress()->create([
            'businessEmail' => $emailAddress['businessEmail'],
            'alternateEmail' => $emailAddress['alternateEmail'],
        ]);
    }

    private function storeContactNumber(string $contactNumber): void
    {
        $this->employee->contactNumber()->create([
            'contactNumber' => $contactNumber,
        ]);
    }

    private function storeAchievements(array $achievements): void
    {
        $this->employee->achievements()->createMany($achievements);
    }

    private function storeSkills(array $skills): void
    {
        $this->employee->skills()->createMany($skills);
    }

    private function profilePicture(): void
    {
        $this->employee->addMedia($this->profilePicture)
            ->preservingOriginal()->toMediaCollection('employee_profile_picture');
    }

    private function attachments(): void
    {
        if (isset($this->files)) {
            foreach ($this->files as $file) {
                $this->employee->addMedia($file)
                    ->toMediaCollection('employee_attachments');
            }
        }
    }

    private function generateEmployeeNumber(): string
    {
        $recentEmployee = Employee::latest()->first()->employeeNumber;
        $currentYear = Carbon::now()->format('Y');
        $currentMonth = Carbon::now()->format('m');

        if ($recentEmployee) {
            $recentEmployeeNumber = explode("-", $recentEmployee);
            $series = intval($recentEmployeeNumber[2]) + 1;
            $employeeID = $currentYear . '-' . $currentMonth . '-';

            if (
                $currentYear == $recentEmployeeNumber[0] &&
                $currentMonth == $recentEmployeeNumber[1]
            ) {
                $digits = $this->countDigits($series);
                if ($digits == 1) {
                    return ($employeeID . '000' . $series);
                } else if ($digits == 2) {
                    return ($employeeID . '00' . $series);
                } else if ($digits == 3) {
                    return ($employeeID . '0' . $series);
                } else {
                    return ($employeeID .= $series);
                }
            } else {
                return ($employeeID . '0001');
            }
        } else {
            return ($currentYear . '-' . $currentMonth . '-0001');
        }
    }

    private function countDigits($number)
    {
        $number = (int)$number;
        $count = 0;

        while ($number != 0) {
            $number = (int)($number / 10);
            $count++;
        }

        return $count;
    }
}
