<?php 

namespace App\Service;

class Paginator {

	private $filters;
	private $current;
	private $last;
	private $path = '';

	public function __construct($total,$filters = [],$limit = 100){
		$this->filters = $filters;
		$this->current = $filters['page'];#( ($filters['page']?:1) - 1) * $limit;
		$this->last = ceil( $total / $limit );
	}

	// filters
	public function getFilters(){
		return $this->filters;
	}

	// page
	public function getCurrent(){
		return $this->current;
	}

	// last
	public function getLast(){
		return $this->last;
	}

	// path
	public function setPath($path){
		$this->path = $path;
	}
	public function getPath(){
		return $this->path;
	}

	// return
	public function generate(){
		return [
			'filters' => $this->getFilters(),
			'current' => $this->getCurrent(),
			'last' => $this->getLast(),
			'path' => $this->getPath()
		];
	}

}