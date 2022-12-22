<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\{CreateUserRequest,EditUserRequest};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Factories\{WorkshopFactory,RolFactory,UserFactory};
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;


class UserController extends Controller
{
    public function __construct(
        private RolFactory $rolF,
        private WorkshopFactory $workshopF,
        private UserFactory $userF
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('User/Index',[
            'users' => $this->userF->getUsersWithRelationShip()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return Inertia::render('User/Create',[
            'roles' => $this->rolF->getRoles(),
            'workshops' => $this->workshopF->getWorkshops()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
         $user = $this->userF->createUser($request->validated());

         return Redirect::route('users.index')->with('success', 'Usuario agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('User/Edit',[
            'user' => $this->userF->findUserWithId($id),
            'roles' => $this->rolF->getRoles(),
            'workshops' => $this->workshopF->getWorkshops()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $user)
    {
         $this->userF->updateUser($request->validated(),$user);

        return Redirect::route('users.index')->with('success', 'Usuario modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->vehiculo->count() >= 1){
            return Redirect::route('users.index')->with('error', 'No se puede eliminar este usuario por que ha registrado vehiculos.');
        }
        $user->delete();
        return Redirect::route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
