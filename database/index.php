<?php
require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/db.php";

use Illuminate\Database\Capsule\Manager;

Manager::schema()->dropIfExists('users');
Manager::schema()->create('users', function ($table) {
    $table->id('id');
    $table->bigInteger('logged')->nullable();
    $table->bigInteger('level')->default('1');
    $table->string('status', 50)->nullable()->comment('1 ativo 2 inativo');
    $table->string('first_name')->nullable();
    $table->string('last_name')->nullable();
    $table->string('email')->unique();
    $table->string('password')->nullable();
    $table->string('telephone')->nullable();
    $table->string('forget')->nullable();
    $table->string('token')->nullable();
    $table->string('genre', 20)->nullable()->comment('1 male, 2 female');
    $table->string('document')->nullable();
    $table->string('photo')->nullable();
    $table->string('facebook_id')->nullable();
    $table->string('google_id')->nullable();
    $table->string('user_login')->nullable();
    $table->string('ip')->nullable();
    $table->string('lastaccess')->nullable();
    $table->date('datebirth')->nullable();
    $table->timestamps();
});

Manager::schema()->dropIfExists('address');
Manager::schema()->create('address', function ($table) {
    $table->id('id');
    $table->unsignedBigInteger('user_id');
    $table->string('zipcode')->nullable();
    $table->string('street')->nullable();
    $table->string('number')->nullable();
    $table->string('complement')->nullable();
    $table->string('district')->nullable();
    $table->string('city')->nullable();
    $table->string('state')->nullable();
    $table->string('country')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
});

Manager::schema()->dropIfExists('categories');
Manager::schema()->create('categories', function ($table) {
    $table->id('id');
    $table->bigInteger('status')->default('1');
    $table->string('uri')->nullable();
    $table->string('type')->nullable();
    $table->text('description')->nullable();
    $table->timestamps();
});

Manager::schema()->dropIfExists('posts');
Manager::schema()->create('posts', function ($table) {
    $table->id('id');
    $table->unsignedBigInteger('author')->nullable();
    $table->unsignedBigInteger('category');
    $table->string('status', 20)->default('1')->comment('1 ativo, 2 inativo');
    $table->string('title')->nullable();
    $table->string('uri')->nullable();
    $table->string('cover')->nullable();
    $table->string('video')->nullable();
    $table->string('tag')->nullable();
    $table->text('subtitle')->nullable();
    $table->text('content')->nullable();
    $table->decimal('views', 10, 2)->nullable();
    $table->timestamp('post_at')->nullable();
    $table->timestamps();

    $table->foreign('category')->references('id')->on('categories')->onDelete('CASCADE');
    $table->foreign('author')->references('id')->on('users')->onDelete('CASCADE');
});