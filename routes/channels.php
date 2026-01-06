<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel("online", function ($user) {
    if ($user instanceof \App\Models\Admin) {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "type" => "admin"
        ];
    } elseif ($user instanceof \App\Models\Customer) {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "type" => "customer"
        ];
    }

    return false;
}, ['guards' => ['admin', 'customer']]);
