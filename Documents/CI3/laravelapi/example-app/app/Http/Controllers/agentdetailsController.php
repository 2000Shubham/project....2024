<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\agentdetails_model;
use App\Mail\RegisterAgentdetailsMail;
// use Illuminate\Support\Facades\Mail;
use PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Mail\AgentEmail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class agentdetailsController extends Controller
{
    //
    public function saveAgentDetails(Request $request)
    {
        // echo "testing...";exit;
        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        // print_r($data);exit;

        if ($data) {
            $First_name = $data->first_name;
            $Last_name = $data->last_name;
            $Display_name = $data->display_name;
            $Agent_code = $data->agent_code;
            $Email_address = $data->email;
            $Mobile_number = $data->mobile_number;
            $Agent_type = $data->agent_type;
            $Profession = $data->profession;
            $Company_name = $data->company_name;
            $Emiratesid_no = $data->emiratesid_no;
            $Nationality = $data->nationality;
            $Emiratesid_Expiry = $data->emiratesid_expiry;
            $Communication_address = $data->communication_address;
            $PO_Box_Number = $data->po_box_number;
            $City = $data->city;
            $Refered_code = $data->refered_code;
            $Terms_conditions = $data->terms_conditions;

            // echo "testing...";exit;
            // $valUser = DB::table('agentdetails')
            //     ->where('email', $Email_address)
            //     ->orWhere('mobile_number', $Mobile_number)
            //     ->count();

            // $valUser = agentdetails_model::where('email', $Email_address)
            //     ->orWhere('mobile_number', $Mobile_number)
            //     ->count();

            $valUser = agentdetails_model::checkIfExists($Email_address, $Mobile_number);

            // print_r($valUser);exit;
            // $this->agentdetails_model->get_agentdetails($Email_address, $Mobile_number);



            if ($valUser < 1) {

                //  $email_template = '<div><h1>Data Registered</h1><p>Hello,</p><p>Your data has been successfully registered.</p><p>Thank you!</p></div>';
                $email_template = '<div><h1>Data Registered</h1><p>Hello,</p><p>Your data has been successfully registered.</p><p>Thank you!</p></div>';

                $agentdata = [
                    'first_name' => $First_name,
                    'last_name' => $Last_name,
                    'display_name' => $Display_name,
                    'agent_code' => $Agent_code,
                    'email' => $Email_address,
                    'mobile_number' => $Mobile_number,
                    'agent_type' => $Agent_type,
                    'profession' => $Profession,
                    'company_name' => $Company_name,
                    'emiratesid_no' => $Emiratesid_no,
                    'nationality' => $Nationality,
                    'emiratesid_expiry' => $Emiratesid_Expiry,
                    'communication_address' => $Communication_address,
                    'po_box_number' => $PO_Box_Number,
                    'city' => $City,
                    'refered_code' => $Refered_code,
                    'terms_conditions' => $Terms_conditions,
                    'email_template' => $email_template
                ];

                // echo "testing...";exit;

                // $result = DB::table('agentdetails')->insert($agentdata);

                $result = agentdetails_model::insertAgentData($agentdata);

                // Call registerMail method if it exists in your class
                // $this->registerMail($registerdata);

                // Mail::to($Email_address)->send(new RegisterAgentdetailsMail($email_template));

                // print_r($Email_address);exit;


                //  Mail::to($Email_address)->send(new WelcomeMail($email_template));

                Mail::to($Email_address)->send(new AgentEmail($email_template));
                // Mail::to($Email_address)->send(new RegisterEmail($email_template));

                // Mail::to($Email_address)->send(new WelcomeMail($email_template));


                // print_r($Email_address);
                // exit;

                if ($result) {
                    return response()->json([
                        'status' => true,
                        'res_code' => 1,
                        'res_status' => 'Success',
                        'res_Message' => 'Your Data is Registered'
                    ]);
                }
            } else {

                // $resultsEmail = DB::table('agentdetails')
                //     ->where('email', $Email_address)
                //     ->count();


                $resultsEmail = agentdetails_model::checkEmail($Email_address);

                // print_r($resultsEmail);exit;

                if ($resultsEmail == 1) {
                    return response()->json([
                        'status' => false,
                        'res_code' => 2,
                        'res_status' => 'Your Email already Registered'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'res_code' => 2,
                        'res_status' => 'Your Mobile No. already Registered'
                    ]);
                }
                // return response()->json([
                //     'status' => false,
                //     'res_code' => 2,
                //     'res_status' => 'Your Data already Registered'
                // ]);
            }
        } else {
            return response()->json([
                'response_code' => 500,
                'response_message' => 'Data is null'
            ]);
        }
    }

    // -----------------------------------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required',
            'display_name' => 'required',
            'agent_code' => 'required',
            'email' => 'required',
            'mobile_number' => 'required',
            'agent_type' => 'required',
            'profession' => 'required',
            'company_name' => 'required',
            'emiratesid_no' => 'required',
            'nationality' => 'required',
            'emiratesid_expiry' => 'required',
            'communication_address' => 'required',
            'po_box_number' => 'required',
            'city' => 'required',
        ]);

        $newComment = new agentdetails_model([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'display_name' => $request->get('display_name'),
            'agent_code' => $request->get('agent_code'),
            'email' => $request->get('email'),
            'mobile_number' => $request->get('mobile_number'),
            'agent_type' => $request->get('agent_type'),
            'profession' => $request->get('profession'),
            'company_name' => $request->get('company_name'),
            'emiratesid_no' => $request->get('emiratesid_no'),
            'nationality' => $request->get('nationality'),
            'emiratesid_expiry' => $request->get('emiratesid_expiry'),
            'communication_address' => $request->get('communication_address'),
            'po_box_number' => $request->get('po_box_number'),
            'city' => $request->get('city'),
        ]);

        //   Mail::to($request->get('email'))->send(new AgentEmail($email_template));

        $newComment->save();

        return response()->json($newComment);
    }

    // --------------------------------------------------------------------------

    public function checkEmail(Request $request)
    {
        //echo "testing...";exit;

        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }
        // print_r($data);exit;

        if ($data) {

            $email = $data->email;

            // $result = DB::table('agentdetails')
            //     ->where('email', $email)
            //     ->count();

            $result = agentdetails_model::checkEmailaddress($email);

            // print_r($results);exit;

            // echo $result;

            if ($result == 0) {
                return response()->json([
                    'status' => true,
                    'res_code' => 1,
                    'res_status' => 'Success',
                    //'res_Message' => 'Your Data is Registered'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'res_code' => 2,
                    'res_status' => 'Failed',
                    'res_status' => 'Your Email already registered'
                ]);
            }
        } else {
            return response()->json([
                'response_code' => 500,
                'response_message' => 'Data is null'
            ]);

            // print_r($Mobile_number);exit;

        }
    }



    public function checkMobileno(Request $request)
    {
        // echo "testing...";exit;
        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        // print_r($data);exit;

        if ($data) {

            $Mobile_number = $data->mobile_number;

            // $result = DB::table('agentdetails')
            //     ->where('mobile_number', $Mobile_number)
            //     ->count();

            $result = agentdetails_model::checkMobileno($Mobile_number);

            // print_r($result);
            // exit;


            // print_r($results);exit;

            // echo $result;

            if ($result == 0) {
                return response()->json([
                    'status' => true,
                    'res_code' => 1,
                    'res_status' => 'Success',
                    // 'res_Message' => 'Your Data is Not Registered'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'res_code' => 2,
                    'res_status' => 'Failed',
                    'res_status' => 'Your Mobile no. already registered'
                ]);
            }
        } else {
            return response()->json([
                'response_code' => 500,
                'response_message' => 'Data is null'
            ]);

            // print_r($Mobile_number);exit;

        }
    }

    // ---------------------------------------------------Practise-----------------------------------------

    // public function insertData(Request $request)
    // {
    //     // echo "testing...";
    //     // exit;

    //     // Validate incoming request data
    //     $validatedData = $request->validate([
    //         'field1' => 'required',
    //         'field2' => 'required',
    //         // Add validation rules for other fields
    //     ]);

    //     // Insert data into the database
    //     $newRecord = agentdetails_model::create($validatedData);

    //     // You can return a response as per your requirement
    //     return response()->json(['message' => 'Data inserted successfully', 'data' => $newRecord], 201);
    // }



    // public function insertOrUpdate(Request $request, $id = null)
    // {
    //     // Validate incoming request data
    //     $validatedData = $request->validate([
    //         'field1' => 'required',
    //         'field2' => 'required',
    //         // Add validation rules for other fields
    //     ]);

    //     // Check if $id is provided
    //     if ($id) {
    //         // If $id is provided, update existing record
    //         $record = agentdetails_model::findOrFail($id);
    //         $record->update($validatedData);
    //         $message = 'Record updated successfully';
    //     } else {
    //         // If $id is not provided, insert new record
    //         $record = agentdetails_model::create($validatedData);
    //         $message = 'Record inserted successfully';
    //     }

    //     // You can return a response as per your requirement
    //     return response()->json(['message' => $message, 'data' => $record], 200);
    // }


    public function updateData(Request $request)
    {
        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        if ($data) {
            $Id = $data->id;

            $First_name = $data->first_name;
            $Last_name = $data->last_name;
            $Display_name = $data->display_name;
            $Agent_code = $data->agent_code;
            $Email_address = $data->email;
            $Mobile_number = $data->mobile_number;
            $Agent_type = $data->agent_type;
            $Profession = $data->profession;
            $Company_name = $data->company_name;
            $Emiratesid_no = $data->emiratesid_no;
            $Nationality = $data->nationality;
            $Emiratesid_Expiry = $data->emiratesid_expiry;
            $Communication_address = $data->communication_address;
            $PO_Box_Number = $data->po_box_number;
            $City = $data->city;
            $Refered_code = $data->refered_code;
            $Terms_conditions = $data->terms_conditions;

            $Updateagentdata = [
                //'id' => $Id,
                'first_name' => $First_name,
                'last_name' => $Last_name,
                'display_name' => $Display_name,
                'agent_code' => $Agent_code,
                'email' => $Email_address,
                'mobile_number' => $Mobile_number,
                'agent_type' => $Agent_type,
                'profession' => $Profession,
                'company_name' => $Company_name,
                'emiratesid_no' => $Emiratesid_no,
                'nationality' => $Nationality,
                'emiratesid_expiry' => $Emiratesid_Expiry,
                'communication_address' => $Communication_address,
                'po_box_number' => $PO_Box_Number,
                'city' => $City,
                'refered_code' => $Refered_code,
                'terms_conditions' => $Terms_conditions,
            ];

            $result = agentdetails_model::updateData($Id, $Updateagentdata);

            if ($result) {
                return response()->json([
                    'status' => true,
                    'res_code' => 1,
                    'res_status' => 'Success',
                    'res_data' => $Updateagentdata
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'res_code' => 2,
                    'res_status' => 'Failed',
                ]);
            }
        }
    }


    public function deleteData(Request $request)
    {
        //echo "testing...";exit;

        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        if ($data) {
            $Id = $data->id;

            $delete = agentdetails_model::delete_Data($Id);

            if ($delete) {
                return response()->json([
                    'status' => true,
                    'res_code' => 1,
                    'res_status' => 'Success',
                    'res_data' => $Id
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'res_code' => 2,
                    'res_status' => 'failed'
                ]);
            }
        }
    }


    public function getAgentdetails(Request $request)
    {
        //echo "testing...";exit;

        $data = json_decode($request->getContent());

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json(['status' => 'ok']);
        }

        $getData = agentdetails_model::get_Data();

        //print_r($getData[0]['id']);exit;

        // $agentId = $getData[0]['id'];

        //$getagentdataById = agentdetails_model::getDataById($agentId);

        $agentIds = [];

        // Iterate over each agent data
        foreach ($getData as $agent) {
            $agentIds[] = $agent['id']; // Collect the IDs
        }

        $getagentdataById = agentdetails_model::getDataById($agentIds);
        //dd($getData);exit;

        if ($getagentdataById) {
            return response()->json([
                'status' => true,
                'res_code' => 1,
                'res_status' => 'Success',
                'res_data' => $getagentdataById
            ]);
        } else {
            return response()->json([
                'status' => false,
                'res_code' => 2,
                'res_status' => 'Failed'
            ]);
        }
    }


    // public function getdata()
    // {
    //     $data = json_decode(file_get_contents('php://input'));

    //     if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
    //         $data["status"] = "ok";
    //         echo json_encode($data);
    //         exit;
    //     }

    //     $this->load->model('Apidemomodel');

    //     $result = $this->Apidemomodel->get_data();

    //     if (!empty($result)) {
    //         $response['status'] = 'success';
    //         $response['students'] = $result;
    //     } else {
    //         $response['status'] = 'error';
    //         $response['message'] = 'Custom query failed';
    //         // echo json_encode($response);
    //     }
    //     echo json_encode($response);
    // }

    // public function updatedata()
    // {
    //     $data = json_decode(file_get_contents('php://input'));

    //     if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
    //         $data["status"] = "ok";
    //         echo json_encode($data);
    //         exit;
    //     }

    //     if ($data) {
    //         $id = $data->id;
    //         $name = $data->name;
    //         $email = $data->email;
    //         $city = $data->city;
    //         $password = $data->password;

    //         // Assuming you have an associative array with the updated data
    //         $updateData = array(
    //             'id' => $id,
    //             'name' => $name,
    //             'email' => $email,
    //             'city' => $city,
    //             'password' => $password
    //             // add more fields as needed
    //         );

    //         $result = $this->Apidemomodel->updateEmployeeData($id, $updateData);

    //         $res = array();
    //         if ($result) {
    //             $res['response_code'] = '1';
    //             $res['response_message'] = 'Success';
    //             $res['data'] = $updateData;
    //         } else {
    //             $res['response_code'] = '2';
    //             $res['response_message'] = 'Failed';
    //         }

    //         echo json_encode($res);
    //         exit;
    //     }
    // }

    // public function deletedata()
    // {
    //     $data = json_decode(file_get_contents('php://input'));

    //     if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
    //         $data["status"] = "ok";
    //         echo json_encode($data);
    //         exit;
    //     }

    //     if ($data) {
    //         $id = $data->id;

    //         $delete = $this->Apidemomodel->delete_data($id);

    //         if ($delete) {
    //             $res['response_code'] = '1';
    //             $res['response_message'] = 'Success';
    //         } else {
    //             $res['response_code'] = '2';
    //             $res['response_message'] = 'Failed';
    //         }
    //         echo json_encode($res);
    //         exit;
    //     }
    // }



    public function generatePdf()
    {
        $data = [
            'title' => 'My PDF',
            'content' => 'This is the content of my PDF.',
        ];

        // Generate the PDF from the view
        $pdf = \PDF::loadView('pdfview', $data);

        // Define the folder where you want to save the PDF file
        $folderPath = public_path('uploads');

        // Check if the folder exists, if not, create it
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Generate a unique filename for the PDF
        $filename = 'my_pdf_' . uniqid() . '.pdf';

        // Define the path for the PDF file
        $filePath = $folderPath . '/' . $filename;

        // Save the PDF to the specified path
        $pdf->save($filePath);

        // Provide the download link for the saved PDF
        return response()->download($filePath, $filename);
    }



    // public function saveImageData(Request $request)
    // {
    //    // echo "testing...";exit;
    //     $request->validate([
    //         // 'name' => 'required',
    //         // 'description' => 'required',
    //         'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
    //     ]);

    //     // upload image

    //     // dd($request->all());
    //     // exit;

    //     $originalName = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);

    //     print_r($originalName);exit;

    //     $imageName = $originalName . '_' . time() . '.' . $request->image->extension();

    //     // dd($imageName);

    //     // $imageName = $request->name . '_' . time() . '.' . $request->image->extension();
    //     // $imageName = time() . '.' . $request->image->extension();
    //     $request->image->move(public_path('products'), $imageName);
    //     // dd($imageName);

    //     // Product model name
    //     $product = new agentdetails_model();
    //     $product->image = $imageName;
    //     // $product->name = $request->name;
    //     // $product->description = $request->description;

    //     $product->save();

    //     return redirect()->route('products.index')->withSuccess('Product Created !!!');
    // }


    public function saveImageData(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        // Get the original name of the uploaded image
        $originalName = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);

        // Generate a unique filename for the image
        $imageName = $originalName . '_' . time() . '.' . $request->image->getClientOriginalExtension();

        // Move the uploaded image to the 'products' folder within the 'uploads' directory
        $request->image->move(public_path('uploads/products'), $imageName);

        echo "testing...";
        exit;



        // Save the image filename to the database or perform any other operations as needed
        // $product = new agentdetails_model();
        // $product->image = $imageName;
        // $product->save();

        //  return redirect()->route('products.index')->withSuccess('Product Created !!!');
    }



    // public function generatePdf()
    // {
    //     $data = [
    //         'title' => 'My PDF',
    //         'content' => 'This is the content of my PDF.',
    //     ];

    //     $pdf = \PDF::loadView('pdfview', $data);
    //     return $pdf->download('my_pdf.pdf');
    // }



}
