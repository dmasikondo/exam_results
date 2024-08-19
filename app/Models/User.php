<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'token_expiry' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

   public function staff()
    {
        return $this->hasMany(Staff::class,'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }


    /**
     * Assign user a role
     */

    public function assignRole($role)
    {

        return $this->roles()->save(Role::firstOrCreate(['name' =>$role]));
    }

    /**
      * Check if the user has role of
    */
    public function hasRole($role)
    {
        return  (bool) $this->roles()->where('name',$role)->count();
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'users_id');
    }

    public function userAvatar()
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->second_name, 0, 1));
    }

     public function isStudent()
     {
        return (bool) $this?->results()->where('users_id', $this->id)->count();
     }

     /**
      * check if user belongs to a given department
      */

     public function belongsToDepartmentOf($dept)
     {
        $department = Department::where('name',$dept)->first();
        return (bool)($this?->staff()->where('user_id', $this->id)->where('department_id',$department->id)->count());
     }

   /**
      * filters for searching criteria in accounts dashboard
      */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['department'] ?? false, fn($query, $department) =>
        $query->whereHas('results', fn ($query) =>
            $query->where('discipline', $department)
            )
        );
        //system fees clearance status options
        $query->when($filters['clearance_status'] ?? false, fn($query, $clearance_status) =>
            $query->whereHas('fees', fn($query)=>
                //cleared option is selected
                $query->when($clearance_status=='cleared',fn($query)=>
                    $query->where('is_cleared',1)
                )
                //pending option is selected
                ->when($clearance_status=='pending',fn($query)=>
                    $query->where('is_cleared',0)
                          ->whereNull('clearer_id')
                          ->whereNull('cleared_at')
                )
                //declined option is selected
                ->when($clearance_status=='declined',fn($query)=>
                    $query->where('is_cleared',0)
                          ->whereNull('clearer_id')
                          ->whereNotNull('cleared_at')
                )
            )
        );


        $query->when($filters['second_name'] ?? false, fn($query, $second_name) =>
        $query->has('results')
            ->where('second_name', 'like', '%' . $second_name . '%')

        );
        $query->when($filters['first_name'] ?? false, fn($query, $first_name) =>
        $query->has('results')
            ->where('first_name', 'like', '%' . $first_name . '%')

        );
        $query->when($filters['nat_id'] ?? false, fn($query, $nat_id) =>
        $query->has('results')
            ->where('national_id', 'like', '%' . $nat_id . '%')
        );
        $query->when($filters['exam_session'] ?? false, fn($query, $exam_session) =>
            $query->whereHas('results', fn ($query) =>
            $query->where('intake_id', $exam_session)
            )
        );

    }

    public function scopeFilters($query, array $filters)
    {
        //filter by user's role
        $query->when($filters['role'] ?? false, fn($query, $role) =>
            $query->whereHas('roles', fn ($query) =>
            $query->where('name', $role)
            )
        );

        //filter by user's surname
        $query->when($filters['surname'] ?? false, fn($query, $surname) =>
            $query->where('second_name', 'like', '%' . $surname . '%')
        );

        // filter by user's first name
        $query->when($filters['first_name'] ?? false, fn($query, $first_name) =>
            $query->where('first_name', 'like', '%' . $first_name . '%')
        );

        // filter by user's email
        $query->when($filters['email'] ?? false, fn($query, $email) =>
            $query->where('email', 'like', '%' . $email . '%')
        );

        //filter by Exam Session


    }

}
