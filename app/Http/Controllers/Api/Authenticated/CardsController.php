<?php

namespace App\Http\Controllers\Api\Authenticated;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authenticated\Card\UpdateCardRequest;
use App\Models\Card;
use App\Services\CRUD\Card\DesactivateCardService;
use App\Services\CRUD\Card\UpdateCardService;

class CardsController extends Controller
{
    public function read( Card $card ){
        return response( $card );
    }

    public function update( UpdateCardRequest $request, Card $card ){

        $service = new UpdateCardService( $card, $request->validated() );

        try {
            if( $updated = $service->run() )
                return response()->json( $updated );
        } catch (\Throwable $th) {
            report( $th );
        }

        return response( null, 503 );
    }

    public function desactivate( Card $card ){

        $service = new DesactivateCardService( $card );

        try {
            if( $deleted = $service->run() )
                return response()->json( $deleted );
        } catch (\Throwable $th) {
            report( $th );
        }

        return response( null, 503 );
    }
}
