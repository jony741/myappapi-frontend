<?php

namespace App\Http\Controllers;
use App\Http\Resources\OrderCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    protected $rules = [
        'order' => [
            'status' => ['required', 'integer', 'min:0', 'max:5'],
        ],
    ];

    // /**
    //  * Create a new ServiceController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     * @throws  ApiException
     */
    public function index()
    {
        if (auth()->user()->provider) {
            return OrderCollection::collection(auth()->user()->provider->orders()
                ->with(['event', 'services', 'provider', 'provider.cateogry'])->get());
            // echo 'isProvider';
        } else {
            return response()->json([
                'message' => 'User is not Provider'
            ], 403);
            // throw new ApiException('User is not Provider', '403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return OrderResource
     * @throws ApiException
     */
    public function update(Request $request, $id)
    {
        // $status = $request->get('status');
        // echo 'status:'.$status;
        // $validator = $this->validator($request->all(), 'order');
        $validator = $this->validate($request, [
            'status' => ['required', 'integer', 'min:0', 'max:5'],
        ]);
        if (!$validator) {
            return response()->json([
                'message' => 'status is missing or wrong'
            ], 422);
            // throw new ApiException($validator->errors()->toArray(), 422);
        };
        if (auth()->user()->provider) {
            $order = auth()->user()->provider->orders()->find($id);
            if (!$order) {
                return response()->json([
                    'message' => 'Order not found'
                ], 404);
                // throw new ApiException('Order not found', 404);
            }
            $status = $request->get('status', 0);
            if ($order->toStatus($status)) {
                $order->status = $status;
                $order->save();
                return new OrderCollection($order);
            } else {
                return response()->json([
                    'message' => 'Order can\'t change status'
                ], 403);
                // throw new ApiException('Order can\'t change status', '403');
            }
        } else {
            return response()->json([
                'message' => 'User is not Provider'
            ], 403);
            // throw new ApiException('User is not Provider', '403');
        }
    }
}
