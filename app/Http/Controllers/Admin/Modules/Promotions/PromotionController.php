<?php

namespace App\Http\Controllers\Admin\Modules\Promotions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    // ============================
    // LIST + FILTER + EDIT LOAD
    // ============================
    public function index(Request $request)
    {
        $query = Promotion::query();

        // ---- SEARCH BY PROMO CODE ----
        if ($request->search) {
            $query->where('discount_code', 'LIKE', '%' . $request->search . '%');
        }

        // ---- STATUS FILTER ----
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // ---- FROM DATE FILTER ----
        if ($request->from_date) {
            $query->where('start_date', '>=', $request->from_date);
        }

        // ---- TO DATE FILTER ----
        if ($request->to_date) {
            $query->where('end_date', '<=', $request->to_date);
        }

        // ---- GET PROMOTIONS WITH PAGINATION ----
        $promotions = $query->orderBy('id', 'DESC')->paginate(10);

        // ---- LOAD RECORD FOR EDIT MODE ----
        $promotion = null;
        if ($request->has('edit')) {
            $promotion = Promotion::find($request->edit);
        }

        return view('admin.modules.promotions.index', compact('promotions', 'promotion'));
    }

    // ============================
    // STORE NEW PROMOTION
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string|min:3|max:15|unique:promotions,discount_code',
            'discount' => 'required|numeric|between:0,100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'promotion_hd' => 'required|string|max:255',
            'promotion_sub_hd' => 'nullable|string|max:255',
        ]);

        Promotion::create([
            'discount_code' => $request->discount_code,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'promotion_hd' => $request->promotion_hd,
            'promotion_sub_hd' => $request->promotion_sub_hd,
            'status' => 1, // default active
        ]);

        return redirect()->route('promotion.index')->with('success', 'Promotion created successfully.');
    }

    // ============================
    // UPDATE PROMOTION
    // ============================
    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'discount_code' => 'required|string|min:3|max:15|unique:promotions,discount_code,' . $promotion->id,
            'discount' => 'required|numeric|between:0,100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'promotion_hd' => 'required|string|max:255',
            'promotion_sub_hd' => 'nullable|string|max:255',
        ]);

        $promotion->update([
            'discount_code' => $request->discount_code,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'promotion_hd' => $request->promotion_hd,
            'promotion_sub_hd' => $request->promotion_sub_hd,
        ]);

        return redirect()->route('promotion.index')->with('success', 'Promotion updated successfully.');
    }

    // ============================
    // ACTIVATE / DEACTIVATE
    // ============================
    public function changeStatus($id)
    {
        $promotion = Promotion::findOrFail($id);

        $promotion->status = $promotion->status ? 0 : 1;
        $promotion->save();

        return redirect()->route('promotion.index')->with('success', 'Promotion status updated.');
    }
}
