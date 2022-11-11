<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotebookStoreRequest;
use App\Http\Resources\NotebookResource;
use App\Models\Notebook;
use Illuminate\Http\Request;
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
     * @return array
     */
    public function store(Request $request): array
    {
        $errors = [];

        $phone = $request->get('phone');
        $fullName = $request->get('fio');
        $email = $request->get('email');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Не заполнено или не корректное поле email';
        }

        if (empty($phone)) {
            $errors[] = 'Не заполнено поле phone';
        }

        if (empty($fullName)) {
            $errors[] = 'Не заполнено поле fio';
        }

        if (empty($errors)) {
            $notebook = Notebook::create([
                'phone' => $phone,
                'email' => $email,
                'fio' => $fullName,
                'birthday' => $request->get('birthday'),
                'company' => $request->get('company'),
                'photo' => $request->get('photo'),
            ]);
        }

        return [
            'success' => empty($errors),
            'errors' => $errors,
            'notebook' => !empty($notebook) ? new NotebookResource($notebook) : null,
        ];
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
    public function update(Request $request, Notebook $notebook): NotebookResource
    {
        $validated = $request->validate([
            'fio' => 'max:200',
            'company' => 'max:200',
            'phone' => 'numeric',
            'email' => 'email',
            'birthday' => 'date',
            'photo' => 'max:350',
        ]);

        $notebook->update($validated);

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
