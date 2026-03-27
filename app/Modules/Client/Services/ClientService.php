<?php

namespace App\Modules\Client\Services;

use App\Modules\Address\Models\Address;
use App\Modules\Client\Contracts\ClientServiceInterface;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Models\Country;
use App\Modules\State\Models\State;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientService implements ClientServiceInterface
{
    protected $resource = [];

    public function getAll(): Collection
    {
        return Client::with($this->resource)->get();
    }

    public function getById(int $id): ?Client
    {
        return Client::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): Client
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = Auth::id();
            $client = Client::create($data);

            $country = Country::where('phone_code', $data['isd_cd'] ?? null)->first();

            $state = State::where('state_code', $data['state_cd'] ?? null)->first();

            Address::create([
                'line1' => $data['address_line_1'] ?? null,
                'landmark' => $data['address_line_2'] ?? null,
                'district' => $data['address_line_3'] ?? null,
                'city' => $data['address_line_4'] ?? null,
                'post_office' => $data['address_line_5'] ?? null,

                'country_id' => $country?->id,
                'state_id' => $state?->id,

                'postal_code' => $data['pin_cd'] ?? null,

                'address_type' => 'client',
                'is_primary' => true,

                'addressable_id' => $client->id,
                'addressable_type' => 'client',
            ]);

            DB::commit();

            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, int $id): Client
    {
        $record = Client::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = Client::findOrFail($id);
        return $record->delete();
    }
}
