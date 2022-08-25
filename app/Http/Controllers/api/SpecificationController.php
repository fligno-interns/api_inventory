<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Specification\StoreSpecRequest;
use App\Http\Requests\Specification\UpdateSpecRequest;
use App\Http\Resources\SpecificationResource;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Http\JsonResponse;

class SpecificationController extends BaseController
{
    public function __construct()
    {
        $this->middleware('permission:category_create', ['only' => ['store']]);
//        $this->middleware('permission:product-create', ['only' => ['create','store']]);
//        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $spec = Specification::all();

        return $this->sendResponse(SpecificationResource::collection($spec), 'Specification retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSpecRequest  $request
     * @return JsonResponse
     */
    public function store(StoreSpecRequest $request): JsonResponse
    {
        $input = $request->validated();
        $category = Category::query()->find($input['category_name']);
        if ($category) {
            foreach ($input['spec_name'] as $name) {
                $spec = Specification::query()->create([
                    'name' => $name,
                ]);
                $spec->category()->associate($category)->save();
            }

            return $this->sendResponse(new SpecificationResource($spec), 'Specification created successfully.');
        } else {
            return $this->sendError('Category not Found.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Specification  $spec
     * @return JsonResponse
     */
    public function show(Specification $spec): JsonResponse
    {
//        dd($spec->details);
        return $this->sendResponse(new SpecificationResource($spec), 'Specification retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSpecRequest  $request
     * @param  Specification  $spec
     * @return JsonResponse
     */
    public function update(UpdateSpecRequest $request, Specification $spec): JsonResponse
    {
        $input = $request->validated();
        $spec->name = $input['name'];

        return $this->sendResponse(new SpecificationResource($spec), 'Specification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Specification  $spec
     * @return JsonResponse
     */
    public function destroy(Specification $spec): JsonResponse
    {
        $spec->delete();

        return $this->sendResponse($spec, 'Specification deleted.');
    }
}
