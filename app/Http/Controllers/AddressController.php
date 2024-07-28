<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;

use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        // dd($request->commercial);
        $residentialAddressId = $request->residential['id'];
        $residentialAddressId = $request->commercial['id'];
        $residentialAddress = Address::find($residentialAddressId);
        $commercialAddress = Address::find($residentialAddressId);

        $residentialAddress
            ? $residentialAddress->update([
                'street' => $request->residential['street'],
                'number' => $request->residential['number'],
                'city' => $request->residential['city'],
                'state' => $request->residential['state'],
                'cep' => $request->residential['cep'],
            ])
            : Address::create([
                'person_id' => $request->person_id,
                'type' => 'residential',
                'street' => $request->residential['street'],
                'number' => $request->residential['number'],
                'city' => $request->residential['city'],
                'state' => $request->residential['state'],
                'cep' => $request->residential['cep'],
            ]);

        $commercialAddress
            ? $commercialAddress->update([
                'street' => $request->commercial['street'],
                'number' => $request->commercial['number'],
                'city' => $request->commercial['city'],
                'state' => $request->commercial['state'],
                'cep' => $request->commercial['cep'],
            ])
            : Address::create([
                'person_id' => $request->person_id,
                'type' => 'commercial',
                'street' => $request->commercial['street'],
                'number' => $request->commercial['number'],
                'city' => $request->commercial['city'],
                'state' => $request->commercial['state'],
                'cep' => $request->commercial['cep'],
            ]);

        return redirect()->back()->with('message', 'Endereço atualizado com sucesso.');
    }

    public function getAddressByCep(string $cep)
    {
        $data = Http::get("viacep.com.br/ws/$cep/json/")->json();
        return response()->json(['data' => $data]);
    }
}
