<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{

    use RefreshDatabase;


    public function testNoBlogPostInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        $post = new BlogPost();
        $post->title = "New title";
        $post->content = "content of blog post";
        $post->save();

        $response = $this->get('/posts');

        $response->assertSeeText('New title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

            $this->assertEquals(session('status'), 'The blog post was created');
    }
}
