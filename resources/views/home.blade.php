@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                --}}
{{--            </div>--}}
{{--        </div>--}}

        <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#newItemModal">Create New Item</button>

        <div class="modal fade" id="newItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{route('newDrink')}}" method="post">
                        @csrf

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="drinkName" class="form-label">Drink Name</label>
                                <input type="text" class="form-control" id="drinkName" name="drinkName" required>
                            </div>

                            <div class="mb-3">
                                <label for="drinkCat" class="form-label">Drink Category</label>
                                <select class="form-select" aria-label="Drink Category" name="drinkCat" id="drinkCat">
                                    @foreach($subCats as $sC)
                                        <option value="{{$sC->id}}">{{$sC->msc_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descOne" class="form-label">Description 1</label>
                                <input type="text" class="form-control" id="descOne" name="descOne">
                            </div>

                            <div class="mb-3">
                                <label for="descTwo" class="form-label">Description 2</label>
                                <input type="text" class="form-control" id="descTwo" name="descTwo">
                            </div>

                            <div class="mb-3">
                                <label for="proLogicItemCode" class="form-label">ProLogic Item Code <span style="color: red">(PLEASE CONTACT COST CONTROLLER FOR CODE)</span></label>
                                <input type="text" class="form-control" id="proLogicItemCode" name="proLogicItemCode" required>
                            </div>

                            <div class="mb-3">
                                <label for="priceOne" class="form-label">Price Per Glass / Tot</label>
                                <input type="number" min="0" class="form-control" id="priceOne" name="priceOne" required>
                            </div>

                            <div class="mb-3">
                                <label for="priceTwo" class="form-label">Original Price Per Bottle</label>
                                <input type="number" min="0" class="form-control" id="priceTwo" name="priceTwo" required>
                            </div>

                            <div class="mb-3">
                                <label for="discPrice" class="form-label">Discounted Price Per Bottle <span style="color: red">(leave 0 if there is no discounted price)</span></label>
                                <input type="number" min="0" class="form-control" id="discPrice" name="discPrice" value="0" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        <br>
        <div class="card-body">
            <div class="container-fluid">

                <div class="container text-center">
                    <div class="p-3 m-0 border-0 bd-example">

                        <a class="btn btn-primary me-2 mb-2" href="{{route('index')}}" role="button">ALL</a>
                        @foreach($subCats as $sC)
                            <a class="btn btn-primary me-2 mb-2" href="{{route('filterMenuItems', ['sub_cat_id'=>$sC->id])}}" role="button">{{$sC->msc_name}}</a>
                        @endforeach

                    </div>
                </div>

                <br>
                <br>

                <div>

                    <table id="myTable" class="display">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>ProLogic Code</th>
                            <th>Category</th>
                            {{--                <th>Desc 1</th>--}}
                            {{--                <th>Desc 2</th>--}}
                            <th>Gls/Tot</th>
                            <th>Bottle</th>
                            <th>Discounted Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allMenuItems as $aMI)
                            <tr>
                                <td>{{$aMI->item_name}}</td>
                                <td>{{$aMI->pro_logic_item_code}}</td>
                                <td>{{$aMI->msc_name}}</td>
                                {{--                    <td>{{$aMI->item_desc_one}}</td>--}}
                                {{--                    <td>{{$aMI->item_desc_two}}</td>--}}
                                <td>{{number_format($aMI->item_price_one)}}</td>
                                <td>{{number_format($aMI->item_price_two)}}</td>
                                <td>{{number_format($aMI->disc_price)}}</td>

                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editItems-{{$aMI->id}}">Edit</button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteItem-{{$aMI->id}}">Delete</button>

{{--                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                            Action--}}
{{--                                        </button>--}}
{{--                                        <ul class="dropdown-menu">--}}
{{--                                            <li>--}}
{{--                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editItems-{{$aMI->id}}">Edit</button>--}}
{{--                                            </li>--}}
{{--                                            <li>--}}
{{--                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteItem-{{$aMI->id}}">Delete</button>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
                                    </div>
                                </td>


                            </tr>

                            <div class="modal fade" id="editItems-{{$aMI->id}}" tabindex="-1" aria-labelledby="editItems-{{$aMI->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Item - <strong>{{$aMI->id}} - {{$aMI->item_name}}</strong> </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="{{route('updateDrink')}}" method="post">
                                            @csrf

                                            <div class="modal-body">
                                                <input name="drinkID" value="{{$aMI->id}}" hidden>

                                                <div class="mb-3">
                                                    <label for="drinkName" class="form-label">Drink Name</label>
                                                    <input type="text" class="form-control" id="drinkName" name="drinkName" value="{{$aMI->item_name}}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="drinkCat" class="form-label">Drink Category</label>
                                                    <select class="form-select" aria-label="Drink Category" name="drinkCat" id="drinkCat">
                                                        <option>{{$aMI->msc_name}}</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="descOne" class="form-label">Description 1</label>
                                                    <input type="text" class="form-control" id="descOne" name="descOne" value="{{$aMI->item_desc_one}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="descTwo" class="form-label">Description 2</label>
                                                    <input type="text" class="form-control" id="descTwo" name="descTwo" value="{{$aMI->item_desc_two}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="proLogicItemCode" class="form-label">ProLogic Item Code <span style="color: red">(PLEASE CONTACT COST CONTROLLER FOR CODE)</span></label>
                                                    <input type="text" class="form-control" id="proLogicItemCode" name="proLogicItemCode" value="{{$aMI->pro_logic_item_code}}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="priceOne" class="form-label">Price Per Glass / Tot</label>
                                                    <input type="number" min="0" class="form-control" id="priceOne" name="priceOne" value="{{$aMI->item_price_one}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="priceTwo" class="form-label">Price Per Bottle</label>
                                                    <input type="number" min="0" class="form-control" id="priceTwo" name="priceTwo" value="{{$aMI->item_price_two}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="discPrice" class="form-label">Discounted Price Per Bottle <span style="color: red">(leave 0 if there is no discounted price)</span></label>
                                                    <input type="number" min="0" class="form-control" id="discPrice" name="discPrice" value="{{$aMI->disc_price}}">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteItem-{{$aMI->id}}" tabindex="-1" aria-labelledby="deleteItem-{{$aMI->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Are You Sure You Want To Delete Item - <strong>{{$aMI->id}} - {{$aMI->item_name}}</strong> </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="{{route('deleteDrink')}}" method="post">
                                            @csrf

                                            <div class="modal-body">

                                                <input name="drinkID" value="{{$aMI->id}}" hidden>

                                                <div class="mb-3">
                                                    <label for="deleteReason" class="form-label">Reason For Deleting</label>
                                                    <input type="text" class="form-control" id="deleteReason" name="deleteReason" required>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

    </div>
</div>
@endsection
