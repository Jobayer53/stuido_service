<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;

class ApiController extends Controller
{
    public function server_copy()
    {
        $server_copy = Service::find(47);
        $orders = Order::where('user_id', auth()->user()->id)->where('service_id', $server_copy->id)->select(['id', 'slug', 'status', 'cost', 'type', 'nid_number', 'created_at'])->orderByDesc('created_at')->paginate(20);
        return view('frontend.pages.api.server_copy', [
            'server_copy' => $server_copy,
            'orders' => $orders
        ]);
    }
    public function server_copy_download(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nid' => 'required',
            'dob' => 'required',
        ], [
            'nid.required' => 'আপনার  এনআইডি নাম্বার লিখুন',
            'dob.required' => 'আপনার জন্ম তারিখ লিখুন',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $server_copy = Service::find(47);
        $user = auth()->user();

        if ($user->amount < $server_copy->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $nid = $request->nid;
        $dob = $request->dob;
        $apiKey = '89d6492a89191d4c50728c56cb548ba8';
        $url = "https://unique-seba.com/api/servercopy2";

        $response = Http::get($url, [
            'api_key' => $apiKey,
            'nid'     => $nid,
            'dob'     => $dob,
        ]);
        $data = json_decode($response->body());
        if (isset($data->error)) {
            notyf()->position('x', 'right')->position('y', 'top')->error($data->error);
            return back();
        }

        // Case 2: No valid NID in response
        if (!isset($data->nationalId) || empty($data->nationalId)) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার এনআইডি নাম্বার সঠিক নয়।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $server_copy->id;
        $order->cost = $server_copy->cost;
        $order->type = 'server_copy';
        $order->nid_number = $data->nationalId;
        $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
        $order->status = 'completed';
        $order->notified = 0;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        return view('frontend.pages.api.server_copyPdf', [
            'data' => $data
        ]);
    }
    public function tin()
    {
        $service = Service::find(50);
        return view('frontend.pages.api.tin', [
            'service' => $service
        ]);
    }
    public function tinStore(Request $request)
    {
        //dd($request->all());



        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('file')->getPathname());
        $text = $pdf->getText();


        // Step 1: Extract structured info with regex
        $data = [
            'nid' => $this->extractValue($text, 'National ID'),
            'pin' => $this->extractValue($text, 'Pin'),
            'status' => $this->extractValue($text, 'Status'),
            'nameEnglish' => $this->extractValue($text, 'Name\\(English\\)'),
            'nameBangla' => $this->extractValue($text, 'Name\\(Bangla\\)'),
            'dateOfBirth' => $this->extractValue($text, 'Date of Birth'),
            'birthPlace' => $this->extractValue($text, 'Birth Place'),
            'fatherName' => $this->extractValue($text, 'Father Name'),
            'motherName' => $this->extractValue($text, 'Mother Name'),
            'spouseName' => $this->extractValue($text, 'Spouse Name'),
            'gender' => $this->extractValue($text, 'Gender'),
            'maritalStatus' => $this->extractValue($text, 'Marital'),
            'occupation' => $this->extractValue($text, 'Occupation'),
            'education' => $this->extractValue($text, 'Education'),
            'religion' => $this->extractValue($text, 'Religion'),
            // Add more fields as needed...
        ];

        return response()->json(['data' => $data]);

        // $pdfPath = $request->file->getPathname();
        // $pdfName = $request->file->getClientOriginalName();
        // $response = Http::attach(
        //     'pdf',
        //     file_get_contents($pdfPath),
        //     $pdfName
        // )->post('https://api-store.top/sigg.php');
        // if ($response->successful()) {
        //     return response()->json($response->json());
        // }
        // return response()->json([
        //     'error' => true,
        //     'message' => 'TIN API request failed',
        //     'details' => $response->body()
        // ], $response->status());




        // $json = ' {
        //     "nid": "7318929564",
        //     "pin": "19831913621828203",
        //     "name_bn": "জায়েদা খাতুন",
        //     "name_en": "Zayda Khatun",
        //     "father_name": "আশ্বাদ মিয়া",
        //     "mother_name": "ছাফিয়া খাতুন",
        //     "dob": "10 Sep 1983",
        //     "birth_place": "কুমিল্লা",
        //     "blood_group": "",
        //     "fulladdress": "বাসা/হোল্ডিং: ., গ্রাম/রাস্তা: ১ম গোবিন্দপুর, ডাকঘর: জগতপুর - ৩৫১৭, তিতাস, কুমিল্লা",
        //     "photo": "https://unique-seba.com/nid_make/tmp_images/rzFO4KRXns1TeCocWu1uQSOWbGWn8JY4nVVWX3zR.png",
        //     "signature": "https://unique-seba.com/nid_make/tmp_images/tgNFj3YeXbnmktUDq7V6yASUbv8AbMpUgyrYQk6O.png"
        // }';
        // $data = json_decode($json);
        // return view('frontend.pages.api.tin_pdf', [
        //     'data' => $data
        // ]);
        // if ($response->successful()) {

        //     $data = json_decode($response->body());
        //     // return redirect(route('order_api_tin_download', ['data' => $data]));
        //     return view('frontend.pages.api.tin_pdf', [
        //         'data' => $data
        //     ]);
        //     return response()->json($response->json());
        // }

        // return response()->json([
        //     'error' => true,
        //     'message' => 'TIN API request failed',
        //     'details' => $response->body()
        // ], $response->status());
    }
    private function extractValue($text, $label)
    {
        preg_match("/{$label}\s+([^\n]+)/u", $text, $matches);
        return $matches[1] ?? null;
    }
    public function sign_to_nid()
    {
        $signToNid = Service::find(48);

        return view('frontend.pages.api.sign_to_nid', [
            'signToNid' => $signToNid
        ]);
    }
    public function get_nid(Request $request)
    {
        if ($request->sign_copy == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'সাইন কপি আপলোড করুন'
            ]);
        }
        $pdfPath = $request->sign_copy->getPathname();
        $pdfName = $request->sign_copy->getClientOriginalName();
        $user = auth()->user();
        $service = Service::find(48);
        if ($user->amount < $service->cost) {
            return response()->json([
                'status' => 'error',
                'message' => 'আপনার পর্যাপ্ত পরিমাণ টাকা নেই।'
            ]);
        }
        $response = Http::attach(
            'pdf',
            file_get_contents($pdfPath),
            $pdfName
        )->post('https://unique-seba.com/api/signtonid2', [
            'api_key' => '14cc8f3eecb06ebeeee0e730881d0822'
        ]);
        //         $json =' {
        //   "nid": "7318929564",
        //   "pin": "19831913621828203",
        //   "name_bn": "জায়েদা খাতুন",
        //   "name_en": "Zayda Khatun",
        //   "father_name": "আশ্বাদ মিয়া",
        //   "mother_name": "ছাফিয়া খাতুন",
        //   "dob": "10 Sep 1983",
        //   "birth_place": "কুমিল্লা",
        //   "blood_group": "",
        //   "fulladdress": "বাসা/হোল্ডিং: ., গ্রাম/রাস্তা: ১ম গোবিন্দপুর, ডাকঘর: জগতপুর - ৩৫১৭, তিতাস, কুমিল্লা",
        //   "photo": "https://unique-seba.com/nid_make/tmp_images/rzFO4KRXns1TeCocWu1uQSOWbGWn8JY4nVVWX3zR.png",
        //   "signature": "https://unique-seba.com/nid_make/tmp_images/tgNFj3YeXbnmktUDq7V6yASUbv8AbMpUgyrYQk6O.png"
        // }';
        // $data = json_decode($json);
        //  return response()->json(['status' => 'success', 'data' => $data], 200);
        $data = json_decode($response->body());
        if ($response->successful()) {
            $order = new Order();
            $order->slug = uniqid();
            $order->user_id = $user->id;
            $order->service_id = $service->id;
            $order->cost = $service->cost;
            $order->type = 'sign_to_nid';
            $order->type_number = $data->pin;
            $order->nid_number = $data->nid;
            $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
            $order->status = 'completed';
            $order->notified = 0;
            $order->save();
            $user->amount = $user->amount - $order->cost;
            $user->save();

            return response()->json(['status' => 'success', 'data' => $data, 'slug' => $order->slug, 'issue_date' => date('d/m/Y')], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'তথ্য পাওয়া যায় নি, কিছুক্ষন পর আবার চেষ্টা করুন !!'], 200);
        }
    }
    public function signToNid_download(Request $request)
    {
        $order = Order::where('slug', $request->slug)->first();
        if ($order == null || $order->user_id != auth()->user()->id) {
            notyf()->position('x', 'right')->position('y', 'top')->error(' অর্ডার পাওয়া যায়নি।');
            return back();
        }
        if ($order->type_number != $request->pin) {
            notyf()->position('x', 'right')->position('y', 'top')->error(' অর্ডার পাওয়া যায়নি।');
            return back();
        }

        $data = $request->all();
        $photo = $request->photo_url;
        $sign = $request->sign_url;
        if ($request->photo) {
            $photo = $request->photo;
            $base64 = base64_encode(file_get_contents($photo));
            $mime = $photo->getMimeType();
            $src = "data:$mime;base64,$base64";
            $photo = $src;
        }
        if ($request->sign) {
            $sign = $request->sign;
            $base64 = base64_encode(file_get_contents($sign));
            $mime = $sign->getMimeType();
            $src = "data:$mime;base64,$base64";
            $sign = $src;
        }

        $json = [
            "nid"         => $data['nid'] ?? '',
            "pin"         => $data['pin'] ?? '',
            "name_bn"     => $data['name_bn'] ?? '',
            "name_en"     => $data['name_en'] ?? '',
            "father_name" => $data['father_name'] ?? '',
            "mother_name" => $data['mother_name'] ?? '',
            "dob"         => $data['dob'] ?? '',
            "birth_place" => $data['birth_place'] ?? '',
            "blood_group" => $data['blood_group'] ?? '',
            "fulladdress" => $data['fulladdress'] ?? '',
            'issue_date'  => $data['issue_date'] ?? '',
            // extra static (or generated) fields
            "photo"       => $photo ?? '',
            "signature"   => $sign ?? '',
        ];
        $data = json_decode(json_encode($json));
        return view('frontend.pages.api.sign_to_nidPdf', [
            'data' => $data
        ]);
    }
    public function auto_bc()
    {
        $service = Service::find(49);
        return view('frontend.pages.api.auto_bc', [
            'service' => $service
        ]);
    }
    public function get_autoBc(Request $request)
    {

        if ($request->brn == null || $request->dob == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'তথ্য পূরণ করুন !!'
            ]);
        }

        $user = auth()->user();
        $service = Service::find(49);
        if ($user->amount < $service->cost) {
            return response()->json([
                'status' => 'error',
                'message' => 'আপনার পর্যাপ্ত পরিমাণ টাকা নেই।'
            ]);
        }

        $brn = $request->brn;
        $dob = $request->dob;
        $url = "https://api-store.top/birth.php";
        $apiKey = "b6fd07fc812b31db8b7345872604fbf6";


        try {

            $response = Http::get($url, [
                'brn'     => $brn,
                'dob'     => $dob,
                'api_key' => $apiKey
            ]);
       

            $data = json_decode($response->body(), true);

            // API error check
            if (isset($data['Success']) && $data['Success'] === 'False') {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['Message']
                ], 400);

            }
           if ($response->successful()) {
                // Success
            $order = new Order();
            $order->slug = uniqid();
            $order->user_id = $user->id;
            $order->service_id = $service->id;
            $order->cost = $service->cost;
            $order->type = 'auto_birth_certificate';
            $order->type_number = $request->brn;
            $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
            $order->status = 'completed';
                $order->notified = 0;
            $order->save();
            $user->amount = $user->amount - $order->cost;
            $user->save();
            // $data = json_decode($response->body());
            return response()->json([
                'status' => 'success',
                'data'   => $data,
                'slug'   => $order->slug
            ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Server error'
                ], 500);
            }


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: Please try again later.'
            ], 500);
        }



        //                 $json ='{
        //     "Owner": "unique-seba.com",
        //     "nameBangla": "জহির  উদ্দিন",
        //     "nameEnglish": "JOHIR UDDIN",
        //     "dateOfBirth": "12/03/1967",
        //     "dateOfBirthEn": "Twelve March One Thousand Nine Hundred Sixty-seven",
        //     "dateOfToday": "25/08/2025",
        //     "brn": "19671939467122202",
        //     "gender": "পুরুষ",
        //     "genderEn": "Male",
        //     "fatherName": "করম আলী",
        //     "fatherNameEn": "KOROM ALI",
        //     "fathersNationality": "বাংলাদেশি",
        //     "fathersNationalityEn": "Bangladeshi",
        //     "motherName": "রাবেয়া খাতুন",
        //     "motherNameEn": "RABEYA KHATUN",
        //     "mothersNationality": "বাংলাদেশি",
        //     "mothersNationalityEn": "Bangladeshi",
        //     "birthPlace": "কুমিল্লা, বাংলাদেশ",
        //     "birthPlaceEn": "Cumilla, Bangladesh",
        //     "registerOffice": "কড়িকান্দি ইউনিয়ন পরিষদ",
        //     "registerOfficeEn": "Karikandi Union Parishad",
        //     "registerOfficeLocation": "তিতাস, কুমিল্লা",
        //     "registerOfficeLocationEn": "Titas, Cumilla",
        //     "address": "কড়িকান্দি, তিতাস, কুমিল্লা, চট্টগ্রাম বিভাগ, বাংলাদেশ",
        //     "addressEn": "Karikandi, Titas, Cumilla, Chattogram Division, Bangladesh"
        // }';
        //         $data = json_decode($json);
        //           $user = auth()->user();
        //         $service = Service::find(49);
        //   $order = new Order();
        //             $order->slug = uniqid();
        //             $order->user_id = $user->id;
        //             $order->service_id = $service->id;
        //             $order->cost = $service->cost;
        //             $order->type = 'auto_birth_certificate';
        //             $order->type_number = $request->brn;
        //             $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
        //             $order->status = 'completed';
        //             $order->save();
        //             $user->amount = $user->amount - $order->cost;
        //             $user->save();
        //          return response()->json(['status' => 'success', 'data' => $data, 'slug'   => $order->slug], 200);

    }
    public function autoBc_download(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $order = Order::where('slug', $request->slug)->first();

        if ($order == null || $order->user_id != $user->id) {
            notyf()->position('x', 'right')->position('y', 'top')->error('অর্ডার পাওয়া যায়নি।1');
            return back();
        }
        if ($order->type_number != $request->brn) {
            notyf()->position('x', 'right')->position('y', 'top')->error('অর্ডার পাওয়া যায়নি।2');
            return back();
        }
        return view('frontend.pages.api.auto_bcPdf', [
            'data' => $data
        ]);
    }
    public function auto_nid()
    {
        $service = Service::find(51);
        $autoNid = Service::find(52);
        return view('frontend.pages.api.auto_nid', [
            'service' => $service,
            'autoNid' => $autoNid
        ]);
    }
    public function get_nid2(Request $request)
    {
        if ($request->nid == null || $request->dob == null) {
            return response()->json(['status' => 'error', 'message' => 'আপনার জন্মনিবন্ধন নম্বর এবং জন্ম তারিখ দিন'], 200);
        }

        $user = auth()->user();
        $service = Service::find(51);
        if ($user->amount < $service->cost) {
            return response()->json([
                'status' => 'error',
                'message' => 'আপনার পর্যাপ্ত পরিমাণ টাকা নেই।'
            ]);
        }
        $nid = $request->nid;
        $dob = $request->dob;
        $apiKey = '2033d0459c1bd9ae1bf6bd42dd034936';
        $url = "https://unique-seba.com/api/autonid2";
        $response = Http::get($url, [
            'api_key' => $apiKey,
            'nid'     => $nid,
            'dob'     => $dob,
        ]);
        $data = json_decode($response->body());
        if (isset($data->error)) {
            return response()->json(['status' => 'error', 'message' => $data->error], 200);
        }

        //         $json = '{
        //     "Owner": "unique-seba.com",
        //     "nid": "4222429823",
        //     "pin": "20024222429823385",
        //     "name_bn": "জোবায়ের হোসেন শিকদার",
        //     "name_en": "ZOBAIR HOSSAIN SHIKDAR",
        //     "dob": "09 Dec 2002",
        //     "birth_place": "কুমিল্লা",
        //     "father_name": "সফিকুল ইসলাম",
        //     "mother_name": "শান্তি বেগম",
        //     "blood_group": "N/A",
        //     "fulladdress": "বাসা/হোল্ডিং: মৌটুপী, গ্রাম/রাস্তা: মৌটুপী, মৌটুপী, ডাকঘর: মজিদ পুর - 3517, তিতাস, তিতাস",
        //     "photo": null,
        //     "signature": "https://unique-seba.com/public/loadedImages/signatures/4222429823_1757260850.png"
        // }';
        // $data = json_decode($json);
        //  return response()->json(['status' => 'success', 'data' => $data], 200);

        if ($response->successful()) {
            $order = new Order();
            $order->slug = uniqid();
            $order->user_id = $user->id;
            $order->service_id = $service->id;
            $order->cost = $service->cost;
            $order->type = 'auto_nid';
            $order->type_number = $data->pin;
            $order->nid_number = $data->nid;
            $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
            $order->status = 'completed';
                $order->notified = 0;
            $order->save();
            $user->amount = $user->amount - $order->cost;
            $user->save();

            return response()->json(['status' => 'success', 'data' => $data, 'slug' => $order->slug, 'issue_date' => date('d/m/Y')], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'তথ্য পাওয়া যায় নি, কিছুক্ষন পর আবার চেষ্টা করুন !!'], 200);
        }
    }
    public function autoNid_download(Request $request)
    {
        $user = auth()->user();
        $autoNid = Service::find(52);
        $data = $request->all();
        if ($request->slug) {
            $order = Order::where('slug', $request->slug)->first();
            if ($order == null || $order->user_id != $user->id) {
                notyf()->position('x', 'right')->position('y', 'top')->error(' অর্ডার পাওয়া যায়নি।');
                return back();
            }
            if ($order->type_number != $request->pin) {
                notyf()->position('x', 'right')->position('y', 'top')->error(' অর্ডার পাওয়া যায়নি।');
                return back();
            }
        } else {
            if ($autoNid->available == 0) {
                notyf()->position('x', 'right')->position('y', 'top')->error('সেবা বন্ধ আছে!');
                return back();
            }
            $order = new Order();
            $order->slug = uniqid();
            $order->user_id = $user->id;
            $order->service_id = $autoNid->id;
            $order->cost = $autoNid->cost;
            $order->type = 'auto_nid';
            $order->type_number = $data['pin'];
            $order->nid_number = $data['nid'];
            $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
            $order->status = 'completed';
                $order->notified = 0;
            $order->save();
            $user->amount = $user->amount - $autoNid->cost;
            $user->save();
        }

        $photo = $request->photo_url;
        $sign = $request->sign_url;
        if ($request->photo) {
            $photo = $request->photo;
            $base64 = base64_encode(file_get_contents($photo));
            $mime = $photo->getMimeType();
            $src = "data:$mime;base64,$base64";
            $photo = $src;
        }
        if ($request->sign) {
            $sign = $request->sign;
            $base64 = base64_encode(file_get_contents($sign));
            $mime = $sign->getMimeType();
            $src = "data:$mime;base64,$base64";
            $sign = $src;
        }

        $json = [
            "nid"         => $data['nid'] ?? '',
            "pin"         => $data['pin'] ?? '',
            "name_bn"     => $data['name_bn'] ?? '',
            "name_en"     => $data['name_en'] ?? '',
            "father_name" => $data['father_name'] ?? '',
            "mother_name" => $data['mother_name'] ?? '',
            "dob"         => $data['dob'] ?? '',
            "birth_place" => $data['birth_place'] ?? '',
            "blood_group" => $data['blood_group'] ?? '',
            "fulladdress" => $data['fulladdress'] ?? '',
            'issue_date'  => $data['issue_date'] ?? '',
            // extra static (or generated) fields
            "photo"       => $photo ?? '',
            "signature"   => $sign ?? '',
        ];
        $data = json_decode(json_encode($json));
        return view('frontend.pages.api.sign_to_nidPdf', [
            'data' => $data
        ]);
    }

    public function smrtNid()
    {
        $service = Service::find(53);
        $autoSmrtNid = Service::find(54);
        return view('frontend.pages.api.sign_to_smrtNid', [
            'service' => $service,
            'autoSmrtNid' => $autoSmrtNid
        ]);
    }
    public function get_smrtnid(Request $request)
    {
        if ($request->sign_copy == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'সাইন কপি আপলোড করুন'
            ]);
        }
        $pdfPath = $request->sign_copy->getPathname();
        $pdfName = $request->sign_copy->getClientOriginalName();
        $user = auth()->user();
        $service = Service::find(53);
        if ($user->amount < $service->cost) {
            return response()->json([
                'status' => 'error',
                'message' => 'আপনার পর্যাপ্ত পরিমাণ টাকা নেই।'
            ]);
        }
        $url = "https://api-store.top/sign.php";
        $api_key = "b6fd07fc812b31db8b7345872604fbf6";
        $response = Http::attach(
            'pdf',
            file_get_contents($pdfPath),
            $pdfName
        )->post($url, [
            'api_key' => $api_key
        ]);

        $data = json_decode($response->body());
        //    return response()->json(['status' => 'success', 'data' => $data], 200);
        if ($response->successful()) {
            $order = new Order();
            $order->slug = uniqid();
            $order->user_id = $user->id;
            $order->service_id = $service->id;
            $order->cost = $service->cost;
            $order->type = 'sign_to_smrtNid';
            $order->type_number = $data->data->pin;
            $order->nid_number = $data->data->nid;
            $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
            $order->status = 'completed';
                $order->notified = 0;
            $order->save();
            $user->amount = $user->amount - $order->cost;
            $user->save();

            return response()->json(['status' => 'success', 'data' => $data, 'slug' => $order->slug, 'issue_date' => date('d M Y')], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'তথ্য পাওয়া যায় নি, কিছুক্ষন পর আবার চেষ্টা করুন !!'], 200);
        }
    }
    public function signToSmrtNid_download(Request $request)
    {

        $user = auth()->user();
        $autoSmrtNid = Service::find(54);
        $data = $request->all();
        if ($request->slug) {
            $order = Order::where('slug', $request->slug)->first();
            if ($order == null || $order->user_id != $user->id) {
                notyf()->position('x', 'right')->position('y', 'top')->error(' অর্ডার পাওয়া যায়নি।');
                return back();
            }
            if ($order->type_number != $request->pin) {
                notyf()->position('x', 'right')->position('y', 'top')->error(' অর্ডার পাওয়া যায়নি।');
                return back();
            }
        } else {
            if ($autoSmrtNid->available == 0) {
                notyf()->position('x', 'right')->position('y', 'top')->error('সেবা বন্ধ আছে!');
                return back();
            }
            $order = new Order();
            $order->slug = uniqid();
            $order->user_id = $user->id;
            $order->service_id = $autoSmrtNid->id;
            $order->cost = $autoSmrtNid->cost;
            $order->type = 'auto_smrtNid';
            $order->type_number = $data['pin'];
            $order->nid_number = $data['nid'];
            $order->description = json_encode($data, JSON_UNESCAPED_UNICODE);
            $order->status = 'completed';
                $order->notified = 0;
            $order->save();
            $user->amount = $user->amount - $autoSmrtNid->cost;
            $user->save();
        }

        $photo = $request->photo_url;
        $sign = $request->sign_url;
        if ($request->photo) {
            $photo = $request->photo;
            $base64 = base64_encode(file_get_contents($photo));
            $mime = $photo->getMimeType();
            $src = "data:$mime;base64,$base64";
            $photo = $src;
        }
        if ($request->sign) {
            $sign = $request->sign;
            $base64 = base64_encode(file_get_contents($sign));
            $mime = $sign->getMimeType();
            $src = "data:$mime;base64,$base64";
            $sign = $src;
        }

        $json = [
            "nid"         => $data['nid'] ?? '',
            "pin"         => $data['pin'] ?? '',
            "name_bn"     => $data['name_bn'] ?? '',
            "name_en"     => $data['name_en'] ?? '',
            "father_name" => $data['father_name'] ?? '',
            "mother_name" => $data['mother_name'] ?? '',
            "dob"         => $data['dob'] ?? '',
            "birth_place" => $data['birth_place'] ?? '',

            "blood_group" => $data['blood_group'] ?? '',
            "fulladdress" => $data['fulladdress'] ?? '',
            'issue_date'  => $data['issue_date'] ?? '',
            // extra static (or generated) fields
            "photo"       => $photo ?? '',
            "signature"   => $sign ?? '',
        ];
        $data = json_decode(json_encode($json));
        // dd($data);
        return view('frontend.pages.api.sign_to_smrtPdf', [
            'data' => $data
        ]);
    }
}
