<?php

class Household extends Eloquent{
	protected $fillable=array('number','HHHname','size','HHHdob','HHage','Comments');
	protected $table='household';
	public $timestamps=false;
}