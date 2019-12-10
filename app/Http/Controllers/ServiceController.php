<?php

namespace App\Http\Controllers;

use App\Helper\WaitingApprovalHelper;
use App\Mail\EmailNotificationToAdmin;
use App\Service;
use App\ServiceImage;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ServiceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceController extends Controller
{
    protected $rules = [
        'service' => [
            'title' => ['required', 'string', 'min:6', 'max:254'],
            'description' => ['required', 'string', 'min:6', 'max:254'],
        ],
    ];

    /**
     * Create a new ServiceController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ServiceCollection::collection(auth()->user()->provider->services()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ServiceResource
     * @throws ApiException
     */
    public function store(Request $request)
    {
        // echo 'test';

        $validator = Validator::make($request->all(),[
            'title' => ['required', 'string', 'min:6', 'max:254'],
            'description' => ['required', 'string', 'min:6', 'max:254'],
            ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
            // throw new ApiException($validator->errors()->toArray(), 422);
        }

        if(auth()->user()->provider == NULL){
            return response()->json(['message' => 'Please add provider information first, then try with service'], 400);
        }

        $service = new Service([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'provider_id'=> auth()->user()->provider->id
        ]);

        if ($request->get('image')) {
            $service->image = $service->saveImage($request->get('image'), 'service');
        }

        // data inserting into confirmation Table
        if(WaitingApprovalHelper::forResourceCreate(auth()->user(),$service)){

            // Need to introduce Email Trigger
            $emailContent=[
                'subject'=> 'Service Create Request',
                'greeting'=> 'Hello',
                'body'=> "A New service Created,and it's waiting for your confirmation, please check in waiting approval list and take necessary action."
            ];

          Mail::to(env('ADMIN_EMAIL'))->send(new EmailNotificationToAdmin($emailContent));

            return response()->json(['message' => 'ok'], 200);
        }
        return response()->json(['message' => 'something went wrong!'], 404);



    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return ServiceResource
     * @throws ApiException
     */
    public function update(Request $request, $id)
    {
        // $validator = $this->validator($request->all(), 'service');
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'string', 'min:6', 'max:254'],
            'description' => ['required', 'string', 'min:6', 'max:254'],
            ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
            // throw new ApiException($validator->errors()->toArray(), 422);
        };
        $service = auth()->user()->provider->services()->find($id);

        if (!$service) {
            return response()->json([
                'message' => 'User service not found'
            ], 404);
            // throw new ApiException('User service not found', 404);
        }

        if(auth()->user()->provider == NULL){
            return response()->json(['message' => 'Please add provider information first, then try with service'], 400);
        }

        $service2 = new Service([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            //'provider_id'=> auth()->user()->provider->id
        ]);

        // Checking images changed?
        if ($request->get('image')) {
            $service2->image = $service2->saveImage($request->get('image'), 'service');
        }

        // data updating into confirmation Table
        if(WaitingApprovalHelper::forResourceUpdate(auth()->user(),$service,$service2)){

            // Need to introduce Email Trigger
            $emailContent=[
                'subject'=> 'Service Update Request',
                'greeting'=> 'Hello',
                'body'=> "A Service updated,and it's waiting for your confirmation, please check in waiting approval list and take necessary action."
            ];

            Mail::to(env('ADMIN_EMAIL'))->send(new EmailNotificationToAdmin($emailContent));

            return response()->json(['message' => 'ok'], 200);
        }

        return response()->json(['message' => 'something went wrong!'], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws ApiException
     */
    public function destroy($id)
    {
        $service = auth()->user()->provider->services()->find($id);
        if (!$service) {
            return response()->json([
                'message' => 'User service not found'
            ], 404);
            // throw new ApiException('User service not found', 404);
        }
        $service->delete();
        return response()->json(['message' => 'ok'], 200);
    }
}
