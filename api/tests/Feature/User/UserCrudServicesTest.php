<?php

namespace Tests\Feature\User;

use App\Models\User;
use App\Services\CRUD\User\CreateUserService;
use App\Services\CRUD\User\DesactivateUserService;
use App\Services\CRUD\User\UpdateUserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudServicesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_user(){

        $data = [
            "email" => "test@test.com",
            "name" => "tester",
            "password" => Hash::make( "123456" )
        ];

        $service = new CreateUserService($data);
        $result = $service->run();

        foreach( $data as $prop=> $value )
            $this->assertEquals( $result->{$prop}, $value );

        $this->assertDatabaseHas( User::class, $data );
    }

    public function test_update_user(){
        $user = User::factory()->createOne();

        $data = [
            'name' => 'Test - edited',
            'email' => 'email.edited@email.com'
        ];
        $service = new UpdateUserService( $user, $data );

        $result = $service->run();
        foreach( $data as $prop=> $value )
            $this->assertEquals( $result->{$prop}, $value );

        $data = array_merge(['id' => $user->id,], $data );
        $this->assertDatabaseHas( User::class, $data );
    }

    public function test_desactivate_user(){
        $user = User::factory()->createOne();
        $service = new DesactivateUserService( $user );
        $result = $service->run();
        $this->assertNotFalse( $result );
        $this->assertNotNull( $result->deleted_at );
        $this->assertNotNull( $user->deleted_at );
        $this->assertDatabaseHas( User::class, [
            'id' => $user->id,
            ['deleted_at', '<>', null ]
        ] );

    }


}
