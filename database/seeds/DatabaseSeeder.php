<?php

use App\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		//factory(Author::class, 50)->create();

		factory(Book::class, 200)->create();
	}
}
