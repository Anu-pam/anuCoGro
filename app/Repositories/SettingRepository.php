<?php
namespace App\Repositories;
use App\Interfaces\SettingInterface;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AdminSetting;
use App\Models\ProfessionalWorkingTime;
use App\Http\Helpers\Common;
Class SettingRepository implements SettingInterface
{
    use ResponseAPI;

    public function create(){
  
     $data['timing']= Common::setting('timing');
     $data['range']= Common::setting('range');
     $data['tax']= Common::setting('tax');
     $data['transactionTax']= Common::setting('transactionTax');
     return $data;

    }

    public function store($request){
    
      try{
          $timing = json_encode($request->post('timing'));
          // range
          $range=json_encode($request->post('range'));
           $rangesetting=Common::setting('range');
          if(!empty($rangesetting)){
         
            $setting = Common::setting('range');
            $setting->key = 'range'; 
            $setting->value = $range; 
            $setting->type = 'range';
            $setting->save(); 

            $arrReturn['msg'] ="Setting Update Successfully";
            
            }
          else
          {
          
            $setting = new AdminSetting;
            $setting->key = 'range';
            $setting->type = 'range';
            $setting->value =  $range;
            $setting->save();
            $arrReturn['msg'] ="Setting Save Successfully";
          
          }
  
          // tax
          
          $taxsetting= Common::setting('tax');
          if(!empty($taxsetting)){
         
            $setting =Common::setting('tax');
            $setting->key = 'tax'; 
            $setting->value = $request->tax; 
            $setting->type = 'tax';
            $setting->taxName = $request->taxname;
            $setting->save(); 
            $arrReturn['msg'] ="Setting Update Successfully";
            
            }
          else
          {
          
            $setting = new AdminSetting;
            $setting->key = 'tax';
            $setting->type = 'Tax';
            $setting->value =  $request->tax;
            $setting->taxName = $request->taxname;
            $setting->save();
            $arrReturn['msg'] ="Setting Save Successfully";
          
          }

          // transaction tax
          
          $transactionTaxsetting= Common::setting('transactionTax');
          if(!empty($transactionTaxsetting)){
         
            $setting =Common::setting('transactionTax');
            $setting->key = 'tax'; 
            $setting->value = $request->transactionTax; 
            $setting->type = 'Transaction Tax';
            $setting->save(); 

            $arrReturn['msg'] ="Setting Update Successfully";
            
            }
          else
          {
          
            $setting = new AdminSetting;
            $setting->key = 'transactionTax';
            $setting->type = 'transactionTax';
            $setting->value =  $request->transactionTax;
            $setting->save();
            $arrReturn['msg'] ="Setting Save Successfully";
          
          }
          // timing
          $timesetting= Common::setting('timing');
          if(!empty($timesetting)){
         
            $setting =Common::setting('timing');
            $setting->key = 'timing'; 
            $setting->value = $timing; 
            $setting->type = 'timing';
            $setting->save();  
          
            $arrReturn['msg'] ="Setting Update Successfully";
            
            }
          else
          {
          
            $setting = new AdminSetting;
            $setting->key = 'timing';
            $setting->type = 'timing';
            $setting->value =  $timing;
            $setting->save();
            $arrReturn['msg'] ="Setting Save Successfully";
          
          }
          

          DB::commit();
          $arrReturn['status'] = 200;
          return $arrReturn;

        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }

    }


}
?>