<?php
namespace App\Http\Controllers\Post_login\User_Management;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use DB;
use Hash;
use App\Models\M_Dokter;
use App\Models\M_Admin;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $js[] = 'users';

        $data = [
            'js' => $js,
        ];
        return view('post-login-views.user_management.users.users_view', $data);
    }

    public function oldindex(Request $request)
    {
        $users = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function modal_entry($cd, $type){
        
        $disabled   =  "";

        if($cd != '0' and ($type == 'up' or $type == 'dt')){

            $result     = M_Master_Medicine::where("state", "Y")
                          ->where("code_medicine", $cd)->get()->first();
            $data2      = 'Data Update Obat';

            if($type == 'dt'){
                $data2      = 'Data Detail Obat';
                $disabled   =  " disabled ";
            }
            
        }else{
            $data2      = 'Data Entry User';
            $result     = array();
        }

        $unit           = Role::get();

        $data = [
            'result' => $result,
            'cd' => $cd,
            'type' => $type,
            'disabled' => $disabled,
            'unit' => $unit
        ];

        $data1 = preg_replace( "/\r|\n/", "", view('post-login-views.user_management.users.users_modal_entry', $data) );
        
        
        $data3      = 'save-users';

        return json_encode(array($data1, $data2, $data3));
        
    }


    public function store(Request $request)
    {

        $password = Hash::make($request->password); //Hash password
        $cd_user = get_prefix('users');
        $userData = array(
            'code_user' => $cd_user, 
            'username' => $request->username, 
            'email' => $request->email,
            'password' => $password,
        );

        $user = User::create($userData);

        $user->attachRole($request->roles);

        if($request->roles == 3 or $request->roles == 2){
            $details = array(
                'code_docter' => get_prefix('us_docter'), 
                'code_user' => $cd_user, 
                'nik' => $request->nik,
                'nama_dokter' => $request->nama,
                'telepon' => $request->telepon,
                'handphone' => $request->handphone,
                'email' => $request->email,
                'jenis_kelamin' => $request->gender,
            );
            $user = M_Dokter::create($details);
        }else{
            $details = array(
                'code_admin' => get_prefix('us_admin'), 
                'code_user' => $cd_user, 
                'nik' => $request->nik,
                'nama_admin' => $request->nama,
                'telepon' => $request->telepon,
                'handphone' => $request->handphone,
                'email' => $request->email,
                'jenis_kelamin' => $request->gender,
            );

            $user = M_Admin::create($details);
        }
        $data1 = 1;
        $data2 = 'SUKSES! Data User baru berhasil disimpan. silahkan cek kembali data tersebut pada table.';
        return json_encode(array($data1, $data2));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get(); //get all roles
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit',compact('user','roles','userRoles'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'roles' => 'required'
        ]);
        $input = $request->only('name', 'email', 'password');
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']); //update the password
        }else{
            $input = array_except($input,array('password')); //remove password from the input array
        }
        $user = User::find($id);
        $user->update($input); //update the user info
        //delete all roles currently linked to this user
        DB::table('role_user')->where('user_id',$id)->delete();
        //attach the new roles to the user
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
