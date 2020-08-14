<?php

namespace Tests\Feature;

use App\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDataBase;

    public function testNoBlogPostYetWhenNothingInDatabase()
    {
        $response=$this->get('/posts');
        $response->assertSeeText('No Blog Post Yet!'); 
    }

    public function testSee1BlogPostWhenThereIs1WithComments()
    {
        //Arrange
        $post=$this->createDummyBlogPost();

        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comment yet!');

        $this->assertDatabaseHas('blog_posts',[
            'title'=>'New Title'
        ]);
    }

    // public function testSee1BlogPostWithComments()
    // {
    //     //Arrange
    //     $post=new BlogPost();
    //     $post->title='New Title';
    //     $post->content='Content of the blog post';
    //     $post->save();

    //     $response=$this->get('/posts');

    // }



    public function testStoreValid()
    {
        //Arange
        $params=[
            'title'=>'Valid Title',
            'content'=> 'At least 10 characters'
        ];

        //Act
        $this->actingAs($this->user())->post('/posts',$params)->assertStatus(302)->assertSessionHas('status');
        
        $this->assertEquals(session('status'),'Blog post created successfully!');


    }

    public function testStoreFail()
    {
        $params=[
            'title'=>'x',
            'content'=>'x'
        ];

        $this->actingAs($this->user())->post('/posts',$params)->assertStatus(302)->assertSessionHas('errors');

        $messages=session('errors')->getMessages();
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
        // dd($messages->getMessages());
    }

    public function testUpdateValid()
    {
        // $post=new BlogPost();
        // $post->title='New Title';
        // $post->content='Content of the blog post';
        // $post->save();
        $post=$this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts',[
            'title'=>'New Title',
            // 'content'=>'Content of the blog post'
        ]);

        $params=[
            'title'=>'New title changed',
            'content'=>'Content of the blog post changed'
        ];
        

        $this->actingAs($this->user())->put("/posts/{$post->id}",$params)->assertStatus(302)
        // ->assertSessionHas('status')
        ;

        // $this->assertEquals(session('status'),'Blog post was updated!');


    }

    // public function testDelete()
    // {
    //     $post=new BlogPost();
    //     $post->title='New Title';
    //     $post->content='Content of the blog post';
    //     $post->save();

    //     // $this->assertDatabaseHas('blog_posts',$post->toArray());
    //     $this->assertDatabaseHas('blog_posts',[
    //         'title'=>'New Title'
    //     ]);

    //     $this->actingAs($this->user())->delete('/posts/{$post->id}')->assertStatus(302)
    //     // ->assertSessionHas('status')
    //     ;
    //     // $this->assertEquals(session('status'),'Blog post was deleted!');
    // }

    private function createDummyBlogPost()
    {
        // $post=new BlogPost();
        // $post->title='New Title';
        // $post->content='Content of the blog post';
        // $post->save();

        return factory(BlogPost::class)->states('new-title')->create();

        // return $post;
    }

    
}
