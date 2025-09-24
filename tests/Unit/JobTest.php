<?php

use App\Models\Employer;
use App\Models\Job;

it('belongs to an employer', function () {
    //AAA
    //arranging the world ->create the world in order to run your test 
      $employer = Employer::factory()->create();
      $job = Job::factory()->create([
        'employer_id'=>$employer->id,
      ]);

    //act ->perform some kind of action 
    //act & assert
    expect($job->employer->is($employer))->toBeTrue();
    //assert ->what did you expect to happen as a result of that assertion
});

it('can have tags',function(){
$job = Job::factory()->create();
$job->tag('frontend');
expect($job->tags)->toHaveCount(1);

});
