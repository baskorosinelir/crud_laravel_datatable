<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;


class Person extends Model
{
    protected $table = "persons";
    protected $fillable = ['name','address','email'];
	use SoftDeletes;
	
    static function datatable_query($param)
     {

     	 $column_order = [null,'name','email','address',null];
		 $column_search = ['name','email','address'];
		 $order = array('name' => 'asc');
     	$q=DB::table('persons');

     	$i = 0;
	
		foreach ($column_search as $item) // loop column 
		{
			if($param->search['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					// $q->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$q->where($item,'LIKE', "%{$param->search['value']}%");
				}
				else
				{
					$q->orWhere($item,'LIKE', "%{$param->search['value']}%");
				}

				// if(count($this->column_search) - 1 == $i) //last loop
				// 	$q->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($param->order)) // here order processing
		{
			$q->orderBy($column_order[$param->order['0']['column']], $param->order['0']['dir']);
		} 
		else if(isset($order))
		{
			// $order = $this->order;
			$q->orderBy(key($order), $order[key($order)]);
		}
		$q->where('deleted_at', null);

     	return $q;
     }

     static function datatable($param)
     {
     	
     	$query=self::datatable_query($param);

     	if($param->length != -1)
		$query->limit($param->length)->offset($param->start);
		

		return $query->get();
     }

     static function count_filter($param)
     {
     	$query=self::datatable_query($param);

     	return $query->count();
     }
}
