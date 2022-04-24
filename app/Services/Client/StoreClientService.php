<?php

namespace App\Services\Client;

use App\Models\Client;
use Barryvdh\Debugbar\Facades\Debugbar;

class StoreClientService
{
    public function __construct(array $client)
    {
        Debugbar::info($client);

        $this->person = array(
            'firstName' => $client['firstName'],
            'middleName' => $client['middleName'],
            'lastName' => $client['lastName'],
            'suffix' => $client['suffix'],
            'created_by' => auth()->user()->employee_id,
        );

        $this->contactNumber = $client['contactNumber'];

        $this->address = array(
            'houseNumber' => $client['houseNumber'],
            'streetName' => $client['streetName'],
            'region' => $client['region'],
            'province' => $client['province'],
            'city' => $client['city'],
            'barangay' => $client['barangay'],
        );

        $this->emailAddress = $client['emailAddress'];
        $this->organization = $client['organization'];

        if (array_key_exists('image', $client)) {
            $this->profilePicture = $client['image'];
        } else {
            $this->profilePicture = 'profile-pictures/default.png';
        }
    }

    public function storeClient(): void
    {
        $this->client = Client::create($this->person);
        $this->storeAddress($this->address);
        $this->storeEmailAddress($this->emailAddress);
        $this->storeContactNumber($this->contactNumber);
        $this->storeOrgaization($this->organization);
        $this->profilePicture();
    }

    private function storeAddress(array $address): void
    {
        $this->client->address()->create([
            'houseNumber' => $address['houseNumber'],
            'streetName' => $address['streetName'],
            'region' => $address['region'],
            'province' => $address['province'],
            'city' => $address['city'],
            'barangay' => $address['barangay'],
        ]);
    }

    private function storeEmailAddress(string $emailAddress): void
    {
        $this->client->emailAddress()->create([
            'emailAddress' => $emailAddress,
        ]);
    }

    private function storeContactNumber(string $contactNumber): void
    {
        $this->client->contactNumber()->create([
            'contactNumber' => $contactNumber,
        ]);
    }

    private function storeOrgaization(string $organization): void
    {
        $this->client->organization()->create([
            'name' => $organization,
        ]);
    }

    private function profilePicture(): void
    {
        $this->client->addMedia($this->profilePicture)
            ->preservingOriginal()->toMediaCollection('client_profile_picture');
    }
}
