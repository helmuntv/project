<?php

namespace App\Http\Controllers;

use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller {
	use ApiResponser;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Return author list
	 *
	 * @return Illuminate\Http\Response
	 */
	public function index() {
		$authors = Author::all();

		return $this->successResponse($authors);
	}

	/**
	 * Create an instance of author
	 *
	 * @return Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$rules = [
			'name' => 'required|max:255',
			'gender' => 'required|max:255|in:male,female',
			'country' => 'required|max:255',
		];

		$this->validate($request, $rules);

		$author = Author::create($request->all());

		return $this->successResponse($author, Response::HTTP_CREATED);
	}

	/**
	 * return an specific author
	 *
	 * @return Illuminate\Http\Response
	 */
	public function show($id) {
		$author = Author::findOrFail($id);

		return $this->successResponse($author);
	}

	/**
	 * update the information of an existing author
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$rules = [
			'name' => 'max:255',
			'gender' => 'max:255|in:male,female',
			'country' => 'max:255',
		];

		$this->validate($request, $rules);

		$author = Author::findOrFail($id);

		$author->fill($request->all());

		if ($author->isClean()) {
			return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$author->save();

		return $this->successResponse($author);
	}

	/**
	 * delete an existing author
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id) {
		$author = Author::findOrFail($id);

		$author->delete();

		return $this->successResponse($author);
	}

}
