<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotebookStoreRequest;
use App\Http\Resources\NotebookResource;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\App;

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
        $photoPath = null;

        // TODO: смена локали через middleware
        $locale = $request->headers->get('Accept-Language') ?? 'ru';
        App::setLocale($locale);

        $phone = $request->get('phone');
        $fullName = $request->get('fio');
        $email = $request->get('email');

        $photo = $request->file('photo');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Не заполнено или не корректное поле email';
        } else {
            $existNotebookByEmail = Notebook::whereEmail($email)->first();

            if (!empty($existNotebookByEmail)) {
                $errors[] = __('validation.already_exist_notebook', ['attribute' => 'Email', 'value' => $email]);
            }
        }

        if (empty($phone)) {
            $errors[] = 'Не заполнено поле phone';
        } else {
            $existNotebookByPhone = Notebook::wherePhone($phone)->first();

            if (!empty($existNotebookByPhone)) {
                $errors[] = __('validation.already_exist_notebook', ['attribute' => 'Phone', 'value' => $phone]);
            }
        }

        if (empty($fullName)) {
            $errors[] = 'Не заполнено поле fio';
        }

        if (!empty($photo)) {
            $disk = $request->input('disk', 'public');
            $fileName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('photos', $fileName, ['disk' => $disk]);
        }

        if (empty($errors)) {
            $notebook = Notebook::create([
                'phone' => $phone,
                'email' => $email,
                'fio' => $fullName,
                'birthday' => $request->get('birthday'),
                'company' => $request->get('company'),
                'photo' => !empty($photoPath) ? url('/storage/'.$photoPath) : null,
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
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $errors = [];
        $notebook = Notebook::find($id);

        if (empty($notebook)) {
            $errors[] = 'Запись не найдена';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors,
            'notebook' => !empty($notebook) ? new NotebookResource($notebook) : null,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NotebookStoreRequest $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $errors = [];

        $notebook = Notebook::find($id);

        if (empty($notebook)) {
            $errors[] = 'Запись не найдена';
        }

        if (empty($errors)) {

            $validated = $request->validate([
                'fio' => 'max:200',
                'company' => 'max:200',
                'phone' => 'numeric',
                'email' => 'email',
                'birthday' => 'date',
                'photo' => 'max:350',
            ]);

            $notebook->update($validated);
        }

        return [
            'success' => empty($errors),
            'errors' => $errors,
            'notebook' => !empty($notebook) ? new NotebookResource($notebook) : null,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function destroy($id): array
    {
        $errors = [];

        $notebook = Notebook::find($id);

        if (!empty($notebook)) {
            $notebook->delete();
        } else {
            $errors[] = 'Запись не найдена';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors,
        ];
    }
}
