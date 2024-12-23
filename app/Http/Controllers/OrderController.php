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
        // Hardcoded email and name for testing purposes
        $userName = 'Test User';
        $userEmail = 'test@example.com';

        $cartKey = "cart:" . $userEmail; // Use the hardcoded email for the cart key
        $cart = Redis::hGetAll($cartKey);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_name' => $userName,
                'customer_email' => $userEmail,
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
        $userId = 1;

        // Fetch orders for the test email
        $orders = Order::with('items.product')->where('user_id', $userId)->get();

        return response()->json($orders, 200);
    }
}
