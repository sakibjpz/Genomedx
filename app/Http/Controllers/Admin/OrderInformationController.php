<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderInformation;
use Illuminate\Http\Request;

class OrderInformationController extends Controller
{
    public function edit()
    {
        $orderInfo = OrderInformation::first();
        
        if (!$orderInfo) {
            $orderInfo = OrderInformation::create([]);
        }
        
        return view('admin.order-information.edit', compact('orderInfo'));
    }

    public function update(Request $request)
    {
        $orderInfo = OrderInformation::first();
        
        if (!$orderInfo) {
            $orderInfo = OrderInformation::create([]);
        }
        
        $request->validate([
            'sales_phone' => 'nullable|string|max:50',
            'sales_email' => 'nullable|email|max:100',
            'support_phone' => 'nullable|string|max:100',
            'support_hours' => 'nullable|string|max:100',
            'company_address' => 'nullable|string|max:500',
            'company_website' => 'nullable|url|max:200',
            'contact_button_text' => 'required|string|max:100',
            'contact_button_link' => 'required|string|max:200',
        ]);
        
        $orderInfo->update([
            'sales_phone' => $request->sales_phone,
            'sales_email' => $request->sales_email,
            'support_phone' => $request->support_phone,
            'support_hours' => $request->support_hours,
            'company_address' => $request->company_address,
            'company_website' => $request->company_website,
            'contact_button_text' => $request->contact_button_text,
            'contact_button_link' => $request->contact_button_link,
            'show_sales_section' => $request->has('show_sales_section'),
            'show_support_section' => $request->has('show_support_section'),
            'show_address_section' => $request->has('show_address_section'),
        ]);
        
        return redirect()->route('admin.order-information.edit')
                         ->with('success', 'Order information updated successfully.');
    }
}