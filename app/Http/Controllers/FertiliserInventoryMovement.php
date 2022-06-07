<?php

namespace App\Http\Controllers;

use App\Http\Requests\FertiliserInventoryMovementRequest;
use App\Http\Services\FertiliserInventoryService;
use Illuminate\Http\RedirectResponse;

class FertiliserInventoryMovement extends Controller
{
    protected FertiliserInventoryService $fertiliserInventoryService;

    public function __construct(FertiliserInventoryService $fertiliserInventoryService)
    {
        $this->fertiliserInventoryService = $fertiliserInventoryService;
    }

    /**
     * Process stock request
     *
     * @param FertiliserInventoryMovementRequest $request
     * @return RedirectResponse
     */
    public function __invoke(FertiliserInventoryMovementRequest $request): RedirectResponse
    {
        $stock = $this->fertiliserInventoryService->requestStock($request->get('quantity'));

        if ($stock) {
            $data = [
                'success' => "Successfully applied requested stocks.",
                'data' => array_merge($stock, ['remaining' => $this->fertiliserInventoryService->stock()])
            ];
        } else {
            $data = [
                'error' => "The stocks are not enough. We have " . $this->fertiliserInventoryService->stock() . " stocks left."
            ];
        }

        return redirect(route('home'))->with($data);
    }
}
