<?php

namespace App\Modules\HelpCenter\Services;

use App\Modules\HelpCenter\Contracts\HelpCenterServiceInterface;
use App\Modules\HelpCenter\Models\HelpCenter;
use App\Modules\TopicArticle\Models\TopicArticle;
use Illuminate\Database\Eloquent\Collection;

class HelpCenterService implements HelpCenterServiceInterface
{
    protected $resource = [];

    public function getAll(): Collection
    {
        return HelpCenter::with($this->resource)->get();
    }

    public function getById(int $id): ?HelpCenter
    {
        return HelpCenter::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): HelpCenter
    {
        return HelpCenter::create($data);
    }

    public function update(array $data, int $id): HelpCenter
    {
        $record = HelpCenter::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = HelpCenter::findOrFail($id);
        return $record->delete();
    }
    public function searchArticle(string $query): Collection
    {
        $result = TopicArticle::where('title', 'like', "%$query%");
        //dd($result->toRawSql());
        return TopicArticle::where('title', 'like', "%$query%")
            ->orWhere('slug', 'like', "%$query%")
            ->orWhere('content', 'like', "%$query%")
            ->select('id', 'title', 'slug', )
            ->limit(10)
            ->get();
    }
}
