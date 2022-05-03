<?php

namespace App\Http\Controllers;

use Validator;
use Throwable;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $bookCategories = BookCategory::select(
                'id',
                'book_category_description',
                'book_category_dewey_decimal'
            );
    
            if ($request->search) {
                $bookCategories = $bookCategories->where(function($q) use($request){
                    $q->orWhere("book_category_description", "LIKE", "%".($request->search)."%");
                });
            }
    
            $bookCategories = $bookCategories->paginate(
                (int) $request->get('per_page', 10),
                ['*'],
                'page',
                (int) $request->get('page', 1)
            );
            
            return customResponse()
                ->message("Get records.")
                ->data($bookCategories)
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
                'book_category_description' => 'required',
                'book_category_dewey_decimal' => 'required'
            ]);
    
            if ($validator->fails()) {
                return customResponse()
                    ->data(null)
                    ->message($validator->errors()->all()[0])
                    ->failed()
                    ->generate();
            }

            $checkExists = BookCategory::where("book_category_description", "LIKE", "%".($request->book_category_description)."%")->exists();
            if ($checkExists) {
                return customResponse()
                    ->data(null)
                    ->message("Record is already exists, saving is not allowed.")
                    ->failed()
                    ->generate();
            }
    
            $bookCategory = new BookCategory([
                'book_category_description' => $request->book_category_description,
                'book_category_dewey_decimal' => $request->book_category_dewey_decimal
            ]);
    
            $bookCategory->save();
    
            return customResponse()
                ->message('Record has been saved.')
                ->data($bookCategory)
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
     * @param  \App\Models\BookCategory  $bookCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BookCategory $bookCategory, $id)
    {
        try {
            $bookCategory = $bookCategory->find($id);

            if (empty($bookCategory)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            return customResponse()
                ->message('Record has been get.')
                ->data($bookCategory)
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
     * @param  \App\Models\BookCategory  $bookCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BookCategory $bookCategory, $id)
    {
        try {
            $bookCategory = $bookCategory->find($id);

            if (empty($bookCategory)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            return customResponse()
                ->message('Record has been get.')
                ->data($bookCategory)
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
     * @param  \App\Models\BookCategory  $bookCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookCategory $bookCategory, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_category_description' => 'required',
                'book_category_dewey_decimal' => 'required'
            ]);
    
            if ($validator->fails()) {
                return customResponse()
                    ->data(null)
                    ->message($validator->errors()->all()[0])
                    ->failed()
                    ->generate();
            }
    
            $bookCategory = $bookCategory->find($id);
    
            if (empty($bookCategory)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            $checkExists = BookCategory::where("book_category_description", "LIKE", "%".($request->book_category_description)."%")
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
                'book_category_description' => $request->book_category_description,
                'book_category_dewey_decimal' => $request->book_category_dewey_decimal
            ];
    
            $bookCategory->update($data);
    
            return customResponse()
                ->message('Record has been updated.')
                ->data($bookCategory)
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
     * @param  \App\Models\BookCategory  $bookCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookCategory $bookCategory, $id)
    {
        try {
            $bookCategory = $bookCategory->find($id);

            if (empty($bookCategory)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            $bookCategory->delete();

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
