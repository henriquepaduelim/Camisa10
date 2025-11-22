<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Coupon::latest()->paginate(50)]);
    }

    public function store(CouponRequest $request)
    {
        $cupom = Coupon::create($request->validated());
        return response()->json(['data' => $cupom], 201);
    }

    public function show(Coupon $cupom)
    {
        return response()->json(['data' => $cupom]);
    }

    public function update(CouponRequest $request, Coupon $cupom)
    {
        $cupom->update($request->validated());
        return response()->json(['data' => $cupom]);
    }

    public function destroy(Coupon $cupom)
    {
        $cupom->delete();
        return response()->json(status: 204);
    }
}
