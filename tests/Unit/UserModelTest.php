<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    /** @test    * */
    public function a_user_owns_a_model()
    {
        $userA = $this->createUser();
        $userB = $this->createUser();


        $ownedbyUserA = new OwnedModel(['user_id' => $userA->id]);
        $ownedbyUserB = new OwnedModel(['user_id' => $userB->id]);

        $this->assertTrue($userA->owns($ownedbyUserA));
        $this->assertTrue($userB->owns($ownedbyUserB));

        $this->assertFalse($userA->owns($ownedbyUserB));
        $this->assertFalse($userB->owns($ownedbyUserA));

    }
}

class OwnedModel extends Model{
    protected $guarded = [];
}