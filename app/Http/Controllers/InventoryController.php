<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agents;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CreateInventory;
use App\Notifications\DeleteInventory;
use App\Notifications\UpdateInventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'super-admin'){
        $inventories = Inventory::with('agent')->orderby('user_id','desc')->get();
        }else{
            $inventories = Inventory::with('agent')->where('user_id',Auth::user()->id)->get();
        }
        return view('Admin.Pages.Inventory',compact('inventories'));
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
     * @param  \App\Http\Requests\StoreInventoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

             $inventory = Inventory::create([
                'text' => $request['text'],
                'user_id' => Auth::user()->id,
            ]);
            if($inventory){
               $users = User::whereIn('user_type',['admin','super-admin'])->get();
                foreach($users as $user){
                 $user->notify(new CreateInventory($inventory));
                }
              return redirect()->route('inventory.index')->with('success','Agent Inventory created successfully');
            }else{
                return redirect()->route('inventory.index')->with('error','something wrong');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $inventory)
    {
        $inv = Inventory::where('id',$inventory)->update([
            'text' => $request['text'],
            'user_id' => Auth::user()->id,
        ]);
        if($inv){
            $users = User::whereIn('user_type',['admin','super-admin'])->get();
            foreach($users as $user){
             $user->notify(new UpdateInventory(Inventory::where('id',$inventory)->first()));
            }
            return redirect()->route('inventory.index')->with('success','Agent Inventory created successfully');
          }else{
              return redirect()->route('inventory.index')->with('error','something wrong');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy( $inventory)
    {
        $inv = Inventory::findOrFail($inventory);
        $invent = $inv;
        $del = $inv->forceDelete();
        if($del){
            $users = User::whereIn('user_type',['admin','super-admin'])->get();
            foreach($users as $user){
             $user->notify(new DeleteInventory($invent));
            }
            return redirect()->route('inventory.index')->with('success','Inventory deleted successfully');
    }else{
           return redirect()->route('inventory.index')->with('error','Error in deleting process ');
    }
    }
}
