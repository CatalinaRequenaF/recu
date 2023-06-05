<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function update_community(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $community = Community::factory()->create();


        $response = $this->patchJson(route('communities.update', $community), [
           
                "name" => 'test'
                
            
        ], [
            'Content-Type' => 'application/vnd.api+json'
        ]);
        
        $response->assertExactJson(  [ 

            "created_at" => $community->created_at,
            "id" => $community->id,
            "name" => 'test',
            "updated_at" => $response->original->updated_at
           ]);
           $response->assertStatus(201);
    }
}
