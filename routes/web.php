<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController; //== require
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return 'we are in files';
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('auth');
Route::get('/posts/create/', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show')->middleware('auth');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('auth');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/github/callback', function () {
    try {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('social_id', $githubUser->id)->first();
        // dd($githubUser);
        if ($user) {
            $user->update([
                'social_token' => $githubUser->token,
                'social_refresh_token' => $githubUser->refreshToken,
            ]);
        } else {
            $user = User::create([
                'name' => $githubUser->nickname,
                'email' => $githubUser->email,
                'password' => encrypt('gitpwd059'),
                'social_id' => $githubUser->id,
                'social_token' => $githubUser->token,
                'social_refresh_token' => $githubUser->refreshToken,
            ]);
        }
        // dd($user);

        Auth::login($user);

        return redirect('/home');
    } catch (Exception $e) {
        return redirect()->route('login');
    }
});





Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get(
    '/auth/google/callback',
    function () {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);
            $user = User::where('social_id', $googleUser->id)->first();
            // dd($googleUser);
            if ($user) {
                $user->update([
                    'social_token' => $googleUser->token,
                    'social_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => encrypt('gitpwd059'),
                    'social_id' => $googleUser->id,
                    'social_token' => $googleUser->token,
                    'social_refresh_token' => $googleUser->refreshToken,
                ]);
            }
            // dd($user);

            Auth::login($user);

            return redirect('/home');
        } catch (Exception $e) {
            // return redirect()->route('login');
            dd($e->getMessage());
        }
    }
);
