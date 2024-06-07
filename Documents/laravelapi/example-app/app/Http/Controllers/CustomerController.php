<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use App\Mail\WelcomeMail;
// use Illuminate\Support\Facades\Mail;



use Tymon\JWTAuth\Payload;


//namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Firebase\JWT\JWT;
use DateTime;


// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
// use App\Models\Userdetails;
//use Tymon\JWTAuth\Exceptions\JWTException;
// use App\Models\login_model;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


use App\Mail\UserEmail;

//use App\Mail\RegisterAgentdetailsMail;



//Controllers
use App\Http\Controllers\Controller;

// use App\Models\agentdetails_model;


//Resources
// use App\Http\Resources\AppResource;
// use App\Http\Resources\App\CustomerResource;

//Services
//use App\Services\App\CustomerService;
//Mail
//use App\Mail\OtpMail;
//use Illuminate\Auth\Events\PasswordReset;
//use App\Models\PasswordReset;



class CustomerController extends Controller
{
    //
    public function loginAuth(Request $request)
    {
        // echo "testing...";exit;
        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        if ($data) {
            $userId = $data->username;
            $password = $data->password;

            // $user = User::where('EMAIL_ADDRESS', $userId)->first(); // Retrieve the user instance

            $user = User::loginAuthcheckEmail($userId);

            // echo $user;exit;

            //echo ($user->PASSCODE);exit;
            if ($user) {
                if ($user->PASSCODE === $password) {

                    // $kunci = Config::get('jwt_key');
                    // $token['id'] = $user->id;
                    // $token['data'] = $user->username;

                    // $username = $user->EMAIL_ADDRESS;
                    // // print_r($username);exit;
                    // $Id = $user->CUST_ID;

                    //print_r($user->PASSCODE );exit;
                    // echo $user->PASSCODE;exit;


                    // print_r($user->CUST_ID);exit;
                    //  print_r($user->EMAIL_ADDRESS);exit;

                    // $credentials = $request->only('username', 'password');


                    //$token = JWTAuth::attempt($credentials);


                    // print_r($user->CUST_ID);
                    // exit;

                    // $credentials = $request->only('username', 'password');
                    // print_r($credentials);
                    // exit;

                    // // Encode the payload to generate the token
                    // $token = JWTAuth::encode($payload);

                    // print_r($token);
                    // exit;

                    //  $token = JWTAuth::attempt($user,['email' => $user->EMAIL_ADDRESS, 'id' => $user->CUST_ID]);

                    $token = JWTAuth::fromUser($user, ['email' => $user->EMAIL_ADDRESS, 'id' => $user->CUST_ID]);



                    $outputData["message"] = 'Login successfully';
                    $response["response_code"] = "200";
                    $response["response_status"] = "Success";
                    $response["response_message"] = $outputData;
                    $response['token'] = $token;

                    return response()->json($response);
                } else {
                    // Password didn't match, return failure response
                    $response["response_code"] = "2";
                    $response["response_message"] = "Failed";
                    return response()->json($response);
                }
            } else {
                // No user found with the provided email address, return failure response
                $response["response_code"] = "2";
                $response["response_message"] = 'Failed';
                return response()->json($response);
            }
        } else {
            // Handle case where data is null
            $response["response_code"] = "500";
            $response["response_message"] = "Data is null";
            return response()->json($response);
        }
    }


    public function forgotPassword(Request $request)
    {
        // echo "testing...";
        // exit;

        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        // print_r($data);exit;
        if ($data) {

            $username = $data->username;

            //   print_r($username);exit;

            //  $user = User::select('CUST_ID', 'EMAIL_ADDRESS')->where('EMAIL_ADDRESS', $username)->first();

            $user = User::getDataforgotpassword($username);

            //print($user);exit;

            //  echo $user;exit;

            if ($user) {

                $token = JWTAuth::fromUser($user);

                // DB::table('DEVELOPMENT.SYS_APPLICATION_USERS')->updateOrInsert(
                //     ['EMAIL_ADDRESS' => $user->EMAIL_ADDRESS], // Unique identifier
                //     ['token' => $token, 'created_at' => now()]
                // );

                $emailAddress = $user->EMAIL_ADDRESS;

                // User::updateOrInsert(
                //     ['EMAIL_ADDRESS' => $user->EMAIL_ADDRESS], // Unique identifier
                //     ['token' => $token, 'created_at' => now()]
                // );

                User::updateDataforgotpassword($emailAddress, $token);


                $userId = $user['CUST_ID'];

                // Mail::to($user['email'])->send(new WelcomeMail($userId));
                // return "Email sent successfully!";

                // print_r($userId);exit;

                //****** */ $resetPasswordUrl = route('register', ['userId' => md5($userId), 'token' => $token]);

                // print_r($resetPasswordUrl);exit;

                // print_r($resetPasswordUrl);
                // exit;

                //  $resetPasswordUrl = route('register', ['userId' => md5($userId), 'token' => $token]);

                $resetPasswordUrl = 'C:\wamp64\www\Laravel\laravelapi\example-app\resources\views\register.blade.php';
                //Mail::to($user->email)->send(new WelcomeMail($resetPasswordUrl, $userId, $token)); // Pass the reset password URL instead of userId

                //  Mail::to($user->EMAIL_ADDRESS)->send(new UserEmail($resetPasswordUrl, $userId, $token));

                Mail::to($user->EMAIL_ADDRESS)->send(new UserEmail($resetPasswordUrl, $userId, $token));

                return response()->json([
                    'response_code' => '200',
                    'response_message' => 'Password reset email sent successfully',
                    'response_data' => $user['EMAIL_ADDRESS']
                ]);
            } else {
                return response()->json([
                    'response_code' => '400',
                    'response_message' => 'Your email is not valid. Please check the email.'
                ]);
            }
        } else {
            return response()->json([
                'response_code' => '500',
                'response_message' => 'Data is null'
            ]);
        }
    }




    public function resetPassword(Request $request)
    {
        //echo "testing...";exit;
        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        if ($data) {
            // $userId = $request->userid;
            $token = $data->jwttoken;
            $newpassword = $data->password;

            //User::where('token', $token)->update(['PASSCODE' => $newpassword]);

            User::reset_Password($token, $newpassword);

            return response()->json([
                'response_code' => '200',
                'response_message' => 'Password Updated Successfully',
            ]);
        } else {
            return response()->json([
                'response_code' => '500',
                'response_message' => 'Data is null',
            ]);
        }
    }




    public function change_password(Request $request)
    {
        // $user = DB::table('DEVELOPMENT.SYS_APPLICATION_USERS')
        //     ->where('EMAIL_ADDRESS', $request->email)
        //     ->first();

        // echo "testing...";exit;
        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }


        if ($data) {

            $cust_id = $data->cus_id;
            $old_password = $data->old_password;
            $new_password = $data->new_password;

            // $user = DB::table('DEVELOPMENT.SYS_APPLICATION_USERS')
            //     ->where('CUST_ID', $userid)
            //     ->first();

            // $user = User::where('CUST_ID', $cust_id)->first();

            $user = User::change_password($cust_id);

            // echo $user;exit;

            if ($old_password !== $user->PASSCODE) {

                return response()->json([
                    'status' => '2',
                    'PO_ERROR_TYPE' => 'Error',
                    'PO_ERROR_DESC' => 'Your Old_Password is Wrong'
                ]);
            } else if ($new_password == $user->PASSCODE) {
                return response()->json([
                    'status' => '2',
                    'PO_ERROR_TYPE' => 'Error',
                    'PO_ERROR_DESC' => 'You Are Entering The Same Password As Before'
                ]);
            } else {

                // DB::table('DEVELOPMENT.SYS_APPLICATION_USERS')
                //     ->where('CUST_ID', $cust_id)
                //     ->update(['PASSCODE' => $new_password]);

                $user = User::update_password($cust_id, $new_password);

                return response()->json([
                    'status' => '1',
                    'PO_ERROR_TYPE' => 'EXCEPTION',
                    'PO_ERROR_DESC' => 'Your password changed successfully!'
                ]);
            }
        } else {
            return response()->json([
                'response_code' => '500',
                'response_message' => 'Data is null',
            ]);
        }
    }

    public function getData(Request $request)
    {
        // echo "testing...";
        // exit;

        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        // print_r($data);exit;

        if($data){
            $id = $data->id;
            $branch = $data->Branch;
            $branch2 = $branch->Branch2;

            
            print_r($branch2);exit;
        }
    }
}
