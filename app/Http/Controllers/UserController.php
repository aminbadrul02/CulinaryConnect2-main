<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userHimSelf = User::find(auth()->id());
        
        return view('profile', compact('userHimSelf'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        $userHimSelf = $user;
        return view('profile' , compact('userHimSelf'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        return view('edit_profile' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' =>"required",
            "email" =>"required"
        ]);
        // Step 1: Check if the user is updating their own profile
        if ($request->user()->id != $id) {
            return redirect()->back();
        }
        // Step 2: Check if the image file is submitted
        if ($request->hasFile('image')) {
            if(!$request->file('image')->isValid()){
                return 'not valid image';
            }

            // Generate a unique name for the file to prevent conflicts
            $new_image_name = uniqid().'-'.time().'.'.$request->image->extension();      
            // If the image was successfully stored, update the user's image_path
            $request->image->move(public_path('uploaded_img_profilePicture'),$new_image_name);
            $user = User::findOrFail($id);
            $user->image_path = $new_image_name;
            $user->save();

        }
    
        // Update the user's name and email
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function updateprofilePrivacy(Request $request, string $id){
        $request->validate([
            'old' =>"required",
            "new" =>"required"
        ]);
        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Check if the old password matches the current password
        if (!Hash::check($request->old, $user->password)) {
            return redirect()->back()->with('error', 'The old password is incorrect');
        }

        // Update the user's password with the new one
        $user->password = Hash::make($request->new);
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('successPassword', 'Password updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
