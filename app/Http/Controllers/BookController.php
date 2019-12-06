<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

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

		$author = Author::find($request->author_id);

		if(!$author && !$empty){
			return $this->errorMessage('No se encontro un instancia para el autor solicitado', Response::HTTP_NOT_FOUND);
		}

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
		$rules = [
			'title' => 'max:255',
			'description' => 'max:255',
			'price' => 'min:1',
			'author_id' => 'author_id|min:1|unique:authors,id',
		];

		$this->validate($request, $rules);

		$book = Book::findOrFail($id);

		$book->fill($request->all());

		if ($book->isClean()) {
			return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$book->save();

		return $this->successResponse($book);
	}

	/**
	 * delete an existing book
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id) {
		$book = Book::findOrFail($id);

		$book->delete();

		return $this->successResponse($book);
	}

}