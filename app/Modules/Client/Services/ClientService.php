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

    public function getById(string $pan): ?Client
    {
        return Client::where('pan', $pan)->firstOrFail();
    }

    public function store(array $data): Client
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = Auth::id();
            $client = Client::create($data);

            $country = !empty($data['isd_cd'])
                ? Country::where('phone_code', $data['isd_cd'])->first()
                : null;

            $state = !empty($data['state_cd'])
                ? State::where('gst_code', $data['state_cd'])->first()
                : null;



            $addressData = [
                'line1' => $data['address_line_1'] ?? null,
                'landmark' => $data['address_line_2'] ?? null,
                'district' => $data['address_line_3'] ?? null,
                'city' => $data['address_line_4'] ?? null,
                'post_office' => $data['address_line_5'] ?? null,
                'postal_code' => $data['pin_cd'] ?? null,

                'country_id' => $country?->id,
                'state_id' => $state?->id,

                'address_type' => 'client',
                'is_primary' => true,

                'addressable_id' => $client->id,
                'addressable_type' => 'client',
            ];

            $hasAddress = collect($addressData)->filter()->isNotEmpty();

            if ($hasAddress) {
                Address::create([
                    ...$addressData,

                    'country_id' => $country?->id,
                    'state_id' => $state?->id,

                    'address_type' => 'client',
                    'is_primary' => true,

                    'addressable_id' => $client->id,
                    'addressable_type' => 'client',
                ]);
            }
            DB::commit();

            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, string $pan): Client
    {

        $record = Client::where('pan', $pan)->firstOrFail();
        $record->update($data);
        return $record->fresh();
    }

    public function delete(string $pan): bool
    {
        $record = Client::where('pan', $pan)->firstOrFail();
        return $record->delete();
    }
}
