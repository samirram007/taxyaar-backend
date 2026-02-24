<?php

namespace App\Modules\Employee\Services;

use App\Modules\AccountLedger\Models\AccountLedger;
use App\Modules\Employee\Contracts\EmployeeServiceInterface;
use App\Modules\Employee\Models\Employee;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EmployeeService implements EmployeeServiceInterface
{
    protected $resource = ['department', 'designation', 'address', 'user'];

    public function getAll(): Collection
    {
        return Employee::with($this->resource)->get();
    }

    public function getById(int $id): ?Employee
    {
        return Employee::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): Employee
    {
        //dd($data);
        if (empty($data['code'])) {

            $data['code'] = Employee::getUniqueCode();
            //dd($data);
        }

        $employee = Employee::create($data);
        // dd($data);
        if ($data['address']) {

            $data['address']['address_type'] = 'office';
            $data['address']['addressable_type'] = 'employee';
            $data['address']['addressable_id'] = $employee->id;

            $employee->address()->create($data['address']);
        }

        if (!empty($data['has_user_account']) && !empty($data['email'])) {
            if (!User::where('username', $data['email'])->exists()) {
                $data['user']['name'] = $employee->name;
                $data['user']['email'] = $employee->email;
                $data['user']['username'] = $employee->email;
                $data['user']['user_type'] = 'user';
                $data['user']['password'] = bcrypt('password');
                $data['user']['userable_type'] = 'employee';
                $data['user']['userable_id'] = $employee->id;
                $data['user']['status'] = 'active';
                $employee->user()->create($data['user']);

            }
        }


        return $employee->load($this->resource);
    }




    public function update(array $data, int $id): Employee
    {

        if (empty($data['code'])) {
            $data['code'] = $this->getUniqueCode();
        }
        $employee = Employee::findOrFail($id);
        $previousName = $employee->name;
        $employee->update($data);

        if (isset($data['address'])) {

            $data['address']['address_type'] = 'office';
            $data['address']['addressable_type'] = 'employee';
            $data['address']['addressable_id'] = $employee->id;
            if (!empty($data['address']['id'])) {
                $address = $employee->address()->find($data['address']['id']);
                // dd($address);
                $address?->update($data['address']);
            } else {
                $employee->address()->create($data['address']);
            }
        }
        // $isDirty = $previousName != $data['name'] ? true : false;



        if (!empty($data['has_user_account']) && !empty($data['email'])) {
            if (!User::where('username', $data['email'])->exists()) {
                $data['user']['name'] = $employee->name;
                $data['user']['email'] = $employee->email;
                $data['user']['username'] = $employee->email;
                $data['user']['user_type'] = 'user';
                $data['user']['password'] = bcrypt('password');
                $data['user']['userable_type'] = 'employee';
                $data['user']['userable_id'] = $employee->id;
                $data['user']['status'] = 'active';
                $employee->user()->create($data['user']);

            }
        }

        return $employee->fresh()->load($this->resource);
    }

    public function delete(int $id): bool
    {
        $record = Employee::findOrFail($id);
        return $record->delete();
    }
}
