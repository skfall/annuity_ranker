<?php 
namespace App\Observers;

use App\Models\Project;
use App\Models\Stage;

class ProjectObserver {
	private $stages_by_project = 3;

	public function created(Project $project){
		for($i = 0; $i < $this->stages_by_project; $i++){
			$stage = new Stage();
			$stage->project_id = $project->id;
			$stage->save();
		}
	}
}