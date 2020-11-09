<?php

namespace App\Controllers;
 
use App\Models\EmployeeModel;
use CodeIgniter\API\ResponseTrait;
 
class Employee extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $employee = new EmployeeModel();
        $data =  $employee->getEmployees();
        return view('welcome_message',compact('data'));
    }

    public function insertData()
    {
      $employee = new EmployeeModel();
      if ($file = $this->request->getFile('profile_picture')) {
        // Generate a new secure name
        $name = $file->getRandomName();
        // Move the file
        $ext =  $file->getExtension();
        $file->move('images/', $name);
        $insert = $employee->insert([
          'employee_name' => $this->request->getPost('employee_name'),
          'employee_salary' => $this->request->getPost('employee_salary'),
          'employee_age' => $this->request->getPost('employee_age'),
          'profile_picture' => $name,
        ]);
      }
      return $this->respondCreated($employee);
    }
}