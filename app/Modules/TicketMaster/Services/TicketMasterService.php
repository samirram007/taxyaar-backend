<?php

namespace App\Modules\TicketMaster\Services;

use App\Modules\Document\Contracts\DocumentServiceInterface;
use App\Modules\TicketMaster\Contracts\TicketMasterServiceInterface;
use App\Modules\TicketMaster\Models\TicketMaster;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TicketMasterService implements TicketMasterServiceInterface
{
    protected $resource = [];

    public function __construct(
        protected DocumentServiceInterface $documentService
    ) {}

    public function getAll(): Collection
    {
        return TicketMaster::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketMaster
    {
        return TicketMaster::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketMaster
    {
        return DB::transaction(function () use ($data) {

            $pan  = $data['pan'];
            $data['ticket_id'] = $this->generateTicketId($pan);

            $file = $data['file'] ?? null;
            unset($data['file']);

            $ticket = TicketMaster::create($data);

            if ($file) {
                $this->documentService->store([
                    'file' => $file,
                    'documentable_id' => $ticket->id,
                    'documentable_type' => TicketMaster::class,
                ]);
            }

            return $ticket;
        });
    }


    private function generateTicketId(string $pan): string
    {
        $panPart = strtoupper(substr($pan, 0, 5));
        $epochSeconds = now()->timestamp;

        return $panPart . $epochSeconds;
    }

    public function update(array $data, int $id): TicketMaster
    {
        $record = TicketMaster::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketMaster::findOrFail($id);
        return $record->delete();
    }
}