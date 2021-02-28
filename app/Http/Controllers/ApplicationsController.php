<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Services\CreateApplicationService;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;

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

        if ($user->isManager()) {
            $applications = Application::all();
            return response()->view('application.index', compact('applications', 'user'));
        }

        if ($user->isClient()) {
            $applications = Application::where(['user_id' => $user->id])->get();
            return response()->view('application.index', compact('applications', 'user'));
        }
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
     * Update application.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function mark(Request $request, $id)
    {
        $this->authorize('mark', Application::class);

        $application = Application::findOrFail($id);
        $application->update(['responded_at' => Date::now()]);

        return redirect('/applications/' . $application->id);
    }
}
