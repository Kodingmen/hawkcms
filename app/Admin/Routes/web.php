<?php
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    $queue = \Illuminate\Support\Facades\Queue::push('LogMessage',array('message'=>'Time: '.time()));
    return $queue;
});
class LogMessage{
    public function fire($job, $date){
        \Illuminate\Support\Facades\File::append(app_path().'/queue.txt',$date['message'].PHP_EOL);
        $job->delete();
    }
}