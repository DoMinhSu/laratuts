<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//The Basics
    //Rounting
    //Những route này cung cấp các tính năng liên quan về middleware group, session state and CSRF protection
    //RouteServiceProvider defined for route
Route::get('/hello', 'HelloController@index');

//match :xủ lý route cùng 1 url nhưng nhiều method khác nhau
//any : xử lý route cùng 1 url với bất kì method nào

//trong form/ajax-axios-fetch có method POST, PUT, PATCH, DELETE trong route/web phải có @csrf/csrf ~ <input type="hidden" name="_token" value="{{ csrf_token() }}">
//với put,patch,delete phải thêm cho form @method('PUT/PATCH/DELETE') ~ <input type="hidden" name="_method" value="PUT/PATCH/DELETE">


//Tự động redirect về / khi truy cập /abc và trả về statusCode:302
Route::redirect('/abc','/',302); 

//params in route
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    
});
//Optional Parameters
Route::get('user/{name?}', function ($name = 'John') {
    return $name;
});
//Regular Expression params
Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
//Global Regular Expression params
//RouteServiceProvider
// public function boot()
// {
//     Route::pattern('id', '[0-9]+');

//     parent::boot();
// }
//khi đó:
// Route::get('user/{id}', function ($id) {
//     // Only executed if {id} is numeric...
// });


//cho phép cài thiết lập đoạn text ở cuối route
//search/abc.html (search sẽ là: abc.html)
Route::get('search/{search}', function ($search) {
    return $search;
})->where('search', '.*');




//Named Routes :always unique
Route::get('abcd', function () {
    //
})->name('route_name');

// Generating URLs
// $url = route('route_name');

// Generating Redirects
// return redirect()->route('route_name');

//truyền tham số cho route:
// Route::get('user/{id}/profile', function ($id) {
//     //
// })->name('profile');

// tạo url cho view or controller... là:  route('profile', ['id' => 1]);
//url::default :giá trị mặc định cho một tham số khi tạo route bằng url

// Inspecting The Current Route : kiểm tra route hiện tại trong middleware
// public function handle($request, Closure $next)
// {
//     if ($request->route()->named('profile')) {
//         //
//     }

//     return $next($request);
// }

//Route Groups :share route middleware ,prefix,name, namespaces(cho controller) cho tất cả route trong nó và sẽ merge các điều kiện tham số khi dùng where

//middleware
// Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//         // Uses first & second Middleware
//     });

//     Route::get('user/profile', function () {
//         // Uses first & second Middleware
//     });
// });
//Namespace:
// Route::namespace('Admin')->group(function () {
//     // Controllers Within The "App\Http\Controllers\Admin" Namespace   (trong RouteServiceProvider)
// });

//prefix
// Route::prefix('admin')->group(function () {
//     Route::get('users', function () {
//         // Matches The "/admin/users" URL
//     });
// });

//name
// Route::name('admin.')->group(function () {
//     Route::get('users', function () {
//         // Route assigned name "admin.users"...
//     })->name('users');
// });





// Subdomain Routing: phải config thêm vhost c:\WINDOWS\system32\drivers\etc\
// Route::domain('abc.laratuts.test')->group(function () {
//     Route::get('register/{id}', function ($id) {
//         return $id;
//     });
// });



//Route Model Binding : cho function ở route/method in controller,gồm 3 loại: 
//nếu ko tìm thấy sẽ trả về 404 HTTP
    //Implicit Binding:ràng buộc ngầm 
    // ví dụ như khi route có param user(đây là id) có thể inject trực tiếp vào param dạng : User user (user này tự động tìm theo id)
    // Route::get('api/users/{user}', function (App\User $user) {
    //     return $user->email;
    // });
    //Customizing The Key :Sử dụng cột khác id để binding
    // Route::get('api/posts/{post:slug}', function (App\Post $post) {
    //     return $post;
    // });
    //Customizing The Key & Scoping : ngầm định nhiều mô hình Eloquent trong một url duy nhất, mô hình Eloquent thứ hai là con của mô hình Eloquent đầu tiên
    // Route::get('api/users/{user}/posts/{post:slug}', function (User $user, Post $post) {
    //     return $post;//user hasMany post, trong model user sẽ có method: posts(ứng với url) 
    // });

    //Customizing The Default Key Name:tùy chỉnh key name khi ràng buộc ngầm trong model:
    // public function getRouteKeyName()
    //     {
    //         return 'slug';
    //     }




    //Explicit Binding:Ràng buộc rõ ràng(nên dùng): trong RouteServiceProvider
    // public function boot()
    // {
    //     parent::boot();

    //     Route::model('user', App\User::class);
    // }
    // => Route::get('profile/{user}', function (App\User $user) {
    // profile/1 sẽ là user có id là 1
    // });


    
    //Customizing The Resolution Logic: tự đọc docs


//Route::fallback:ko có route nào matching có thể thay cho 404 mặc định của laravel và cũng có thể đi kèm với middleware, luôn đặt ở cuối
// Route::fallback(function () {
//     //
// });


// Rate Limiting : Middleware giới hạn số lần truy cập mỗi phút:
    //60 lần mỗi phút
    // Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    //     Route::get('/user', function () {
    //         //
    //     });
    // });

    // Dynamic Rate Limiting: giới hạn truy cập động bằng tên 1 column của user đã authentication
    // ví dụ column ở đây là rate_limit 
    // Route::middleware('auth:api', 'throttle:rate_limit,1')->group(function () {
    //     Route::get('/user', function () {
    //         //
    //     });
    // });

    // Distinct Guest & Authenticated User Rate Limits: giới hạn cho người dùng guess và user đã authentication
    // 10 req cho guess và 60 cho authentication
    // Route::middleware('throttle:10|60,1')->group(function () {
    //     //
    // });

    //10 req for guess và rate_limit column for user in 1 minute
    // Route::middleware('auth:api', 'throttle:10|rate_limit,1')->group(function () {
    //     Route::get('/user', function () {
    //         //
    //     });
    // });

    //thiết lập giới hạn truy cập cho từng loại route:
    // Route::middleware('auth:api')->group(function () {
    //     Route::middleware('throttle:60,1,default')->group(function () {
    //         Route::get('/servers', function () {
    //             //
    //         });
    //     });
    
    //     Route::middleware('throttle:60,1,deletes')->group(function () {
    //         Route::delete('/servers/{id}', function () {
    //             //
    //         });
    //     });
    // });




// Accessing The Current Route: Route trait và Router trait


// Cross-Origin Resource Sharing (CORS) nằm trong config/cors và các yêu cầu tùy chọn sẽ xử lý trong HandleCors middleware
//đọc thêm cors:  https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS#The_HTTP_response_headers