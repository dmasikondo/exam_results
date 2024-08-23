<?php

namespace App;

trait RedirectRouteTrait
{
    public function redirectToRoute()
    {
        if(auth()->user()->must_reset) {
            return 'account-activate';
        }
        if(auth()->user()->hasRole('superadmin') || (auth()->user()->belongsTodepartmentOf('IT Unit') && auth()->user()->hasRole('hod'))){
           return 'users';
        }
        elseif (auth()->user()->isStudent()){
            return 'myresults';
        }
        else{
        return 'dashboard';
        }
    }
}
