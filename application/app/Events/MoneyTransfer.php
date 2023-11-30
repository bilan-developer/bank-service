<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MoneyTransfer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     *  Create a new event instance.
     *
     * @param Model $model
     * @param string $typeCode
     * @param array $data
     */
    public function __construct(public Model $model, public string $typeCode, public array $data = [])
    {
    }
}
