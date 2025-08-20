<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        if ($request->ajax()) {
            $query = Student::get();

            return response()->json([
                'status' => true,
                'message' => "Student List",
                'data' => $query,
            ], 200);
        }

        return view('students.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateStudent = Validator::make([

            'name' => 'required|max:255',
            'f_name' => 'required',
            'gender' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,gif',
        ]);

        if ($validateStudent->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation Error",
                'errors' => $validateStudent->errors()->all(),
            ], 401);
        }

        $img = $request->image;
        $ext = $img->getClientOriginalExtenstion();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads', $imageName);

        $student = Student::create([
            'name' => $request->name,
            'f_name' => $request->f_name,
            'gender' => $request->gender,
            'image' => $imageName,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Student Created Successfully",
            'student' => $student,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::select('id', 'name', 'f_name', 'gender', 'image')
            ->where(['id' => $id])->get();

        return response()->json([
            'status' => true,
            'message' => "Student Single Record",
            'student' => $student,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { {
            $validateStudent = Validator::make([
                'name' => 'required|max:255',
                'f_name' => 'required',
                'gender' => 'required',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            ]);

            if ($validateStudent->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation Error",
                    'errors' => $validateStudent->errors()->all(),
                ], 401);
            }

            $studentImage = Student::select('id', 'image')
                ->where(['id' => $id])->get();

            if ($request->image != '') {
                $path = public_path() . '/uploads/';

                if ($studentImage[0]->image != '' && $studentImage[0]->image != null) {
                    $old_file = $path . $studentImage[0]->image;
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }

                $img = $request->image;
                $ext = $img->getClientOriginalExtenstion();
                $imageName = time() . '.' . $ext;
                $img->move(public_path() . '/uploads', $imageName);
            } else {
                $imageName = $studentImage[0]->image;
            }



            $student = Student::where(['id' => $id])->update([
                'name' => $request->name,
                'f_name' => $request->f_name,
                'gender' => $request->gender,
                'image' => $imageName,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Student Updated Successfully",
                'student' => $student,
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $imagePath = Student::select('image')->where('id', $id)->get();
        $filePath = public_path() . '/uploads/' . $imagePath[0]['image'];
        unlink($filePath);


        $student = Student::where(['id' => $id])->delete();

        return response()->json([
            'status' => true,
            'message' => "Student Deleted Successfully",
            'student' => $student,
        ], 200);
    }
}
