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
                <label for="email-address" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" autocomplete="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('password')
                    <div class="text-sm text-red-700 mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-6">
                <label for="email-address" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="confirm-password" autocomplete="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('password_confirmation')
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
                <select name="role" autocomplete="roles" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    @foreach ($roles as $role)
                        <option {{ old('role', $user->roles->first()->name ) == $role->name ? 'selected' : ''}} value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
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
