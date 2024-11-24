<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\BillingReceiptMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BillingController extends Controller
{
    public function view()
    {
        $products = Product::select('id', 'name', 'price')->get();
        return view('layout.billingIndex',compact('products'));
    }

    public function billing(Request $request)
    {
        Log::info($request->productId);
        $productIds = $request->productId;
        $products = Product::whereIn('id', $productIds)->get();
    
        $billDetails = [];
        $totalWithoutTax = 0;
        $totalTaxPayable = 0;

        foreach ($request->productId as $key => $productId) {
            $product = $products->firstWhere('id', $productId);
            $quantity = $request->quantity[$key];
            $unitPrice = $product->price;

            $purchasePrice = $unitPrice * $quantity;
            $taxRate = $product->tax_percentage;
            // return $taxRate;
            $taxPayable = ($purchasePrice * $taxRate) / 100;

            $totalWithoutTax += $purchasePrice;
            $totalTaxPayable += $taxPayable;

            $billDetails[] = [
                'product_id' => $productId,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'purchase_price' => $purchasePrice,
                'tax_rate' => $taxRate,
                'tax_payable' => $taxPayable,
                'total_price' => $purchasePrice + $taxPayable,
            ];
        }

        $netTotal = $totalWithoutTax + $totalTaxPayable;
        $roundedNetTotal = floor($netTotal); //round
        $balance = $request->cashPaid - $netTotal;
        $roundBalance = floor($balance); 

        $denominations = [500, 200, 100, 50, 20, 10, 5, 2, 1];
        $denominationBreakdown = [];
        $remainingBalance = $balance;

        foreach ($denominations as $denomination) {
            $count = intdiv($remainingBalance, $denomination); //find reminder
            if ($count > 0) {
                $denominationBreakdown[$denomination] = $count;
                $remainingBalance %= $denomination;
            }
        }

        $data = [
            'email' => $request->email,
            'billDetails' => $billDetails,
            'totalWithoutTax' => $totalWithoutTax,
            'totalTaxPayable' => $totalTaxPayable,
            'netTotal' => $netTotal,
            'roundedNetTotal' => $roundedNetTotal,
            'balance' => $roundBalance,
            'denominationBreakdown' => $denominationBreakdown,
        ];
    
        Log::info('Sending email to: ' . $data['email']);

        Mail::to($request->email)->send(new BillingReceiptMail($data));

        return view('layout.receipt', $data);
    }
}
