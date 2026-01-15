@extends('admin.layout')

@section('title', 'Users')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Name</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Email</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Phone</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Created At</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach ($users as $user)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 text-sm text-gray-900">{{ $user->full_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $user->created_at->format('Y-m-d') }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">
                <a href="{{ route('admin.users.show', $user) }}"
                  class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800" title="Xem chi tiết">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5z" />
                  </svg>
                </a>
                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline-block">
                  @csrf
                  <button type="submit"
                    class="p-2 border-none bg-white rounded cursor-pointer
               {{ $user->is_active ? 'text-red-600 border-red-600' : 'text-green-600 border-green-600' }}"
                    title="{{ $user->is_active ? 'Lock user' : 'Unlock user' }}">
                    @if($user->is_active)
                      {{-- Lock icon --}}
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 11c1.657 0 3 .895 3 2v3a3 3 0 11-6 0v-3c0-1.105 1.343-2 3-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0v4" />
                      </svg>
                    @else
                      {{-- Unlock icon --}}
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 11c1.657 0 3 .895 3 2v3a3 3 0 11-6 0v-3c0-1.105 1.343-2 3-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 11V7a4 4 0 00-7.75-1" />
                      </svg>
                    @endif
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection