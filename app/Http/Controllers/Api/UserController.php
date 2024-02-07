<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function getUser($config)
    {
        $where = (array_key_exists('where', $config)) ? $config['where'] : null;

        $search = DB::table('user');

        if ($where) {
            $search = $search->where($where);
        }
        $search->select(
            'user.id as id',
            'user.name as name',
            'user.username as username',
            'user.phone as phone',
            'user.email as email',
            'user.company as company',
            'user.street as street',
            'user.lat as lat',
            'user.lng as lng',

            'user.created_at as created_at',
            'user.updated_at as updated_at',
        );
        $search = $search->get();
        return $search;
    }

    public function search(Request $request)
    {
        $where = ($request->where) ? json_decode($request->where, true) : null;

        $arrayConfig = [
            'where' => $where,
        ];

        $users = $this->getUser($arrayConfig);

        return response()->json([
            'status' => true,
            'users' => $users,
            'where' => $where,
        ]);
    }

    public function delete(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validated->fails()) {
            // validation failed
            $error = $validated->errors()->first();

            return response()->json([
                'status' => false,
                'error' => $error,
            ]);
        }
        // validation passed
        $id = $request->id;
        $deletedUser = User::where('id', $id)->delete();

        return response()->json([
            'status' => true,
            'deletedUser' => $deletedUser,
            'id' => $id,
        ]);
    }

    public function goToUserPage()
    {

        $arrayConfig = [
            'where' => [],
            // 'where' => [['client.id', '=', $id]],
        ];
        $users = $this->getUser($arrayConfig);

        return view('welcome', ["users" => $users]);
    }

    public function getAndPushDataFromExternalDevice(Request $request)
    {
        $response = Http::get("https://jsonplaceholder.typicode.com/users");

        foreach ($response->json() as $key => $value) {

            $dataToSave = [
                'name' => $value['name'],
                'username' => $value['username'],
                'phone' => $value['phone'],
                'email' => $value['email'],
                'company' => $value['company']['name'],
                'street' => $value['address']['street'],
                'lat' => $value['address']['geo']['lat'],
                'lng' => $value['address']['geo']['lng'],
            ];

            try {
                $post = User::create($dataToSave);
            } catch (QueryException $e) {
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'status' => true,
        ]);
    }

    public function add(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|max:100',
            'phone' => 'required|max:100',
            'email' => 'required|max:100',
            'company' => 'required|max:100',
            'street' => 'required|max:100',
            'lat' => 'required|max:100',
            'lng' => 'required|max:100',
        ]);

        if ($validated->fails()) {
            // validation failed
            $error = $validated->errors()->first();

            return response()->json([
                'status' => false,
                'error' => $error,
            ]);
        }
        // validation passed
        $name = $request->name;
        $username = $request->username;
        $phone = $request->phone;
        $email = $request->email;
        $company = $request->company;
        $street = $request->street;
        $lat = $request->lat;
        $lng = $request->lng;

        $arrayConfig = [
            'where' => [['user.email', '=', $email]],
        ];
        $dataIfExits = $this->getUser($arrayConfig);

        $dataToSave = [
            'name' => $name,
            'username' => $username,
            'phone' => $phone,
            'email' => $email,
            'company' => $company,
            'street' => $street,
            'lat' => $lat,
            'lng' => $lng,
        ];

        $post = null;

        if (count($dataIfExits) == 1) {
            return response()->json([
                'status' => true,
                'error' => 'email ya se encuentra registrado',
            ]);
        } else {
            try {
                $post = User::create($dataToSave);
            } catch (QueryException $e) {
                return response()->json([
                    'status' => true,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'post' => $post,
        ]);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'username' => 'required|max:100',
            'phone' => 'required|max:100',
            'email' => 'required|max:100',
            'company' => 'required|max:100',
            'street' => 'required|max:100',
            'lat' => 'required|max:100',
            'lng' => 'required|max:100',
        ]);

        if ($validated->fails()) {
            // validation failed
            $error = $validated->errors()->first();

            return response()->json([
                'status' => false,
                'error' => $error,
            ]);
        }
        // validation passed
        $id = $request->id;
        $name = $request->name;
        $username = $request->username;
        $phone = $request->phone;
        $email = $request->email;
        $company = $request->company;
        $street = $request->street;
        $lat = $request->lat;
        $lng = $request->lng;

        $arrayConfigEmailSearch = [
            'where' => [['user.email', '=', $email]],
        ];

        $arrayConfig = [
            'where' => [['user.id', '=', $id]],
        ];
        $dataIfExits = $this->getUser($arrayConfig);
        $dataIfExitsEmail = $this->getUser($arrayConfigEmailSearch);

        $dataToUpdate = [
            'name' => $name,
            'username' => $username,
            'phone' => $phone,
            'email' => $email,
            'company' => $company,
            'street' => $street,
            'lat' => $lat,
            'lng' => $lng,
        ];

        $post = null;

        if (count($dataIfExits) == 1) {
            if (count($dataIfExitsEmail) && ($dataIfExits[0]->email !== $email)) {
                return response()->json([
                    'status' => false,
                    'email' =>  $email,
                    'error' => 'email ya está registrado',
                ]);
            }
            try {
                $post = User::where('id', $id)
                    ->update($dataToUpdate);
            } catch (QueryException $e) {
                return response()->json([
                    'status' => false,
                    'email' =>  $dataIfExits[0]->email,
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'error' => 'no se ha encontrado el usuario',
            ]);
        }

        return response()->json([
            'status' => true,
            'post' => $post,
        ]);
    }
}
