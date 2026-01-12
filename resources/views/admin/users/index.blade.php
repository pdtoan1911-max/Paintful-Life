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
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach ($users as $user)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 text-sm text-gray-900">{{ $user->full_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
