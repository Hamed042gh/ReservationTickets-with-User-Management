<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tickets', function ($user, $id) {
    return true;
});
