<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Node\Inline\Newline;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateStaffUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staff:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new staff user';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $role = Role::pluck('name')->all();
        $department = Department::pluck('name')->all();
        $user = [];

        $this->info('=== WELCOME TO THE CREATION OF STAFF USERS ===');
        $this->newLine(2);

        // Define the total steps for the progress bar
        $totalSteps = 6;

        $progressBar = $this->output->createProgressBar($totalSteps);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');
        $progressBar->setMessage('Initializing...');

        $progressBar->start();

        $user = $this->getUserInput($role, $department, $progressBar, $totalSteps);

        $progressBar->finish();

        // Proceed to show in a table entered data once valid data is supplied
        $this->info('Here are the details that you provided:');
        $headers = ['Field', 'Value'];
        $data = [];

        foreach ($user as $key => $value) {
            if ($key !== 'password' && $key !=='password_confirmation') {
                $data[] = [$key, $value];
            }
        }

        $this->table($headers, $data);

        //confirm the details in the table are correct
        $this->newLine();
        if ($this->confirm('Do you want to proceed to register the Staff User?')) {
            $userName = $user['first_name'] . ' ' . $user['last_name'] ;

        //create user
        $slug = $user['last_name'].uniqid();
        $createdUser= User::create([
            'slug' =>$slug,
            'second_name' =>$user['last_name'],
            'first_name' =>$user['first_name'],
            'email' => $user['email'],
            'must_reset'=>true,
            'password' => Hash::make($user['password']),
        ]);

        $department_id = Department::where('name',$user['department'])->pluck('id')->first();

        $createdUser->staff()->create(['user_id'=>$createdUser->id,'department_id'=>$department_id]);
        $createdUser->assignRole($user['role']);
        $this->info('Staff User: ' . $userName . ', created successfully!');

        }
        else{
            // Abort the mission if not confirmed
            $this->error('You aborted the Staff User creation ');
            return;
        }
    }

    protected function getUserInput($roles, $departments, $progressBar, $totalSteps)
    {
        $user = [];
        $validator = null;

        do {
            $this->newLine();
            $user['last_name'] = $this->ask('Surname of the Member of Staff');
            $progressBar->setProgress(1);
            $this->newLine();

            $user['first_name'] = $this->ask('First Name(s) of the Member of Staff');
            $progressBar->setProgress(2);
            $this->newLine();

            $user['department'] = $this->choice('Select the department of the staff member', $departments);
            $progressBar->setProgress(3);
            $this->newLine();

            $user['role'] = $this->choice('Select the role of the staff member', $roles);
            $progressBar->setProgress(4);
            $this->newLine();

            $user['email'] = $this->ask('Email of the Member of Staff');
            $progressBar->setProgress(5);
            $this->newLine();

            $user['password'] = $this->secret('Enter the default password --NB: cursor not blinking');
            $user['password_confirmation'] = $this->secret('Confirm the default password');
            $progressBar->setProgress(6);
            $this->newLine();

            $validator = Validator::make($user, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:255'],
                'department' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first() . PHP_EOL . ' YOU NEED TO RE-ENTER ALL THE VALUES AFRESH';
                $this->error('Validation failed: ' . $errorMessage);

            }
        } while ($validator->fails());

        return $user;
    }

}
