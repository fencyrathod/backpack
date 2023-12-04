<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'jobs';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
//protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

  

   
    public function payment()
    {
        return $this->hasMany(Payment::class,"job_id","id");
    }
    public function payment1(){
        
        if($this->payment()->count() > 0){
            return $this->payment()->sum('amount');
        }else{
            return 'No Payment';
        }
    }

 
    public function check_name()
    {
        $id=$this->Customer_Name; 
        $data=Customer::find($id);
        return $data->Name;
    }
    
    public function check_source()
    {
        if($this->Source==Null)
        {
           
        }
        else
        {
        $id=$this->Source; 
        $data=Source::find($id);
        return $data->name;
        }
     }

    public function check_service()
    {

        if($this->Service_Type==Null)
        {
           
        }
        else
        {
        $id=$this->Service_Type; 
        $data=ServiceType::find($id);
        return $data->name;
        }
    }

    public function check_device()
    {

        if($this->Device_Type==Null)
        {
           
        }
        else
        {
        $id=$this->Device_Type; 
        $data=DeviceType::find($id);
        return $data->name;
        }
    }

    public function check_device_brand()
    {
        if($this->Device_Brand==Null)
        {
           
        }
        else
        {
        $id=$this->Device_Brand; 
        $data=DeviceBrand::find($id);
        return $data->name;
    
        }
    }

    public function check_storage()
    {


        if($this->Storage_Location==Null)
        {
            
        }
        else
        {
        $id=$this->Storage_Location; 
        $data=StorageLocation::find($id);
        return $data->name;
        }
     }


    public function check_service_assessment()
    {
        // $data=strip_tags($this->Service_Assessment);
       $data=$this->Service_Assessment;
       echo strip_tags($data);
    }


    public function check_assignee()
    {


        if($this->Assignee==Null)
        {
           
        }
        else
        {
        $id=$this->Assignee; 
        $data=User::find($id);
        return $data->name;
        }
    }

    public function service_fetch()
    {
        return $this->belongsToMany(Service::class,'job_service','job_id','service_id');
    }
    
   

    public function check_names()
    {
        return $this->belongsTo(Customer::class);
    }
    public function check_sources()
    {
        return $this->belongsTo(Source::class );
    }

    public function check_services()
    {
        return $this->belongsTo(ServiceType::class );
    }

    public function check_devices()
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function check_device_brands()
    {
       
        return $this->belongsTo(DeviceBrand::class);
    }

    public function check_storages()
    {
        return $this->belongsTo(StorageLocation::class );
    }


    public function check_service_assessments()
    {
        // $data=strip_tags($this->Service_Assessment);
       $data=$this->Service_Assessment;
       echo strip_tags($data);
    }


    public function check_assignees()
    {
        return $this->belongsTo(User::class);
    }

    public function check_assigner()
    {
        return $this->belongsTo(User::class,'Assignee');
    }
    
    public function setImageAttribute($value)
    {
        $attribute_name = "Image";
        $disk = "public";
        $destination_path = ""; //relative to $disk
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }



  

  


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
