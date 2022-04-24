<?php

namespace App\Services\Client;

use App\Models\Client;
use Barryvdh\Debugbar\Facades\Debugbar;

class UpdateClientService
{
    public function __construct(array $clientInformation, Client $client)
    {
        Debugbar::info($clientInformation);
        $this->client = $client;

        $this->person = array(
            'firstName' => $clientInformation['firstName'],
            'middleName' => $clientInformation['middleName'],
            'lastName' => $clientInformation['lastName'],
            'suffix' => $clientInformation['suffix'],
        );

        $this->contactNumber = $clientInformation['contactNumber'];

        $this->address = array(
            'houseNumber' => $clientInformation['houseNumber'],
            'streetName' => $clientInformation['streetName'],
            'region' => $clientInformation['region'],
            'province' => $clientInformation['province'],
            'city' => $clientInformation['city'],
            'barangay' => $clientInformation['barangay'],
        );

        $this->emailAddress = $clientInformation['emailAddress'];
        $this->organization = $clientInformation['organization'];
    }

    public function updateClient(): void
    {
        $this->client->update($this->person);
        $this->updateAddress($this->address);
        $this->updateEmailAddress($this->emailAddress);
        $this->updateContactNumber($this->contactNumber);
        $this->updateOrganization($this->organization);
    }

    private function updateAddress(array $address): void
    {
        $this->client->address()->update([
            'houseNumber' => $address['houseNumber'],
            'streetName' => $address['streetName'],
            'region' => $address['region'],
            'province' => $address['province'],
            'city' => $address['city'],
            'barangay' => $address['barangay'],
        ]);
    }

    private function updateEmailAddress(string $emailAddress): void
    {
        $this->client->emailAddress()->update([
            'emailAddress' => $emailAddress,
        ]);
    }

    private function updateContactNumber(string $contactNumber): void
    {
        $this->client->contactNumber()->update([
            'contactNumber' => $contactNumber,
        ]);
    }

    private function updateOrganization(string $organization): void
    {
        $this->client->organization()->update([
            'name' => $organization,
        ]);
    }
}
