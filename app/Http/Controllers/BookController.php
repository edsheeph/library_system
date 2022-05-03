<?php

namespace App\Http\Controllers;

use Validator;
use Throwable;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $books = Book::select(
                'books.id',
                'books.book_accession_no',
                'books.book_title',
                'books.book_description',
                'books.book_author',
                'books.book_date_publish',
                'books.book_publisher',
                'books.book_category_id',
                'book_categories.book_category_description as book_category_desc',
                'books.book_dewey_decimal',
                'books.book_type_id',
                'book_types.book_type_description as book_type_desc'
            )
            ->join("book_categories", "book_categories.id", "books.book_category_id")
            ->join("book_types", "book_types.id", "books.book_type_id");
    
            if ($request->search) {
                $books = $books->where(function($q) use($request){
                    $q->orWhere("book_accession_no", "LIKE", "%".($request->search)."%");
                    $q->orWhere("book_title", "LIKE", "%".($request->search)."%");
                });
            }
    
            if ($request->book_category_id) {
                $books = $books->where("books.book_category_id", $request->book_category_id);
            }
    
            if ($request->book_type_id) {
                $books = $books->where("books.book_type_id", $request->book_type_id);
            }
    
            $books = $books->paginate(
                (int) $request->get('per_page', 10),
                ['*'],
                'page',
                (int) $request->get('page', 1)
            );
            
            return customResponse()
                ->message("Get records.")
                ->data($books)
                ->success()
                ->generate();
        } catch (\Throwable $th) {
            return customResponse()
                ->message('Oops! Something went wrong.')
                ->data(null)
                ->failed()
                ->generate();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_accession_no' => 'required',
                'book_title' => 'required',
                'book_description' => 'required',
                'book_author' => 'required',
                'book_date_publish' => 'required',
                'book_publisher' => 'required',
                'book_category_id' => 'required',
                'book_dewey_decimal' => 'required',
                'book_type_id' => 'required',
            ]);
    
            if ($validator->fails()) {
                return customResponse()
                    ->data(null)
                    ->message($validator->errors()->all()[0])
                    ->failed()
                    ->generate();
            }

            $checkExists = Book::where("book_accession_no", "LIKE", "%".($request->book_accession_no)."%")->exists();
            if ($checkExists) {
                return customResponse()
                    ->data(null)
                    ->message("Record is already exists, saving is not allowed.")
                    ->failed()
                    ->generate();
            }
    
            $book = new Book([
                'book_accession_no' => $request->book_accession_no,
                'book_title' => $request->book_title,
                'book_description' => $request->book_description,
                'book_author' => $request->book_author,
                'book_date_publish' => date("Y-m-d", strtotime($request->book_date_publish)),
                'book_publisher' => $request->book_publisher,
                'book_category_id' => $request->book_category_id,
                'book_dewey_decimal' => $request->book_dewey_decimal,
                'book_type_id' => $request->book_type_id,
            ]);
    
            $book->save();
    
            return customResponse()
                ->message('Record has been saved.')
                ->data($book)
                ->success()
                ->generate();
        } catch (\Throwable $th) {
            return customResponse()
                ->message('Oops! Something went wrong.')
                ->data(null)
                ->failed()
                ->generate();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book, $id)
    {
        try {
            $book = $book->find($id);

            if (empty($book)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            return customResponse()
                ->message('Record has been get.')
                ->data($book)
                ->success()
                ->generate();
        } catch (\Throwable $th) {
            return customResponse()
                ->message('Oops! Something went wrong.')
                ->data(null)
                ->failed()
                ->generate();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book, $id)
    {
        try {
            $book = $book->find($id);

            if (empty($book)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            return customResponse()
                ->message('Record has been get.')
                ->data($book)
                ->success()
                ->generate();
        } catch (\Throwable $th) {
            return customResponse()
                ->message('Oops! Something went wrong.')
                ->data(null)
                ->failed()
                ->generate();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_accession_no' => 'required',
                'book_title' => 'required',
                'book_description' => 'required',
                'book_author' => 'required',
                'book_date_publish' => 'required',
                'book_publisher' => 'required',
                'book_category_id' => 'required',
                'book_dewey_decimal' => 'required',
                'book_type_id' => 'required',
            ]);
    
            if ($validator->fails()) {
                return customResponse()
                    ->data(null)
                    ->message($validator->errors()->all()[0])
                    ->failed()
                    ->generate();
            }
    
            $book = $book->find($id);
    
            if (empty($book)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            $checkExists = Book::where("book_accession_no", "LIKE", "%".($request->book_accession_no)."%")
                ->where("id", "!=", $id)
                ->exists();
            if ($checkExists) {
                return customResponse()
                    ->data(null)
                    ->message("Record is already exists, updating is not allowed.")
                    ->failed()
                    ->generate();
            }
    
            $data = [
                'book_accession_no' => $request->book_accession_no,
                'book_title' => $request->book_title,
                'book_description' => $request->book_description,
                'book_author' => $request->book_author,
                'book_date_publish' => date("Y-m-d", strtotime($request->book_date_publish)),
                'book_publisher' => $request->book_publisher,
                'book_category_id' => $request->book_category_id,
                'book_dewey_decimal' => $request->book_dewey_decimal,
                'book_type_id' => $request->book_type_id,
            ];
    
            $book->update($data);
    
            return customResponse()
                ->message('Record has been updated.')
                ->data($book)
                ->success()
                ->generate();
        } catch (\Throwable $th) {
            return customResponse()
                ->message('Oops! Something went wrong.')
                ->data(null)
                ->failed()
                ->generate();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book, $id)
    {
        try {
            $book = $book->find($id);

            if (empty($book)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            $book->delete();

            return customResponse()
                ->message('Record has been deleted.')
                ->data(null)
                ->success()
                ->generate();
        } catch (\Throwable $th) {
            return customResponse()
                ->message('Oops! Something went wrong.')
                ->data(null)
                ->failed()
                ->generate();
        }
    }
}
