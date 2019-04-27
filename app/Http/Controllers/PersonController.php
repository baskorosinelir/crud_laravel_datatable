<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Person;


class PersonController extends Controller
{
    

    public function index()
    {
    	 return view('person');;
    }

    public function ajax_list(Request $r)
	{
		$data=Person::datatable($r);
	
		for ($i=0; $i <count($data) ; $i++) { 
			$data[$i]->no=$i+1+$r->start;
			
		}
		
		$output = array(
						"draw" => $r->draw,
						"recordsTotal" => Person::count(),
						"recordsFiltered" => Person::count_filter($r),
						"data" => $data,
				);
		return json_encode($output);
	}

	public function add(request $r)
	{
		Person::create([
			'name'=>$r->name,
			'address'=>$r->address,
			'email'=>$r->email
		]);

		return json_encode(["status" => TRUE]);
	}

	public function ajax_edit($id)
	{
		$person=Person::find($id);

		return json_encode($person);
	}

	public function ajax_update(request $r)
	{


		$data = Person::find($r->id);
		$data->name=$r->name;
		$data->address=$r->address;
		$data->email=$r->email;
		$data->save();

		return json_encode(["status" => TRUE]);
	}

	public function ajax_delete($id)
	{
		Person::find($id)->delete();
		return json_encode(["status" => TRUE]);
	}
}
