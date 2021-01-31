<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\File;
 
class FileUploadController extends Controller
{
    /**
     * This is use to select the file from page
     *
     */
    public function index()
    {
        return view('file-upload');
    }
 
    /**
     * This is use to 
     *
     * a. If the file is not PDF, return 422 error.
     * b. If the file doesn't contain the word "Proposal", just ignore the PDF.
     * c. If it's a PDF file, check if we already have the file with the same name and
     *    size (the `name` and `size` columns in our DB table). If we have it, we'll 
     *    need to update the existing one instead of creating a new record for the  
     *    file.
     *
     */
    public function store(Request $request)
    {      
        if(empty($request->file('file'))){
            return redirect('file-upload')->with('status', 'Please select a file for upload');
        } else {
              
            $fileName = strtolower($request->file('file')->getClientOriginalName()); 
            $fileSize = $request->file('file')->getSize();
            $filePath = '/public/files/' . $fileName;            
            $tmpName = $_FILES['file']['tmp_name'];           
            $fileType = $_FILES['file']['type'];

            $data  = File::where('name', $fileName)->where('size', $fileSize)->get();

            if($fileType != 'application/pdf'){
                return redirect('file-upload')->with('status', 'Selected file should be PDF only');
            } else {
                // Insert new file data if same file name & same size 
                // are not available into database
                if($data->count() == 0){
                    $pos = strpos($fileName, 'proposal');
                    if ($pos === false) {
                        return redirect('file-upload')->with('status', '422 Error');
                    } else {                        
                            // Upload the PDF file
                            $uploads_dir = public_path()."/files/".$fileName;
                            move_uploaded_file($tmpName, $uploads_dir);

                            // Save PDF file data into database
                            $save = new File;
                            $save->name = $fileName;
                            $save->path = $filePath;
                            $save->size = $fileSize;
                            $save->save();

                            return redirect('file-upload')->with('status', 'Proposal file has been uploaded successfully');
                    }

                } else {
                    return redirect('file-upload')->with('status', 'Same filename & size already stored');
                }
            }
     
            
        }
 

    }
}
