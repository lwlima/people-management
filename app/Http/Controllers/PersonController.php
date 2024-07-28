<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagination = Person::query()
            ->select('id', 'name', 'preferred_name', 'cpf', 'father_name', 'mother_name', 'phone_number', 'email')
            ->with(['addresses' => function ($query) {
                $query->orderBy('type');
            }])
            ->when(Request::input('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('preferred_name', 'like', "%{$search}%")
                        ->orWhere('cpf', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Person/People', [
            'search' => Request::input('search') ?? '',
            'pagination' => $pagination,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        $person = Person::create($request->safe()->all());
        if (!$person)
            return response()->json(['message' => 'Erro ao registrar uma pessoa.']);

        return response()->json(['data' => $person, 'message', 'Pessoa registrada com sucesso.']);
    }
}
