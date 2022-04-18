<?php

namespace Tests\Feature\Card;

use App\Models\Card;
use Tests\TestCase;

abstract class AbstractWithExistingCardContext extends TestCase{

    protected Card $card;

    protected function setUp(): void
    {
        parent::setUp();
        $this->card = Card::factory()->createOne();
    }

}
