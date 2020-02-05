<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel ,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'std_id' => $row['StudentId'],
            'std_name'=> $row['StudentName'],
            'major' => $row['Major'],
            'email' => $row['Email'],
            'tel' => $row['Phone'],
            'password' => Hash::make($row['Password'])
        ]);
    }
}
