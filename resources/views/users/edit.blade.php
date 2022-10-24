<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Ubah Hewan') }}
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            <div class="md:grid md:gap-6">
                {{-- <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                        <p class="mt-1 text-sm text-gray-600">This information will be displayed publicly so be careful what you share.</p>
                    </div>
                </div> --}}
                @if (session('success'))
                    <div id="alert-3" class="flex p-4 mb-4 border bg-green-100 rounded-lg dark:bg-green-200" role="alert">
                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Info</span>
                        <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-3" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                @endif
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <form action="{{ route('hewan.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="name" id="first-name" autocomplete="given-name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('name')
                                            <div class="text-sm text-red-700 mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="email-address" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                        <input type="text" name="email" id="email" autocomplete="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('email')
                                            <div class="text-sm text-red-700 mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <div class="mt-1">
                                            <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('alamat', $user->alamat) }}</textarea>
                                        </div>
                                        @error('alamat')
                                            <div class="text-sm text-red-700 mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                        {{-- <p class="mt-2 text-sm text-gray-500">Brief description for your profile. URLs are hyperlinked.</p> --}}
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="country" class="block text-sm font-medium text-gray-700">Role</label>
                                        <select name="role" autocomplete="roles" value="{{ old('role', $user->roles->first() ) }}"class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->name }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="text-sm text-red-700 mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                        {{-- <p class="mt-2 text-sm text-gray-500">Brief description for your profile. URLs are hyperlinked.</p> --}}
                                    </div>

                                    <div class="col-span-6 ">
                                        <div class="flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input name="status" type="checkbox" {{ old('status', $user->status) == '1' ? 'checked="checked"' : '' }} value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                @error('status')
                                                    <div class="text-sm text-red-700 mt-1 mb-1">{{ $message }}</div>
                                                @enderror

                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="comments" class="font-medium text-gray-700">Aktif</label>
                                                <p class="text-gray-500">Pengguna tidak dapat login saat status non-aktif.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
