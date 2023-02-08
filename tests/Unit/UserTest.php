<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** 
     * @test
     */
    public function test_dump_user_password_hash()
    {
        $user = User::find(1);

        $resp = $this->call('POST', 'users/1', [
            '_token'    => csrf_token(),
            '_method'   => 'PUT',
            'username'  => 'admin',
            'password'  => Hash::make('admin'),
            'email'     => 'test@hitcorporation.com'
        ]);
        $resp->dump();
    }
}
