<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\Culture;
use App\Models\Package;
use App\Models\Service;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Response;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient($patient)
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://46.99.206.7:8091/api/Subject',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 500,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
        "subject": "'.
                $patient['code'].
                '",
        "buyer": "T",
        "supplier": "",
        "name2": "'.
                $patient['name'].
                '",
        "name3": "'.
                $patient['passport_no'].
                '",
        "address": "'.
                $patient['address'].
                '",
        "fieldDA": "'.
                $patient['dob'].
                '",
        "country": "",
        "phone": "'.
                $patient['phone'].
                '",
        "active": "T",
        "fiscalNo": "",
        "post":"",
        "pincodePrefix": "",
        "wayOfSale": "K",
        "rebate": 0,
        "maxRebate": 0
          }',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Basic UEFXUzoxMjNQQVdTMQ=='],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $curl;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patientId($patient)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://46.99.206.7:8091/api/Subject',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => '{
                "subject": "'.
                $patient['code'].
                '",
                "buyer": "T",
                "supplier": "",
                "name2": "'.
                $patient['name'].
                '",
                "address": "'.
                $patient['address'].
                '",
                "country": "",
                "phone": "'.
                $patient['phone'].
                '",
                "active": "T",
                "fiscalNo": "",
                "post":"",
                "pincodePrefix": "",
                "wayOfSale": "K",
                 "rebate": 0,
                 "maxRebate": -1
                }',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Basic UEFXUzoxMjNQQVdTMQ=='],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order($patient, $group, $grouptest)
    {

        $group_tests = [];
        $anNo = 1;
        $rebate = $group['discount'];
        foreach ($group['tests'] as $test) {

            array_push($group_tests,
                [
                    //'ident' => $test['pantheon_id'],
                    'ident' => $test['test']['pantheon_id'],
                    //             'name' => $test['test']['name'],
                    // 'anNo' =>$anNo,
                    'quantity' => 1,
                    // 'price' =>$test['test']['price'],
                    // 'rabate' =>$rebate,
                    // 'vat' =>0,
                    // 'vatCode' =>'B0'
                    // 'note' =>""
                ]
            );
            $anNo++;
        }

        $group_cultures = [];
        foreach ($group['cultures'] as $culture) {
            array_push($group_cultures,
                [
                    'ident' => $culture['culture']['pantheon_id'],
                    'quantity' => 1,
                ]
            );
        }

        $group_package = [];
        foreach ($group['packages'] as $package) {
            array_push($group_package,
                [
                    'ident' => $package['package']['pantheon_id'],
                    'quantity' => 1,
                ]
            );
        }
        $group_service = [];
        foreach ($group['services'] as $service) {
            array_push($group_service,
                [
                    'ident' => $service['service']['pantheon_id'],
                    'quantity' => 1,
                ]
            );
        }

        $artikujtReq = array_merge($group_tests, $group_cultures, $group_package, $group_service);
        $newDate = $group->created_at->format('Y-m-d');
        $params = [
            // 		'receiverId' => $group['contract']['pantheon_bp'],
            'receiverId' => isset($group['contract']['pantheon_bp']) ? $group['contract']['pantheon_bp'] : 'BP-00',
            'thirdPartyId' => $patient['code'],
            'issuerId' => 'Depo e Shitjes',
            'status' => 'N',
            'docType' => $group['pos'],
            'date' => $newDate,
            'dateDue' => $newDate,
            'invoiceDate' => $newDate,
            'taxDate' => $newDate,
            'expectedDeliveryDate' => $newDate,
            'orderDate' => $newDate,
            'orderFormDate' => $newDate,
            'invoiceItems' => $artikujtReq,
        ];

        $ch = curl_init('http://46.99.206.7:8091/api/Move/insert');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params)); //Post Fiel
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization: Basic UEFXUzoxMjNQQVdTMQ==']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //new
        $response_json = json_decode($response, true);
        $items_create_response = $response_json['itemsCreateResponse'];
        $success = true; // assume success unless we find a status other than 'T'

        foreach ($items_create_response as $item) {
            $status = $item['status'];
            if ($status !== 'T') {
                $success = false;
                // do something with the item that has status not equal to T
                echo 'Status: '.$status."\n";
            }
        }

        if ($success) {
            $group->API = 1;
            $group->save();
            session()->flash('success', __('Transfer successfully'));
        } elseif ($http_status != 200) {
            $group->API = 0;
            $group->save();
            session()->flash('failed', __('Sorry,unable to complete the transfer at this time'));
        } else {
            $group->API = 1;
            $group->save();
            session()->flash('failed', __('Sorry, one of the items failed to transfer'));
        }
        curl_close($ch);
        // dd($response,$artikujtReq,$params);
    }

    public function updatePricesAPI()
    {
        $url = 'http://46.99.206.7:8091/api/Ident/retrieve';
        $payload = [
            'start' => 0,
            'length' => 0,
            'fieldsToReturn' => 'items.acIdent, items.acName, items.anSalePrice',
            'tableFKs' => [
                [
                    'table' => 'tHE_SetItemType',
                    'join' => 'AcSetOfItemNavigation.acSetOfItem = items.acSetOfItem',
                    'alias' => 'AcSetOfItemNavigation',
                    'fieldsToReturn' => 'acSetOfItem, acType, acName',
                ],
            ],
            'customConditions' => [
                'condition' => ' items.acIdent like @param1',
                'params' => ['4%'],
            ],
            'sortColumn' => '',
            'sortOrder' => '',
            'WithSubSelects' => 1,
            'tempTables' => [],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic UEFXUzoxMjNQQVdTMQ==',
        ])->post($url, $payload);

        if ($response->successful()) {
            $data = $response->json();

            // Directly iterate over the $data array
            // Iterate over the $data array and update each model
            foreach ($data as $item) {
                // Update Test with parent_id condition
                $tests = Test::where('pantheon_id', $item['acIdent'])
                    ->where('parent_id', 0)
                    ->get();
                foreach ($tests as $test) {
                    $test->update(['price' => $item['anSalePrice']]);
                }

                // Models without parent_id condition
                $models = [Culture::class, Service::class, Package::class];
                foreach ($models as $model) {
                    $records = $model::where('pantheon_id', $item['acIdent'])
                        ->get();
                    foreach ($records as $record) {
                        $record->update(['price' => $item['anSalePrice']]);
                    }
                }
            }

            return response()->json(['message' => 'Prices updated successfully.']);
        } else {
            // Handle failed response
            return response()->json(['message' => 'Failed to retrieve data from API.', 'error' => $response->body()], 500);
        }

    }

    // public function retrieveSubjects(Request $request)
    // {
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Basic UEFXUzoxMjNQQVdTMQ==',
    //     ])->post('http://46.99.206.7:8091/api/Subject/retrieve', [
    //         "start" => 0,
    //         "length" => 0,
    //         "fieldsToReturn" => "subjects.acSubject, subjects.acName2, subjects.acAddress, subjects.acCountry",
    //         "tableFKs" => [
    //             [
    //                 "table" => "vHE_SetSubjPriceItemExt",
    //                 "join" => "cmimetEKontraktuara.acSubject=subjects.acSubject",
    //                 "alias" => "cmimetEKontraktuara",
    //                 "fieldsToReturn" => "cmimetEKontraktuara.acSubject, cmimetEKontraktuara.acIdent, cmimetEKontraktuara.anPrice, cmimetEKontraktuara.anSalePrice, cmimetEKontraktuara.anRebate, cmimetEKontraktuara.ItemName"
    //             ]
    //         ],
    //         "customConditions" => [
    //             "condition" => "subjects.acSubject like @param1",
    //             "params" => ["%BPJ - SPITALI FATI IM%"]
    //         ],
    //         "WithSubSelects" => 1,
    //         "tempTables" => []
    //     ]);

    //     if ($response->successful()) {
    //         $subjects = $response->json();

    //         foreach ($subjects as $item) {
    //             // Attempt to find a contract for the current subject
    //             $contract = Contract::where('pantheon_bp', $item['acSubject'])->first();

    //             if (!$contract) {
    //                 Log::warning("No contract found for {$item['acSubject']}");
    //                 continue; // Move to the next subject if no contract is found
    //             }

    //             // Iterate through the prices related to the current subject
    //             foreach ($item['cmimetEKontraktuara'] as $priceItem) {
    //                 // Attempt to find all entities for the current price item
    //                 $entities = [
    //                     'Test' => Test::where('pantheon_id', $priceItem['acIdent'])->get(),
    //                     'Culture' => Culture::where('pantheon_id', $priceItem['acIdent'])->get(),
    //                     'Service' => Service::where('pantheon_id', $priceItem['acIdent'])->get(),
    //                     'Package' => Package::where('pantheon_id', $priceItem['acIdent'])->get(),
    //                 ];

    //                 foreach ($entities as $type => $records) {
    //                     if ($records->isEmpty()) {
    //                         Log::warning("No {$type} found for {$priceItem['acIdent']}");
    //                         continue; // Move to the next price item if no entity is found
    //                     }
    //                     dd($entities);

    //                     foreach ($records as $record) {
    //                         // Attempt to find an existing contract price for the current contract and entity
    //                         $contractPrice = ContractPrice::where([
    //                             ['contract_id', $contract->id],
    //                             ['priceable_id', $record->id],
    //                             ['priceable_type', "App\Models\\{$type}"],
    //                         ])->first();

    //                         if ($contractPrice) {

    //                             // If a contract price exists, update it with the new price
    //                             $contractPrice->update(['price' => $priceItem['anPrice']]);
    //                             return response()->json(['message' => 'Prices updated successfully.']);
    //                         } else {
    //                             // Log a message if no contract price is found for updating
    //                             Log::info("No ContractPrice found for contract {$contract->id} and {$type} {$record->id}, skipping update.");
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    // }

    public function retrieveSubjects(Request $request)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic UEFXUzoxMjNQQVdTMQ==',
        ])->post('http://46.99.206.7:8091/api/DBObjects/selecttables', [
            'start' => 0,
            'length' => 0,
            'fieldsToReturn' => 'cmimetEKontraktuara.acSubject,cmimetEKontraktuara.acIdent,cmimetEKontraktuara.anPrice,cmimetEKontraktuara.anSalePrice,cmimetEKontraktuara.anRebate,cmimetEKontraktuara.ItemName',
            'tableFKs' => [
                [
                    'table' => 'the_setsubj',
                    'join' => 'cmimetEKontraktuara.acSubject=subjects.acSubject',
                    'alias' => 'subjects',
                    'fieldsToReturn' => 'subjects.acName2, subjects.acAddress, subjects.acCountry,subjects.adTimeChg',
                ],
            ],
            'customConditions' => [
                'condition' => '', // Custom conditions left empty as per your specification
                'params' => [],
            ],
            'sortColumn' => '', // Sorting parameters left blank as per your specification
            'sortOrder' => '',
            'WithSubSelects' => 0,
            'masterTable' => [
                'table' => 'vHE_SetSubjPriceItemExt',
                'alias' => 'cmimetEKontraktuara',
            ],
            'tempTables' => [],
        ]);

        if ($response->successful()) {
            $priceItems = $response->json();

            foreach ($priceItems as $item) {
                // Attempt to find a contract for the current subject
                $contract = Contract::where('pantheon_bp', $item['acSubject'])->first();

                if (! $contract) {
                    continue; // Move to the next subject if no contract is found
                }

                // Initialize a variable to track if any updates are made
                $updatesMade = false;

                // Check if adTimeChg from response is not equal to Contract adTimeChg
                if ($contract->adTimeChg != $item['adTimeChg']) {
                    $entities = [
                        'Test' => Test::where('pantheon_id', $item['acIdent'])->get(),
                        'Culture' => Culture::where('pantheon_id', $item['acIdent'])->get(),
                        'Service' => Service::where('pantheon_id', $item['acIdent'])->get(),
                        'Package' => Package::where('pantheon_id', $item['acIdent'])->get(),
                    ];

                    foreach ($entities as $type => $records) {
                        if ($records->isEmpty()) {
                            continue; // Skip to the next set of entities if no entity is found
                        }

                        foreach ($records as $record) {
                            $contractPrice = ContractPrice::where([
                                ['contract_id', $contract->id],
                                ['priceable_id', $record->id],
                                ['priceable_type', "App\Models\\{$type}"],
                            ])->first();

                            if ($contractPrice) {
                                // If a contract price exists, update it with the new price
                                $contractPrice->update(['price' => $item['anPrice']]);
                                $updatesMade = true; // Mark that an update has been made
                            }
                        }
                    }

                    // If any updates were made, update the contract's adTimeChg to match the new value
                    if ($updatesMade) {
                        $contract->update(['adTimeChg' => $item['adTimeChg']]);
                    }
                }
            }

            return response()->json(['message' => 'Prices updated successfully for all eligible entities.']);
        } else {
            return response()->json(['error' => 'Failed to retrieve subjects from the external API'], 500);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
