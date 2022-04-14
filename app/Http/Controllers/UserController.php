<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Media;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
//use Grimzy\LaravelMysqlSpatial\Doctrine\Point as DoctrinePoint;
//use GeoJson\Geometry\Point;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Arr;
use Faker\Generator;
use Illuminate\Container\Container;
use Image;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Illuminate\Support\Facades\Http;

//use Intervention\Image\ImageManagerStatic;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return User::all();
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $email_verified_at = $request->input('email_verified_at');
        $password = $request->input('password');
        $remember_token = $request->input('remember_token');


        try {

            $user = new User([
                "name" => $name,
                "email" => $email,
                "email_verified_at" => $email_verified_at,
                "password" => $password,
                "remember_token" => $remember_token,
            ]);

            if($user->save()) {
                return response()->json(['success' => 'success'], 200);
            }
            else {
                return response()->json(['error' => 'invalid'], 400);
            }
        }
        catch(QueryException $ex) {
            return response()->json(['error' => 'likely_duplicate'], 400);
        }
        catch(Exception $ex) {
            return response()->json(['error' => 'some error occured'], 500);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->name = $user->name . "-TEST";

        if($user->save()) {
            return response()->json(['success' => 'success'], 200);
        }
        else {
            return response()->json(['error' => 'invalid'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatepass(Request $request){
        $fields = $request->validate([
            'id' => 'required| string'
        ]);
        //$id = $request->input('id');
        $user = User::find($fields['id']); // (type one user id here xe:1 or 2)
        $user->update(['password'=>bcrypt('please')]);
        return "updated";
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'user_dp' => 'required|image:jpeg,png,jpg,gif,svg',
            'user_location' => 'string',
            'user_avatar' => 'integer',
            'active' => 'integer',
        ]);

        //Upload User_DP
        $uploadFolder = 'users_dp';
        $image = $request->file('user_dp');
        $randomname = Str::random(40).'.jpg';
        $image_uploaded_path = $image->storeAs('users_dp_mid', $randomname, 'public');
        $image_url = Storage::url($image_uploaded_path);

        $image2_uploaded_path = $image->storeAs('users_dp_small', $randomname, 'public');
        $image2_url = Storage::url($image2_uploaded_path);

        $mid_path = public_path().'\storage\users_dp_mid\\'.$randomname;
        $small_path = public_path().'\storage\users_dp_small\\'.$randomname;
        

        $responze = Http::post('http://127.0.0.1:5000/userdp_compress', [
            'mid_img' => $mid_path,
            'small_img' => $small_path,
        ]);

       
        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );


        $user_location = DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')");

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'email_verified_at' => now(),
            'password' => bcrypt($fields['password']),
            'username' => $fields['name'],
            'user_dp' => $image_url,
            'user_location' => $user_location,
            'user_avatar' => 1,
            'active' => 0,
        ]);
        $point = new Point(40.7484404, -73.9878441);	// (lat, lng)
        $point->toJson();
        $user->user_location = $point;
        $user->save();

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'image' => $uploadedImageResponse,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user) {
            return response([
                'message' => 'Wrong User'
            ], 401);
        }

        if(!Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong Password',
                'Password' => $fields['password'],
                'email' => $fields['email']

            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,

            'Password' => $fields['password'],
            'email' => $fields['email']
        ];

        return response($response, 201);
    }

     public function logout(Request $request) {
         auth()->user()->tokens()->delete();
        

         return [
             'message' => 'Logged out'
         ]; 
     }

    public function getMedia(Request $request) {
        $id = $request->input('id');
        $friend_id = 112;
        $party = User::find($id);
        $candidates = $party->medias; // Returns a Laravel Collection User.php
        
        $current_date_time = Carbon::now()->toIso8601String();
        //$merged = array_merge($candidates ,$current_date_time);
        //$ca = $candidates . $current_date_time;
        //$candidates->put('current', $current_date_time);
        //$candidates->push($current_date_time);
        foreach($candidates as $i){
            $i->current_time = $current_date_time;
        }
        return $candidates;
    }


    public function nearbyUsers(Request $request)
    {
       $lat = $request->input('lat');
       $lng = $request->input('lng');
       $range = 150;
       $km = $range/1000;

        $myData = DB::select(DB::raw("
                select id, username, user_dp, user_avatar, st_x(user_location) lat, st_y(user_location) lng 
                from `users` 
                where st_contains(st_makeEnvelope(point((:lat1 + :km1 / 111),(:lng1 + :km2 / 111)),
                                                  point((:lat2 - :km3 / 111),(:lng2 - :km4 / 111))), user_location)"),
                array('km1' => $km, 'km2' => $km, 'km3' => $km, 'km4' => $km, 'lat1' => $lat, 'lng1' => $lng, 'lat2' => $lat, 'lng2' => $lng,)
                );
        return $myData;
    }

   
    public function insertdata(Request $request)
    {
        if (($handle = fopen ( public_path () . '/FOF_dp_asc.csv', 'r' )) !== FALSE) {
            //$faker = Faker\Factory::create();
            set_time_limit(10800);
            $faker = Container::getInstance()->make(Generator::class);
            while ( ($data = fgetcsv ( $handle, 1000, ',' )) !== FALSE ) {
                $csv_data = new User ();
                $csv_data->id = $data [0];
                $csv_data->username = $data [1];
                $csv_data->name = $faker->name();
                $csv_data->email = $faker->unique()->safeEmail();
                $csv_data->email_verified_at = now();
                $csv_data->password = bcrypt("password");
                $csv_data->user_dp = $data [2];
                $csv_data->user_location = DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')");
                $csv_data->user_avatar = $faker->biasedNumberBetween(0,5);
                $csv_data->active = $faker->biasedNumberBetween(0,1);
                $csv_data->save ();
            }
            fclose ( $handle );
        }
        return "Done";
    }
}
