<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostPolicyTest extends TestCase
{
    Use RefreshDatabase;

    /** @test */
    function admins_can_update_posts(){
        $admin = $this->createAdmin();

//        $this->be($admin);

        $post = factory(Post::class)->create();

        $result = Gate::forUser($admin)->allows('update-post', $post);

        $this->assertTrue($result);
    }

    /** @test */
    function guests_cannot_update_posts(){

        $post = factory(Post::class)->create();

        $result = Gate::allows('update-post', $post);

        $this->assertFalse($result);
    }


    /** @test */
    function unauthorized_users_cannot_update_posts(){

        $user = $this->createUser();

//        $this->be($admin);

        $post = factory(Post::class)->create();

        $result = Gate::forUser($user)->allows('update-post', $post);

        $this->assertFalse($result);
    }


    /** @test */
    function authors_can_update_posts(){

        $user = $this->createUser();

        $this->be($user);

        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $result = Gate::forUser($user)->allows('update-post', $post);

        $this->assertTrue($result);
    }


}
