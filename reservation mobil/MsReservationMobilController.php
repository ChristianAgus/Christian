<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use App\User;
use App\UserMap;
use  App\MsDepart;
use App\MsReservationMobil;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CRReportExport;
use Carbon\Carbon;
use Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MsReservationMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getMsReservationMobil ($status, Request $request)
        {  
            if($request->ajax()) {
                $user = Auth::user();
                $query = MsReservationMobil::query();

                $query->orderBy('created_at', 'desc');
    
                if ($user->id !== 106) {
                    $query->where('user_id', $user->id);
                }
                if($status ==  "Pending") {
                    $query->whereNotIn('status', ['Approved', 'Unapproved']);
                } elseif($status == "Approved") {
                    $query->whereNotIn('status', ['pending', 'Unapproved']);
                } else {
                    $query->whereNotIn('status', ['Approved', 'pending']);
                }
    
                $reservation = $query->get();
    
                return DataTables::of($reservation)
                    ->addColumn('user_id', function ($data) {
                        return $data->user->name;
                })
                ->addColumn('action', function ($data) {
                        $val = array(
                            'id'               => $data->id,
                            'user_id'          => $data->user->name,
                            'department'       => $data->department,
                            'company'          => $data->company,
                            'cost_center'      => $data->cost_center,
                            'status'           => $data->status,
                            'date_from'        => $data->date_from,
                            'date_to'          => $data->date_to,
                            'time_from'        => $data->time_from,
                            'time_to'          => $data->time_to,
                            'plant'            => $data->plant,
                            'destination'      => $data->destination,
                            'description'      => $data->description,
                            'car_load'         => $data->car_load,
                            'feedback'         => $data->feedback,
    
                        );
                        if ($data->status == 'pending') {
                            return "
                            <a href='javascript:void(0)' onclick='editReq1(" . htmlspecialchars(json_encode($val), ENT_QUOTES, 'UTF-8') . ")' class='btn btn-sm btn-primary btn-square' title='Update'><i class='fa fa-edit'></i></a>
                            <button data-url=\"" . route('delete.data', $data->id) . "\" class=\"btn btn-sm btn-outline-danger btn-square delete-btn\" title=\"Delete\"><i class=\"fa fa-trash\"></i></button>
                            <a href='javascript:void(0)' class='btn btn-sm btn-outline-info btn-square' onclick='openDetailModal(" . json_encode($val) . ")' title='Detail'>Detail</a>
                            ";
                        } else {
                            
                            return "<a href='javascript:void(0)' class='btn btn-sm btn-outline-info btn-square' onclick='openDetailModal(" . json_encode($val) . ")' title='Detail'>Detail</a>";
                        }
                    })
    
                ->addColumn('operations', function ($data) use ($status) {
                    if ($status == 'Pending') {
                        $buttonLabel = 'Pending';
                        $buttonClass = 'btn-warning';
                        $buttonStatus = 'Pending';
                            return "<button data-id='" . $data->id . "' data-feedback='" . $data->feedback . "' data-datefrom='" . $data->date_from . "' data-dateto='" . $data->date_to . "' class='btn btn-sm btn-square js-swal-delete2 " . $buttonClass . "' data-status='" . $buttonStatus . "'><i class='si si-clock mr-2'></i>" . $buttonLabel . "</button>";
                    } else if ($status == 'Approved') {
                        $buttonLabel = 'Approved';
                        $buttonClass = 'btn-success';
                        $buttonStatus = 'Pending';
                        return "<button data-id='" . $data->id . "' data-feedback='" . $data->feedback . "' data-datefrom='" . $data->date_from . "' data-dateto='" . $data->date_to . "' class='btn btn-sm btn-square js-swal-delete2 " . $buttonClass . "' data-status='" . $buttonStatus . "'><i class='si si-check mr-2'></i>" . $buttonLabel . "</button>";
                    } else {
                        $buttonLabel = 'Unapproved';
                        $buttonClass = 'btn-danger';
                    $buttonStatus = 'Pending';
                    return "<button data-id='" . $data->id . "' data-feedback='" . $data->feedback . "' data-datefrom='" . $data->date_from . "' data-dateto='" . $data->date_to . "' class='btn btn-sm btn-square js-swal-delete2 " . $buttonClass . "' data-status='" . $buttonStatus . "'><i class='si si-close mr-2'></i>" . $buttonLabel . "</button>";
                    }
                })
                
                    ->rawColumns(['action' , 'operations'])
                    ->make(true);
            }
            $data['status'] = $status;
            return view ('reservationcar.reservation', $data);
           
        }

     public function getDepart($id)
        {
            $userMap = UserMap::where('user_id', $id)->first();
            if ($userMap && $userMap->ms_depart_id) {
                $depart = MsDepart::find($userMap->ms_depart_id);
                if ($depart) {
                    return response()->json(['divisi' => $depart->name]);
                }
            }
            return response()->json([]);
        }

     public function addreservation(Request $request)
        {
            $data = $request->all();
        
            $limit = [
                'date_from'   => 'required',
                'date_to'     => 'required',
                'time_from'   => 'required',
                'time_to'     => 'required',
                'plant'       => 'required',
                'destination' => 'required',
                'description' => 'required',
                'car_load'    => 'required',
            ];
        
            $validator = Validator::make($data, $limit);
        
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            } else {
                try {
                    DB::beginTransaction();
        
                    MsReservationMobil::create([
                        'user_id'    =>  $request->input('user_id'),
                        'department' =>  $request->input('department'),
                        'company'    =>  $request->input('company'),
                        'cost_center'=>  $request->input('cost_center'),
                        'status'     =>  $request->input('status'),
                        'date_from'  =>  $request->input('date_from'),
                        'date_to'    =>  $request->input('date_to'),
                        'time_from'  =>  $request->input('time_from'),
                        'time_to'    =>  $request->input('time_to'),
                        'plant'      =>  $request->input('plant'),
                        'destination'=>  $request->input('destination'),
                        'description'=>  $request->input('description'),
                        'car_load'   =>  $request->input('car_load')
                    ]);
                    $pesan = "
                <html>
                <head>
                    <title>Email Pemberitahuan</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                        }

                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                        }

                        .header {
                            background-color: #007BFF;
                            color: #fff;
                            padding: 20px;
                            text-align: center;
                        }

                        .content {
                            padding: 20px;
                            border: 1px solid #ccc;
                        }

                        .content h2 {
                            color: #007BFF;
                        }

                        .table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        .table td, .table th {
                            padding: 10px;
                            border: 1px solid #ccc;
                        }

                        .table th {
                            background-color: #f2f2f2;
                        }

                        .footer {
                            background-color: #f2f2f2;
                            padding: 10px;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Pengajuan Reservasi Mobil</h1>
                        </div>
                        <div class='content'>
                            <h2>Detail Pengajuan:</h2>
                            <p>Dear Bapak F. C. Jati Pramono,</p>
                            <p>Pengajuan reservasi mobil telah diajukan:</p>
                            <table class='table'>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>" . $request->input('date_from') . " - " . $request->input('date_to') . "</td>
                                </tr>
                                <tr>
                                    <th>Jam</th>
                                    <td>" . $request->input('time_from') . " - " . $request->input('time_to') . "</td>
                                </tr>
                                <tr>
                                    <th>Tujuan</th>
                                    <td>" . $request->input('destination') . "</td>
                                </tr>
                                <tr>
                                    <th>User Peminjam</th>
                                    <td>" . Auth::user()->name . "</td>
                                </tr>
                                <tr>
                                    <th>Departement</th>
                                    <td>" . $request->input('department') . "</td>
                                </tr>
                                <tr>
                                    <th>Kapasitas Kendaraan</th>
                                    <td>" . $request->input('car_load') . "</td>
                                </tr>
                                <tr>
                                    <th>Informasi Mengenai Peminjaman</th>
                                    <td>" . $request->input('description') . "</td>
                                </tr>
                            </table>
                            <br>
                            <p>Terima kasih atas perhatiannya dan saya menunggu konfirmasi Anda segera.</p>
                        </div>
                        <div class='footer'>
                            <p>Terima kasih,</p>
                            <p>" . Auth::user()->name . "</p>
                        </div>
                    </div>
                </body>
                </html>";


                $mail = new PHPMailer(true);
                        
                try {
                    $mail->IsHTML(true);
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Host = 'mail.myhaldin.com';
                    $mail->Port =  587;
                    $mail->Username = 'administrator@myhaldin.com'; // user email
                    $mail->Password = '!!@dminHaldin2022'; // password email
                    $mail->setFrom('administrator@myhaldin.com', 'CMS Haldin'); // user email
                    $mail->addReplyTo('administrator@myhaldin.com', 'CMS Haldin'); //user email
                   
                    $mail->AddAddress('tianpurwanto100@gmail.com');
                    $mail->addCC('purwantoagus487@gmail.com');
                    //$mail->addCC(Auth::user()->email);
                    //$mail->addBcc("benny.wijaya@myhaldin.com");
                   // $mail->addBcc("eko.yunianto@myhaldin.com");
                    // $mail->addBcc("titi.romlah@haldin-natural.com");
                    $mail->Subject = 'Reservasi mobil';
                    $mail->Body = $pesan;
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    $mail->send();
                } catch (Exception $e) {
                    return response()->json([
                        'type'      => 'warning',
                        'message'   => $e->getMessage()
                    ]);
                }
                    DB::commit();
        
                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully added Reservation!'
                    ], 200);
                } catch (\Exception $e) {
                    DB::rollback();
        
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred: ' . $e->getMessage()
                    ], 500);
                }
            }
        }


     public function edit(Request $request)
        {
            $dataEdit = MsReservationMobil::where('id', $request->id)->first();

            if (!$dataEdit) {
                return response()->json([
                    'type' => 'danger',
                    'message' => 'Reservation data not found'
                ]);
            }

            $data = $request->all();
            $limit = [
                'date_from' => 'required',
                'date_to' => 'required',
                'time_from' => 'required',
                'time_to' => 'required',
                'plant' => 'required',
                'destination' => 'required',
                'description' => 'required',
                'car_load' => 'required',
            ];
            
            $validator = Validator::make($data, $limit);

            if ($validator->fails()){
                return response()->json([
                    'type' => 'danger',
                    'message' => $validator->errors()
                ]);
            } else {
                try {
                    DB::beginTransaction();
                    $dataEdit->date_from = $request->input('date_from');
                    $dataEdit->date_to = $request->input('date_to');
                    $dataEdit->company = $request->input('company');
                    $dataEdit->cost_center = $request->input('cost_center');
                    $dataEdit->time_from = $request->input('time_from');
                    $dataEdit->time_to = $request->input('time_to');
                    $dataEdit->plant = $request->input('plant');
                    $dataEdit->destination = $request->input('destination');
                    $dataEdit->description = $request->input('description');
                    $dataEdit->car_load = $request->input('car_load');
                    
                    // Save the changes
                    $dataEdit->save();

                    DB::commit();
                    
                    return response()->json([
                        'type' => 'info',
                        'message' => 'Reservation data updated successfully'
                    ]);
                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'type' => 'warning',
                        'message' => $e->getMessage()
                    ]);
                }
            }
        }

     public function delete($id)
        {
            try {
                $data = MsReservationMobil::findOrFail($id); // Ganti 'Data' dengan nama model Anda
                $data->delete();
                return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error deleting data']);
            }
        }

     public function getReservationDetail(Request $request)
        {
            if ($request->ajax()) {
                $reservationId = $request->input('reservation_id');
                
                $reservationDetail = MsReservationMobil::with(['user', 'other_relations'])
                    ->findOrFail($reservationId);
                return response()->json($reservationDetail);
            }
        }

     public function updateReservationDetails(Request $request)
        {
            $id = $request->input('id');
            $status = $request->input('status');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');
            $feedback = $request->input('feedback');

            $reservation = MsReservationMobil::findOrFail($id);
            $reservation->status = $status;
            $reservation->date_from = $dateFrom;
            $reservation->date_to = $dateTo;
            $reservation->feedback = $feedback;
            $reservation->save();

            return response()->json([
                'message' => 'Reservation details updated successfully.'
            ]);
        }

    public function CRReport(Request $request)
        {
               $dataReservation = MsReservationMobil::query();
   
               if ($request->input('from') != null) {
                   $dataReservation->whereBetween('date_from', [$request->input('from'), $request->input('to')]);
               }

               $dataReservation->where('status', 'Approved');
   
               $data = array();
               foreach ($dataReservation->get() as $reserv) {
                   $data[] = array(
                    'name'        => "<i class='fa fa-id-badge'></i> " . $reserv->user->name . "<br><i class='fa fa-briefcase'></i> " . $reserv->department . "<br><i class='fa fa-building'></i>" . $reserv->company . "<br>" .
                                  "<i class='fa fa-phone mr-1'></i>" . $reserv->cost_center . "<br><i class='fa fa-globe'></i> " . $reserv->plant . "</small>",
                    'destination' => $reserv->destination . "<br><small>Reserve date From : " . $reserv->date_from . " " . $reserv->time_from . "</small>" .
                                  "<br><small>Reserve date To : " . $reserv->date_to . " " . $reserv->time_to .  "<br><small>Reserve date From : " . $reserv->status,
                    'description' => $reserv->description,
                    'car_load'    => $reserv->car_load,
                    'feedback'    => $reserv->feedback,
                   ); 
               }
   
               return Datatables::of(collect($data))
                   ->rawColumns(['name', 'destination', 'description', 'car_load', 'feedback'])
                   ->make(true);
        }
   
    public function CRReportExcel()
        {
               return Excel::download(new CRReportExport, "CR Report ".Auth::user()->name.".xlsx");
        }


}


     

