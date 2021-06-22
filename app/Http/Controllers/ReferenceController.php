<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use PDOException;
use App\Models\Reference;

class ReferenceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'heading' => 'required|string|max:30',
            'message' => 'required|string|max:255',
        ],[
            'name.required' => "Поле 'Имя' обязательно для заполнения",
            'name.string' => "Имя может содержать буквы и цифры",
            'name.max' => "Слишком длинное имя",
            'heading.required' => "Поле 'Тема обращения' обязательно для заполнения",
            'heading.string' => "Тема обращения может содержать буквы и цифры",
            'heading.max' => "Слишком длинная тема обращения",
            'message.required' => "Поле 'Сообщение' обязательно для заполнения",
            'message.string' => "Сообщение может содержать буквы и цифры",
            'message.max' => "Слишком длинное сообщение",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Что-то пошло не так. Попробуйте позже.',
            ]);
        } else {
            try {
                Reference::create($request->all());
                return response()->json(['toastr_success' => 'Мы получили вашу заявку. Она будет обработана в ближайшее время.']);
            } catch (QueryException $exception) {
                // dd();
                return response()->json($exception);
            } catch (PDOException $exception) {
                return response()->json($exception);
            }
        }
    }
}
