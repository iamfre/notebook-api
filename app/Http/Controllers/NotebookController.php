<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotebookStoreRequest;
use App\Http\Resources\NotebookResource;
use App\Models\Notebook;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return NotebookResource::collection(Notebook::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NotebookStoreRequest $request
     * @return NotebookResource
     */
    public function store(NotebookStoreRequest $request): NotebookResource
    {
        $notebook = Notebook::create($request->validated());

        return new NotebookResource($notebook);
    }

    /**
     * Display the specified resource.
     *
     * @param Notebook $notebook
     * @return NotebookResource
     */
    public function show(Notebook $notebook): NotebookResource
    {
        return new NotebookResource($notebook);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NotebookStoreRequest $request
     * @param Notebook $notebook
     * @return NotebookResource
     */
    public function update(NotebookStoreRequest $request, Notebook $notebook): NotebookResource
    {
        $notebook->update($request->validated());

        return new NotebookResource($notebook);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notebook $notebook
     * @return Response
     */
    public function destroy(Notebook $notebook): Response
    {
        $notebook->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
