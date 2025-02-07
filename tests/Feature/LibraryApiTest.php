<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryApiTest extends TestCase
{
    use RefreshDatabase;

    protected $librarian;
    protected $user;
    protected $book;

    protected function setUp(): void
    {
        parent::setUp();

        // Создание тестовых данных
        $this->librarian = User::factory()->create(['role' => 'librarian']);
        $this->user = User::factory()->create();
        $this->book = Book::factory()->create();
    }

    // Тест регистрации пользователя
    public function test_user_registration()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user']);
    }

    // Тест авторизации пользователя
    public function test_user_login()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['access_token']);
}

    // Тест создания книги библиотекарем
    public function test_librarian_create_book()
    {
        $librarian = User::factory()->create(['role' => 'librarian']);
        $token = auth('api')->login($librarian);
    
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/books', [
                'title' => 'New Book',
                'author' => 'Author',
                'description' => 'Test Description',
            ]);
    
        $response->assertStatus(201);
    }

    // Тест процесса взятия и возврата книги
    public function test_book_borrow_flow()
{
    $user = User::factory()->create();
    $book = Book::factory()->create();

    // Авторизация пользователя
    $token = auth('api')->login($user);

    // Взять книгу
    $borrowResponse = $this->withHeader('Authorization', "Bearer $token")
        ->postJson("/api/books/{$book->id}/borrow");

    $borrowResponse->assertStatus(200);

    // Вернуть книгу
    $returnResponse = $this->withHeader('Authorization', "Bearer $token")
        ->postJson("/api/books/{$book->id}/return");

    $returnResponse->assertStatus(200);
}
}
