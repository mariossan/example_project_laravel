<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Traits\ImageTrait;
use App\Models\{Profile,Notification,Campaign};
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Profile\StoreRequest;

class ProfileController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $user->load('profile.notifications','role');
        $notifications = Notification::all();

        return view('admin.profiles.index', compact('user','notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreRequest $request, User $user)
    {
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);

        if( $request->has('image') ){
            Storage::delete($profile->image->url);

            $image = $this->upload($request->file('image'),"images/profiles/{$user->id}");

            $profile->image->url = $image;

            if(!$profile->image){
                $profile->image->url = $image;
                $profile->image->imageable_id = $profile->id;
                $profile->image->imageable_type = Profile::class;
            }
        }

        $profile->push();

        if($request->has('notifications')) {
            $profile->notifications()->sync($request->input('notifications'));
        }

        return redirect()->back()->with('status', [
            'status' => 'success',
            'message' => 'Tu perfil se ha actualizado'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
