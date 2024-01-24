<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\AllItems;
use App\Models\Item;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //Usage of trait ApiResponse.
    use ApiResponse;
    /**
     *Function to return all items in json response.
     */
    public function index()
    {
        //Retrieve all items from database
        $items = Item::all();
        return $this->jsonResponse(200,'All items here',AllItems::collection($items));
    }
    /**
     * Function tp store new item.
     */
    public function store(AddItemRequest $request)
    {
        try {
            $item = Item::create($request->only([
                'description'
            ]));
            return $this->jsonResponse(201,'Item has been created',$item);
        }catch (\Exception $exception){
            return $this->jsonResponse(500,'Something went wrong');
        }
    }
    /**
     * Function to update the status of specific item.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->update($request->only([
                'status'
            ]));
            return $this->jsonResponse(201,'The item updated successfully',$item);
        }catch (\Exception $exception){
            return $this->jsonResponse(500,'Something went wrong',$exception->getMessage());
        }
    }

    /**
     * Function to delete specific item.
     */
    public function destroy(string $id)
    {
        try {
            $deleted = Item::destroy([$id]);
            if($deleted != 0)
            {
                return $this->jsonResponse(200,'The item has been deleted.');
            }
            else
            {
                return $this->jsonResponse(500,'Nothing has been deleted.');
            }
        }catch (\Exception $exception){
            return $this->jsonResponse(500,'Something went wrong.');
        }

    }
}
