<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /**
     * Place an order.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function placeOrder()
    {
        $cartKey = "cart:" . auth()->id();
        $cart = Redis::hGetAll($cartKey);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_name' => auth()->user()->name,
                'customer_email' => auth()->user()->email,
            ]);

            foreach ($cart as $product) {
                $item = json_decode($product, true);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['quantity'] * 100, // Assume price is fixed for simplicity
                ]);
            }

            Redis::del($cartKey);

            DB::commit();

            return response()->json(['message' => 'Order placed successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order'], 500);
        }
    }

    /**
     * View orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewOrders()
    {
        $orders = Order::with('items.product')->where('customer_email', auth()->user()->email)->get();

        return response()->json($orders, 200);
    }
}
