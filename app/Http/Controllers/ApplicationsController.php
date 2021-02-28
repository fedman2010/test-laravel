<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Services\CreateApplicationService;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::getUser();
        $applications = [];

        if ($user->isManager()) {
            $applications = Application::all();
        } elseif ($user->isClient()) {
            $applications = Application::where(['user_id' => $user->id])->get();
        }

        return response()->view('application.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Application::class);

        $application = new Application();

        return response()->view('application.create', compact('application'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(StoreApplicationRequest $request)
    {
        $this->authorize('create', Application::class);

        $createApplicationService = new CreateApplicationService();
        $createApplicationService->handle($request->validated());

        return redirect('/applications');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $application = Application::findOrFail($id);

        $this->authorize('view', $application);

        return response()->view('application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
