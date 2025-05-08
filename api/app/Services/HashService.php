<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class HashService
{
    public function cryptString(string $value): string
    {
        return Hash::make($value);
    }
    public function check($uncrypted, $crypted): string
    {
        return Hash::check($uncrypted, $crypted);
    }
}
