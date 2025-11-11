<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrinksController extends Controller
{
    public function index(): Renderable
    {

        $subCats = DB::select("
        select id,m_cat_id, msc_name, msc_order from (
        SELECT *, (select count(*) from menus_items b where b.msc_id = a.id) as tIC
        FROM menus_sub_cat a
        )x order by  msc_name
        ");

        $allMenuItems = DB::select("
        SELECT mi.id, item_name, item_desc_one, item_desc_two, item_price_one, item_price_two, msc_name, cat_name
        FROM menus_items mi
        INNER JOIN menus_sub_cat msc on mi.msc_id = msc.id
        INNER JOIN menus_cat mc on msc.m_cat_id = mc.id
        where deleted_at is null
        ");

        return view('welcome',[
            'subCats' => $subCats,
            'allMenuItems' => $allMenuItems,
        ]);

    }

    public function filterMenuItems($sub_cat_id): Renderable
    {

        $subCats = DB::select("
        select id,m_cat_id, msc_name, msc_order from (
        SELECT *, (select count(*) from menus_items b where b.msc_id = a.id) as tIC
        FROM menus_sub_cat a
        )x order by  msc_name
        ");

        $allMenuItems = DB::select("
        SELECT mi.id, item_name, item_desc_one, item_desc_two, item_price_one, item_price_two, msc_name, cat_name
        FROM menus_items mi
        INNER JOIN menus_sub_cat msc on mi.msc_id = msc.id
        INNER JOIN menus_cat mc on msc.m_cat_id = mc.id
        WHERE msc.id = $sub_cat_id and deleted_at is null
        ");

        return view('welcome',[
            'subCats' => $subCats,
            'allMenuItems' => $allMenuItems,
        ]);
    }

    public function newDrink(Request $request): RedirectResponse
    {

        $drinkName = $request->input('drinkName');
        $drinkCat = $request->input('drinkCat');
        $descOne = $request->input('descOne');
        $descTwo = $request->input('descTwo');
        $priceOne = $request->input('priceOne');
        $priceTwo = $request->input('priceTwo');

        DB::table('menus_items')->insert([
            'msc_id' => $drinkCat,
            'item_name' => $drinkName,
            'item_desc_one' => $descOne,
            'item_desc_two' => $descTwo,
            'item_currency' => 'RWF',
            'item_price_one' => $priceOne,
            'item_price_two' => $priceTwo,
        ]);

        return redirect()->route('index');

    }


    public function updateDrink(Request $request): RedirectResponse
    {

        $drinkID = $request->input('drinkID');
        $drinkName = $request->input('drinkName');
        $descOne = $request->input('descOne');
        $descTwo = $request->input('descTwo');
        $priceOne = $request->input('priceOne');
        $priceTwo = $request->input('priceTwo');

        DB::table('menus_items')
            ->where('id', $drinkID)
            ->update([
            'item_name' => $drinkName,
            'item_desc_one' => $descOne,
            'item_desc_two' => $descTwo,
            'item_currency' => 'RWF',
            'item_price_one' => $priceOne,
            'item_price_two' => $priceTwo,
        ]);

        return redirect()->route('index');

    }

    public function deleteDrink(Request $request): RedirectResponse
    {
        $drinkID = $request->input('drinkID');
        $deleteReason = $request->input('deleteReason');

        DB::table('menus_items')
            ->where('id', $drinkID)
            ->update([
                'deleted_at' => now(),
                'deleted_reason' => $deleteReason,
            ]);

        return redirect()->route('index');

    }
}
