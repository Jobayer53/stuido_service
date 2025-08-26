<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function server_copy()
    {
        $server_copy = Service::find(47);
        return view('frontend.pages.api.server_copy', [
            'server_copy' => $server_copy
        ]);
    }
    public function server_copy_download(Request $request)
    {
        // $json = ' {
        //        "Owner": "unique-seba.com",
        // "nameBangla": "উইন আগস্টিন কস্তা",
        // "nameEnglish": "WIN AUGUSTIN COSTA",
        // "nationalId": "7355243812",
        // "dateOfBirth": "11 Nov 1999",
        // "pin": "19996547017004686",
        // "gender": "male",
        // "religion": "Christian",
        // "occupation": "ছাত্র/ছাত্রী",
        // "bloodGroup": "O+",
        // "fatherName": "উইলিয়াম অসীম কস্তা",
        // "nidFather": "19642699039579191",
        // "motherName": "স্বর্ন ক্লারা কস্তা",
        // "nidMother": "19702698880375563",
        // "spouseName": "",
        // "spouseNameEn": "",
        // "birthPlace": "ঢাকা",
        // "voterNo": "609317253514",
        // "voterArea": "তেজগাঁও উপজেলা আওতাধীন",
        // "voterAreaCode": "971443",
        // "slNo": "993",
        // "mobile": "",
        // "presentHomeOrHoldingNo": "৬",
        // "presentAdditionalVillageOrRoad": "তেজকুনি পাড়া",
        // "presentMouzaOrMoholla": "",
        // "presentAdditionalMouzaOrMoholla": "-",
        // "presentUnionOrWard": "ওয়ার্ড নং-২৬",
        // "presentWardForUnionPorishod": 0,
        // "presentPostOffice": "তেজগাঁও টি এস ও",
        // "presentPostalCode": "১২১৫",
        // "presentCityCorporationOrMunicipality": "ঢাকা উত্তর সিটি কর্পোরেশন",
        // "presentUpozila": "তেজগাঁও",
        // "presentRmo": "9",
        // "presentDistrict": "ঢাকা",
        // "presentDivision": "ঢাকা",
        // "presentRegion": "ঢাকা",
        // "permanentHomeOrHoldingNo": "৬",
        // "permanentAdditionalVillageOrRoad": "তেজকুনি পাড়া",
        // "permanentMouzaOrMoholla": "",
        // "permanentAdditionalMouzaOrMoholla": "-",
        // "permanentUnionOrWard": "ওয়ার্ড নং-২৬",
        // "permanentWardForUnionPorishod": "",
        // "permanentPostOffice": "তেজগাঁও টি এস ও",
        // "permanentPostalCode": "১২১৫",
        // "permanentCityCorporationOrMunicipality": "",
        // "permanentUpozila": "তেজগাঁও",
        // "permanentRmo": "9",
        // "permanentDistrict": "ঢাকা",
        // "permanentDivision": "ঢাকা",
        // "permanentRegion": "ঢাকা",
        // "photo": "https://unique-seba.com/loadedImages/photos/photo_7355243812_1753259052_76e55bc4.jpg",
        // "sign": "https://unique-seba.com/loadedImages/signs/sign_7355243812_1753259052_68809c2c4ee9a.png",
        // "preAddress": {
        //     "addressLine": "বাসা/হোল্ডিং: ৬, গ্রাম/রাস্তা: তেজকুনি পাড়া, মৌজা/মহল্লা: , ইউনিয়ন ওয়ার্ড: ওয়ার্ড নং-২৬, ডাকঘর: তেজগাঁও টি এস ও - ১২১৫, পৌরসভা: ঢাকা উত্তর সিটি কর্পোরেশন, উপজেলা: তেজগাঁও, জেলা: ঢাকা, বিভাগ: ঢাকা"
        // },
        // "perAddress": {
        //     "addressLine": "বাসা/হোল্ডিং: ৬, গ্রাম/রাস্তা: তেজকুনি পাড়া, মৌজা/মহল্লা: , ইউনিয়ন ওয়ার্ড: ওয়ার্ড নং-২৬, ডাকঘর: তেজগাঁও টি এস ও - ১২১৫, পৌরসভা: , উপজেলা: তেজগাঁও, জেলা: ঢাকা, বিভাগ: ঢাকা"
        // },
        // "Developer": "Software Engineer [Arif]",
        // "System": "SERVER COPY API - PER REQUEST TOKEN/CREDIT SYSTEM",
        // "Contact With Me Telegram": "https://t.me/onlineweb500",
        // "Contact With Me WhatsApp": "https://wa.me/447727748765",
        // "Join Our Telegram Channel Group": "https://t.me/online700800",
        // "Join Our WhatsApp Community Group": "https://chat.whatsapp.com/HgLgbKGPVq3390EfefVDV5"
        // } ';
        //   $server_copy = Service::find(47);
        // $user = auth()->user();

        // if ($user->amount < $server_copy->cost) {
        //     notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
        //     return back();
        // }

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
        $nid = $request->nid;
        $dob = $request->dob;
        $apiKey = '88d9f1afa2b45a1b39ab118d3d530600';
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

        return view('frontend.pages.api.server_copyPdf', [
            'data' => $data
        ]);
        // $server_copy = Service::find(47);
        // $user = auth()->user();
        // if ($user->amount < $server_copy->cost) {
        //     notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
        //     return back();
        // }

        // $nid = $request->nid;
        // $dob = $request->dob;

        // $url = "https://no.eservice24.top/info.php?nationalId=$nid&dob=$dob&key=A200";
        // $fileContent = file_get_contents($url);
        // dd($fileContent);
        // if(empty($fileContent)){
        //     notyf()->position('x', 'right')->position('y', 'top')->error('আপনার নিবন্ধন নম্বর সঠিক নয়।');
        //     return back();
        // }
        // $fileName = "nid_{$nid}.pdf";
        // $filePath = public_path('upload/' . $fileName);

        // // Save file
        // file_put_contents($filePath, $fileContent);
        // // $response = file_get_contents($url);
        // return $fileContent;
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
        $pdfPath = $request->file->getPathname();
        $pdfName = $request->file->getClientOriginalName();
        //https://tin.eservice24.top/tin.php?tin=376803390198
        $response = Http::attach(
            'pdf',
            file_get_contents($pdfPath),
            $pdfName
        )->post('https://unique-seba.com/api/tin2', [
            'api_key' => 'd277dd806869ce24023466deff9aef6b'
        ]);
        if ($response->successful()) {
            return response()->json($response->json());
        }
        return response()->json([
            'error' => true,
            'message' => 'TIN API request failed',
            'details' => $response->body()
        ], $response->status());
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
            $order->save();
            $user->amount = $user->amount - $order->cost;
            $user->save();

            return response()->json(['status' => 'success', 'data' => $data, 'slug' => $order->slug], 200);
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
        $url = "https://unique-seba.com/api/autobirth2?api_key=7450ba623c2a0fd7293fa2730f2bc29f&brn=$brn&dob=$dob";
        $apiKey = '7450ba623c2a0fd7293fa2730f2bc29f';
        $url = "https://unique-seba.com/api/autobirth2";

        try {
            $response = Http::get($url, [
                'api_key' => $apiKey,
                'brn'     => $brn,
                'dob'     => $dob,
            ]);

            $data = json_decode($response->body(), true);

            // API error check
            if (isset($data['error'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['error']
                ], 400);
            }

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
            $order->save();
            $user->amount = $user->amount - $order->cost;
            $user->save();
            // $data = json_decode($response->body());
            return response()->json([
                'status' => 'success',
                'data'   => $data,
                'slug'   => $order->slug
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
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
//          return response()->json(['status' => 'success', 'data' => $data], 200);

    }
    public function autoBc_download(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $order = Order::where('slug', $request->slug)->first();
        if ($order == null || $order->user_id != $user->id) {
            notyf()->position('x', 'right')->position('y', 'top')->error('অর্ডার পাওয়া যায়নি।');
            return back();
        }
        if($order->type_number != $request->brn){
            notyf()->position('x', 'right')->position('y', 'top')->error('অর্ডার পাওয়া যায়নি।');
            return back();
        }
        return view('frontend.pages.api.auto_bcPdf', [
            'data' => $data
        ]);
    }
}
