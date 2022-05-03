<?php

namespace App\Http\Controllers;

use Validator;
use Throwable;
use App\Models\BookType;
use Illuminate\Http\Request;

class BookTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $bookTypes = BookType::select(
                'id',
                'book_type_description'
            );
    
            if ($request->search) {
                $bookTypes = $bookTypes->where(function($q) use($request){
                    $q->orWhere("book_type_description", "LIKE", "%".($request->search)."%");
                });
            }
    
            $bookTypes = $bookTypes->paginate(
                (int) $request->get('per_page', 10),
                ['*'],
                'page',
                (int) $request->get('page', 1)
            );
            
            return customResponse()
                ->message("Get records.")
                ->data($bookTypes)
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
                'book_type_description' => 'required'
            ]);
    
            if ($validator->fails()) {
                return customResponse()
                    ->data(null)
                    ->message($validator->errors()->all()[0])
                    ->failed()
                    ->generate();
            }

            $checkExists = BookType::where("book_type_description", "LIKE", "%".($request->book_type_description)."%")->exists();
            if ($checkExists) {
                return customResponse()
                    ->data(null)
                    ->message("Record is already exists, saving is not allowed.")
                    ->failed()
                    ->generate();
            }
    
            $bookType = new BookType([
                'book_type_description' => $request->book_type_description
            ]);
    
            $bookType->save();
    
            return customResponse()
                ->message('Record has been saved.')
                ->data($bookType)
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
     * @param  \App\Models\BookType  $bookType
     * @return \Illuminate\Http\Response
     */
    public function show(BookType $bookType, $id)
    {
        try {
            $bookType = $bookType->find($id);

            if (empty($bookType)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            return customResponse()
                ->message('Record has been get.')
                ->data($bookType)
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
     * @param  \App\Models\BookType  $bookType
     * @return \Illuminate\Http\Response
     */
    public function edit(BookType $bookType, $id)
    {
        try {
            $bookType = $bookType->find($id);

            if (empty($bookType)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            return customResponse()
                ->message('Record has been get.')
                ->data($bookType)
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
     * @param  \App\Models\BookType  $bookType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookType $bookType, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_type_description' => 'required'
            ]);
    
            if ($validator->fails()) {
                return customResponse()
                    ->data(null)
                    ->message($validator->errors()->all()[0])
                    ->failed()
                    ->generate();
            }
    
            $bookType = $bookType->find($id);
    
            if (empty($bookType)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            $checkExists = BookType::where("book_type_description", "LIKE", "%".($request->book_type_description)."%")
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
                'book_type_description' => $request->book_type_description
            ];
    
            $bookType->update($data);
    
            return customResponse()
                ->message('Record has been updated.')
                ->data($bookType)
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
     * @param  \App\Models\BookType  $bookType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookType $bookType, $id)
    {
        try {
            $bookType = $bookType->find($id);

            if (empty($bookType)) {
                return customResponse()
                    ->data(null)
                    ->message("Failed to get record.")
                    ->failed()
                    ->generate();
            }

            $bookType->delete();

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
