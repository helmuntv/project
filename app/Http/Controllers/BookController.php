<?php

namespace App\Http\Controllers;

use App\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller {
	use ApiResponser;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Return books list
	 *
	 * @return Illuminate\Http\Response
	 */
	public function index() {
		$books = Book::all();

		return $this->successResponse($books);
	}

	/**
	 * Create an instance of a book
	 *
	 * @return Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$rules = [
			'title' => 'required|max:255',
			'description' => 'required|max:255',
			'price' => 'required|min:1',
			'author_id' => 'required|author_id|min:1|unique:authors,id',
		];

		$this->validate($request, $rules);

		$book = Book::create($request->all());

		return $this->successResponse($book, Response::HTTP_CREATED);
	}

	/**
	 * return an specific book
	 *
	 * @return Illuminate\Http\Response
	 */
	public function show($id) {
		$book = Book::findOrFail($id);

		return $this->successResponse($book);
	}

	/**
	 * update the information of an existing book
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {

	}

	/**
	 * delete an existing book
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id) {

	}

}