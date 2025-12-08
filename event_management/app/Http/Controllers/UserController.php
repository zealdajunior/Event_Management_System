* Display a listing of the resource.
     */
    public function index()
    {
        //
    }
=======
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::all();
        return view('users.index', compact('users'));
    }
