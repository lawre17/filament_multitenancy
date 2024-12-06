<?php

use App\Filament\Resources\TodoResource;
use App\Models\Tenant;
use App\Models\Todo;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;


it('has todoresource page', function () {

    $this->get(TodoResource::getUrl('index'))->assertSuccessful();
});

it('can render create page', function () {

    $this->get(TodoResource::getUrl('create'))->assertSuccessful();

});

it('can create a todo', function () {

    $user =Tenant::current()->users()->first();

    $todo = Todo::factory()->make();

    livewire(TodoResource\Pages\CreateTodo::class)
        ->fillForm([
            'title' => $todo->title,
            'description' => $todo->description,
            'completed' => (bool)$todo->completed,
            'tenant_user_id' => $user->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Todo::class, [
        'title' => $todo->title,
        'description' => $todo->description,
        'completed' => (bool)$todo->completed,
        'tenant_user_id' => $user->id,
    ]);
});

it('can list todos', function () {

    $user = Tenant::current()->users()->first();

    $todos = Todo::factory()->count(3)->create([
        'tenant_user_id' => $user->id,
    ]);

    $todos = Todo::all();

    livewire(TodoResource\Pages\ListTodos::class)
        ->assertCanSeeTableRecords($todos)
        ->assertCountTableRecords($todos->count());
});

it('can render edit page', function () {

    $this->get(TodoResource::getUrl('edit', [

        'record' => Todo::factory()->create(['tenant_user_id' => Tenant::current()->users()->first()->id])->id,

    ]))->assertSuccessful();

});

it('can retrieve todo data', function () {

    $todo = Todo::factory()->create(['tenant_user_id' => Tenant::current()->users()->first()->id]);

    livewire(TodoResource\Pages\EditTodo::class, [

        'record' => $todo->getRouteKey(),
    ])
        ->assertFormSet([
            'title' => $todo->title,
            'description' => $todo->description,
            'completed' => (bool)$todo->completed,
            'tenant_user_id' => $todo->tenant_user_id,
        ]);
});

it('can update a todo', function () {

    $user = Tenant::current()->users()->first();

    $todo = Todo::factory()->create([
        'tenant_user_id' => $user->id,
    ]);

    $newTodo = Todo::factory()->make();

    livewire(TodoResource\Pages\EditTodo::class, ['record' => $todo->getRouteKey()])
        ->fillForm([
            'title' => $newTodo->title,
            'description' => $newTodo->description,
            'completed' => (bool)$newTodo->completed,
            'tenant_user_id' => $user->id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($todo->refresh())
        ->title->toBe($newTodo->title)
        ->description->toBe($newTodo->description)
        ->completed->toBe((bool)$newTodo->completed)
        ->tenant_user_id->toBe($user->id);

});

it('can delete a todo', function () {

    $todo = Todo::factory()->create(['tenant_user_id' => Tenant::current()->users()->first()->id]);

    livewire(TodoResource\Pages\EditTodo::class, [
        'record' => $todo->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($todo);
});
