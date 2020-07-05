<?php

namespace Tests\Feature;

use App\Member;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class MemberControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithoutMiddleware;

    public function testGetRequestAll()
    {
        $response = $this->get('/api/members');
        $response->assertStatus(200);
    }

    public function testStore() {
        $member = factory(Member::class)->make();
        $response = $this->json('POST', 'api/members', $member->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('members', $member->toArray());
    }

    public function testEmptyStore()
    {
        $response = $this->json('POST','/api/members', []);
        $response->assertStatus(422);
    }

    public function testShow() {
        $member = factory(Member::class)->create();
        $response = $this->json('GET', 'api/members/'.$member->id);
        $response->assertStatus(200);
    }

    public function testUpdate() {
        $member = factory(Member::class)->create();
        $newMember = factory(Member::class)->make();
        $response = $this->json('PUT', 'api/members/'.$member->id, $newMember->toArray());
        $response->assertStatus(200);
        $member->refresh();
        $this->assertArraySubset($newMember->toArray(), $member->toArray());
    }

    public function testDestroy() {
        $member = factory(Member::class)->create();
        $response = $this->json('DELETE', 'api/members/'.$member->id);
        $response->assertStatus(200);
        $this->assertDeleted($member);
    }
}
