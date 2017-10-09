<?php

namespace App\Http\Controllers;

use App\NewUser;
use App\Sellers_details_tabs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PostViewController extends Controller
{

    public function showList()
    {
        return view('users.postslist');
    }

    public function index()
    {
        $post=\DB::table('sellers_details_tabs')
            ->join('new_users','sellers_details_tabs.new_user_id','=','new_users.id')
            ->join('product_types', 'sellers_details_tabs.productType', '=', 'product_types.id')
            ->join('packagings', 'sellers_details_tabs.packaging', '=', 'packagings.id')
            ->select(
                \DB::raw(
                    "
                        sellers_details_tabs.id,
                        new_users.name as name,
                        new_users.surname as surname,
                        new_users.email as email,
                        new_users.idNumber as idNumber,
                        sellers_details_tabs.new_user_id,
                        sellers_details_tabs.productPicture,
                        sellers_details_tabs.location,
                        sellers_details_tabs.gps_lat,
                        sellers_details_tabs.gps_long,
                        product_types.name as productType,
                        product_types.id as productTypeId,
                        sellers_details_tabs.quantity,
                        sellers_details_tabs.costPerKg,
                        sellers_details_tabs.description,
                        sellers_details_tabs.country,
                        sellers_details_tabs.city,
                        packagings.name as packaging,
                        sellers_details_tabs.availableHours,
                        sellers_details_tabs.paymentMethods,
                        sellers_details_tabs.transactionRating,
                        sellers_details_tabs.created_at,
                        sellers_details_tabs.updated_at
                        "
                )
            )
            ->orderBy('created_at' ,'desc')	->get();
//       $post = Sellers_details_tabs::with('newuser')->with('Products')->with('Packaging')->get();

//
//      return view('users.postslist', compact('post'));
        return Datatables::of($post)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Sellers_details_tabs::with('newuser')->where('id', $id)->first();

//
        return view('users.postprofile', compact('data'));
//        return view('users.postprofile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

}
