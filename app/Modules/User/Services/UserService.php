<?php

namespace App\Modules\User\Services;

use App\Modules\User\Contracts\UserServiceInterface;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function store(array $data): User
    {
        return User::create($data);
    }

    public function update(array $data, int $id): User
    {
        $record = User::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = User::findOrFail($id);
        return $record->delete();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByProvider(string $provider, string $providerId): ?User
    {
        return User::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();
    }

    public function findOrCreateFromProvider($socialUser, string $provider): User
    {
        $user = $this->findByProvider($provider, $socialUser->getId());

        if ($user) {
            return $user;
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'username' => $socialUser->getNickname() ?? str_replace('@', '_', $socialUser->getEmail()),
                'user_type' => 'user',
                'status' => 'active',
                'password' => bcrypt(Str::random(16)),
            ]);
        } else {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        return $user;
    }

    public function findOrRegisterFromProvider($socialUser, string $provider): User
    {
        $existing = $this->findByEmail($socialUser->getEmail());

        if ($existing) {
            throw ValidationException::withMessages([
                'email' => ['This email is already registered. Please login instead.'],
            ]);
        }

        return User::create([
            'name' => $socialUser->getName() ?? $socialUser->getNickname(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'username' => $socialUser->getNickname() ?? str_replace('@', '_', $socialUser->getEmail()),
            'user_type' => 'user',
            'status' => 'active',
            'password' => bcrypt(Str::random(16)),
        ]);
    }
}

