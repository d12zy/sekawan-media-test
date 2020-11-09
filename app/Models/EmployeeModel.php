<?php 
  namespace App\Models;
  use CodeIgniter\Model;

  class EmployeeModel extends Model{
    protected $table = 'tb_employee';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true; 

    protected $allowedFields = ['employee_name', 'employee_salary', 'employee_age', 'profile_picture'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updateField = 'update_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
      'employee_name' => 'required|min_length[3]',
      'employee_salary' => 'required',
      'employee_age' => 'required',
      'profile_picture' => 'required',
    ];

    protected $validationMessages = [
      'employee_name' => [
        'required' => 'Bagian Name Harus Diisi',
        'min_length' => 'Minimal 3 karakter'
      ],
      'employee_salary' => [
        'required' => 'Bagian employee_ Harus Diisi',
      ],
      'employee_age' => [
        'required' => 'Bagian employee_ Harus Diisi',
      ],
      'profile_picture' => [
        'required' => 'Bagian Price Harus Diisi',
      ],
      ];
      protected $skipValidation = false;

      public function getData(){
        return 'Helloo World';
      }

      public function getEmployees()
      {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM tb_employee ORDER BY employee_age ASC');
        $res = $query->getResultArray();
        return $res;
      }
  }