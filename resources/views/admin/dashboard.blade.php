@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Total Products</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalProducts }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Total Orders</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalOrders }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Total Revenue</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalRevenue }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Orders Today</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $ordersToday }}</p>
    </div>

  </div>

@endsection
