<?php



namespace App\Http\Controllers\Backend;
 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB as DB;
use Yajra\DataTables\Facades\DataTables;
use App\Interfaces\UserInterface;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\ProfessionalRequest;
use App\Http\Requests\ProfessionalUpdateRequest;

class UserController extends Controller
{
    protected $userInterface;
	/**
	 * Create a new constructor for this controller
	 */
	public function __construct(UserInterface $userInterface)
	{
		$this->userInterface = $userInterface;
	}
   

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */ 
    
    public function index(Request $request)

    {
       $arrData = array();
	   $users = $this->userInterface->getAllUsersList();
       $arrData['users'] = $users['results'];
       return view('backend.users.list',$arrData);
    } 
    public function create(Request $request){
        $arrData = array();
        $arrData['roles'] = Role::get();
        return view('backend.users.add',$arrData);
    }
    public function store(UserRequest $request)
	{
		$getUserRequest = $this->userInterface->requestNewUser($request);
        if (!empty($getUserRequest) && $getUserRequest['status'] == 200) {
			return redirect(route('admin.users.list'))->with('success', $getUserRequest['msg']);
		}else{
			return redirect()->back()->with('error', 'something wents wrong!');
        }
	}
    public function edit(Request $request,$id){
        $arrData = array();
        $arrData['roles'] = Role::get();
        $getusers = $this->userInterface->getUserById($id);
        if(!empty($getusers['results'])){
            $arrData['getUser'] = $getusers['results'];
        }else{
            return redirect(route('admin.users.list'))->with('error', 'No user with this id');
        }
		
        return view('backend.users.edit',$arrData);
    }
    public function update(UserUpdateRequest  $request,$id){
        $getUserRequest = $this->userInterface->requestNewUser($request,$id);
        if (!empty($getUserRequest) && $getUserRequest['status'] == 200) {
			return redirect(route('admin.users.list'))->with('success', $getUserRequest['msg']);
		}else{
			return redirect()->back()->with('error', 'something wents wrong!');
        }
    }
    public function delete($id)
	{
		$deleteUser = $this->userInterface->deleteUser($id);
		if (!empty($deleteUser) && $deleteUser['status'] == 200) {
			return redirect(route('admin.users.list'))->with('success', $deleteUser['msg']);
		}
	}
    public function statusChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeUser = $this->userInterface->statusChangeUser($request);
			return $statusChangeUser;
		}
	}
    public function professionalist(Request $request)
    {
       $arrData = array();
	   $users = $this->userInterface->getAllUsersProfessionalList();
	   $arrData['users'] = $users['results'];
       return view('backend.professional.list',$arrData);
    }
    public function professionalCreate(Request $request){
        $arrData = array();
        $arrData['roles'] = Role::where('id',4)->get();
        return view('backend.professional.add',$arrData);
    }
    public function professionalStore(ProfessionalRequest $request)
	{
		$getUserRequest = $this->userInterface->requestNewProfessional($request);
        if (!empty($getUserRequest) && $getUserRequest['status'] == 200) {
			return redirect(route('admin.professionalist.list'))->with('success', $getUserRequest['msg']);
		}else{
			return redirect()->back()->with('error', 'something wents wrong!');
        }
	}
    public function professionalEdit(Request $request,$id){
        $arrData = array();
        $arrData['roles'] = Role::where('id',4)->get(); 
        $getusers = $this->userInterface->getUserById($id);
        if(!empty($getusers['results'])){
            $arrData['getUser'] = $getusers['results'];
        }else{
            return redirect(route('admin.professionalist.list'))->with('error', 'No user with this id');
        }
		
        return view('backend.professional.edit',$arrData);
    }
    public function professionalUpdate(ProfessionalUpdateRequest  $request,$id){
        $getUserRequest = $this->userInterface->requestNewProfessional($request,$id);
       if (!empty($getUserRequest) && $getUserRequest['status'] == 200) {
			return redirect(route('admin.professionalist.list'))->with('success', $getUserRequest['msg']);
		}else{
			return redirect()->back()->with('error', 'something wents wrong!');
        }
    }
    public function professionalDelete($id)
	{
		$deleteUser = $this->userInterface->deleteUser($id);
		if (!empty($deleteUser) && $deleteUser['status'] == 200) {
			return redirect(route('admin.professionalist.list'))->with('success', $deleteUser['msg']);
		}
	}
    public function professionalView(Request $request,$id){
        $arrData = array();
        $arrData['roles'] = Role::where('id',4)->get();
        $getusers = $this->userInterface->getUserById($id);
        if(!empty($getusers['results'])){
            $arrData['getUser'] = $getusers['results'];
        }else{
            return redirect(route('admin.professionalist.list'))->with('error', 'No user with this id');
        }
		
        return view('backend.professional.view',$arrData);
    }
	 public function professionalDocumentStatusChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeUserDocument = $this->userInterface->professionalDocumentStatusChange($request);
			return $statusChangeUserDocument;
		}
	}

   
   
}
