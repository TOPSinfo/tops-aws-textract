<?php

namespace App\Http\Controllers;
use Aws\Textract\TextractClient;

use Illuminate\Http\Request;

class AnalyzeDocumentController extends Controller
{
    public function create(){
        return view('textract.create');
    }


    public function store(Request $request){
        $validatedData = $request->validate([
            'document' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $name = $request->file('document')->getClientOriginalName();
        $path = $request->file('document')->move('public');
        
        

        $textractClient = new TextractClient([
            'version' => 'latest',
            'region' => config('services.textract.region'),
            'credentials' => [
                'key'    => config('services.textract.key'),
                'secret' => config('services.textract.secret')
            ]
        ]);
        
        try {
            $result = $textractClient->AnalyzeID([
                'DocumentPages' => [
                    [
                        'Bytes' => file_get_contents($path),
                        
                    ],
                ]
            ]);

            $IdentityDocuments = $result->get('IdentityDocuments');
            echo "<table>";
            foreach ($IdentityDocuments as $document) {

                foreach ($document['IdentityDocumentFields'] as $key => $field) {
                    echo "<tr>";
                    echo "<td>" . $field['Type']['Text'].": </td><td><strong>".$field['ValueDetection']['Text']."</strong></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } catch (Aws\Textract\Exception\TextractException $e) {
            // output error message if fails
            echo $e->getMessage();
        }
    }
}
