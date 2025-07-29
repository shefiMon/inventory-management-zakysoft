<?php

namespace App\Jobs;

use App\Models\StockLog;
use App\Models\StockMovement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class StockLogJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $stockMovement;
    public function __construct(StockMovement $stockMovement)
    {
        $this->user = auth()->user();
        $this->stockMovement = $stockMovement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            // Log the stock movement
           StockLog::create([
                'stock_movement_id' => $this->stockMovement->id,
                'user_id' => $this->user->id ?? null,
                'action' => 'created',
                'details' => json_encode($this->stockMovement),
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            Log::debug('Failed to log stock movement: ' . $e->getMessage());
        }

    }
}


