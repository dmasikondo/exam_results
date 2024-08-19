<div class="p-4 mx-auto bg-white rounded-md shadow-md w-7/10">
      <div class="flex justify-end gap-1 mb-3 text-indigo-600">
{{-- records per page --}}
        <form action="/users" method="get">
          <span class="text-xs text-indigo-600">No. of recods per page</span>
          <select  id="perPage" name="perPage" placeholder="Records Per Page" title="Records per page"
            class="h-6 p-1 text-xs border-1 focus:border-1" onchange="this.form.submit()">
            <option value="" class="hover:bg-indigo-100">20</option>
            <option value="10" {{request('perPage')== 10? 'selected':''}} >10</option>
            <option value="20" {{request('perPage')== 20? 'selected':''}} >20</option>
            <option value="50" {{request('perPage')== 50? 'selected':''}} >50</option>
            <option value="80" {{request('perPage')== 80? 'selected':''}} >80</option>
            <option value="100" {{request('perPage')== 100? 'selected':''}}>100</option>
          </select>
        </form>
{{-- ./records per page --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <span class="mt-2 text-xs text-indigo-600">Search for the user using different criteria</span>
      </div>
    <form action="/users">
      <div class="flex flex-col gap-2 space-y-4 lg:flex-row center">
        <div class="relative flex-1 mt-4">
          <select  id="role" name="role" placeholder="Select a User Role" title="Role">
            <option value="" class="hover:bg-indigo-100">All: Roles</option>
          @foreach($roles as $role)
            <option value="{{$role->name}}" {{request('role')== $role->name? 'selected':''}} >{{$role->name}}</option>
          @endforeach
          </select>
          <x-input-label for="role">User Role</x-input-label>

        </div>

        <div class="relative flex-1">
          <x-text-input id="email" name="email" type="email"  placeholder="email" value="{{request('email')}}"/>
          <x-input-label for="email">Email</x-input-label>
          <div class="absolute top-0 right-0 mt-2 mr-2">
            <x-icon name="mail-open" class="hidden w-6 h-6 text-indigo-600 md:block" stroke-width="1"/>
          </div>
        </div>
        <div class="relative flex-1">
          <x-text-input id="surname" name="surname" type="text" placeholder="Surname" value="{{request('surname')}}"/>
          <x-input-label for="surname">Surname</x-input-label>
          <div class="absolute top-0 right-0 mt-2 mr-2">
            <x-icon name="users" class="hidden w-6 h-6 text-indigo-600 md:block" stroke-width="1"/>
          </div>
        </div>
        <div class="relative flex-1">
          <x-text-input id="first_name" value="{{request('first_name')}}" name="first_name" type="text" placeholder="First Name"/>
          <x-input-label for="first_name">First Name</x-input-label>
          <div class="absolute top-0 right-0 mt-2 mr-2">
            <x-icon name="user" class="hidden w-6 h-6 text-indigo-600 md:block" stroke-width="1"/>
          </div>
        </div>

      </div>
      <div class="flex justify-center mt-6">
        <button type="submit" class="px-6 py-3 text-lg font-extrabold text-white bg-indigo-300 rounded-full cursor-pointer hover:bg-indigo-100 hover:text-indigo-900">
          Search
      </button>
      </div>
    </form>

  </div>

