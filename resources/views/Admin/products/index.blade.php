@extends('layouts.master')
@section('content')

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                confirmButtonColor: "#3085d6",
                text: '{{ session('success') }}'
            });
        });
    </script>
@endif

<div class="flex justify-between mt-8">
    <div class="flex justify-start mb-4 mt-10">
        <input type="text" id="search" class="h-10 px-4 w-60 border rounded-md" placeholder="Search">
    </div>
    <div class="flex justify-end mb-4 mt-10">
        <a href="#" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg" data-modal-target="add" data-modal-toggle="add">Add Product</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">No</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Products Name</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Products Image</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Brands</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Category</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Stock</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Unit Price</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody class="text-center" id="product-table-body">
            @foreach($products as $product)
            <tr class="border-b border-gray-200">
                <td class="px-5 py-5 bg-white text-sm">{{$loop->iteration}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$product->product_name}}</td>
                <td class="px-5 py-5 bg-white text-sm ">
                    <div class="flex justify-center">
                        @if($product->product_image)
                        <img src="{{ asset(  $product->product_image) }}" alt="Product Image" class="w-10 h-10">
                        @else
                        <span>No Image</span>
                        @endif
                    </div>
                </td>
                </td>
                <td class="px-5 py-5 bg-white text-sm">{{$product->brand->brand_name}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$product->categories->category_name}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$product->stock}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ formatRupiah($product->unit_price) }}</td>
                <td class="px-5 py-5  bg-white text-sm flex space-x-2 items-center justify-center">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-lg" data-modal-target="info{{$product->id}}" data-modal-toggle="info{{$product->id}}"><i class="fas fa-info-circle"></i></a>
                    <a href="#" class="text-green-500 hover:text-green-700 text-base" data-modal-target="edit{{$product->id}}" data-modal-toggle="edit{{$product->id}}"><i class="fas fa-pen"></i></a>
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-end mt-4">
    <nav aria-label="Page navigation">
        <ul class="inline-flex space-x-2">
            @if ($products->onFirstPage())
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></span></li>
            @else
                <li><a href="{{ $products->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></a></li>
            @endif

            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if ($page == $products->currentPage())
                    <li><span class="px-3 py-1 bg-red-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($products->hasMorePages())
                <li><a href="{{ $products->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></a></li>
            @else
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></span></li>
            @endif
        </ul>
    </nav>
</div>

  

<!--modal info-->
@foreach ($products as $product)
<div id="info{{$product->id}}" tabindex="-1"  aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-2 md:p-5 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                   Product detail
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="info{{$product->id}}">
                  <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5">
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="dropzone-file-{{ $product->id }}" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div id="file-info" class="flex flex-col items-center justify-center">
                                <img id="preview-image-{{ $product->id }}" width="80" height="80" src="{{ asset($product->product_image) }}" alt="Product Image" class="absolute">
                            </div>
                        </label>
                    </div>
                    <div class="col-span-2">
                        <label for="product_name" class="block mb-2 text-sm font-normal text-white">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" value="{{$product->product_name}}" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="id_brand" class="block mb-2 text-sm font-normal text-white">Brand</label>
                        <select id="id_brand detail" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" >
                          @foreach ($brands as $brand)
                              <option  value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <label for="id_category" class="block mb-2 text-sm font-normal text-white">Category</label>
                      <select id="id_category detail" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" readonly>
                          @foreach ($categories as $category)
                              <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                          @endforeach
                    </select>
                   </div>                   
                   <div class="col-span-2 sm:col-span-1">
                      <label for="unit_price" class="block mb-2 text-sm font-normal text-white">Unit Price</label>
                      <input type="text" name="unit_price" id="unit_price" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" placeholder="Unit Price" value="{{$product->unit_price}}" readonly>
                   </div>
                   <div class="col-span-2 sm:col-span-1">
                       <label for="stock" class="block mb-2 text-sm font-normal text-white">Stock</label>
                       <input type="text" name="stock" id="stock" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" placeholder="Stock" value="{{$product->stock}}" readonly>
                      </div>
                  </div>
                  <div class="col-span-2">
                    <label for="desc_product" class="block mb-2 text-sm font-normal text-white">Description</label>
                    <textarea type="text" name="desc_product" id="desc_product" class="bg-[#3D4142] text-white text-sm h-30 resize-none focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Description Product" readonly>{{$product->desc_product}}</textarea>
                </div>
                  <hr class="my-6">
              </div>
            </form>
        </div>
    </div>
    <!--modal info end-->

@endforeach

    <!-- Modal add -->
<div id="add" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-center p-1 md:p-0 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white mt-5">
                    Add New Product
                </h3>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div id="file-info" class="flex flex-col items-center justify-center">
                                <img id="preview-image" width="80" height="80" src="https://static-00.iconduck.com/assets.00/no-image-icon-512x512-lfoanl0w.png" alt="Uploaded Image">
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400"><span class="font-light">Add Product Image</span></p>
                            </div>
                            <input id="dropzone-file" type="file" name="product_image" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <div class="col-span-2">
                        <label for="product_name" class="block mb-2 text-sm font-normal text-white">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Product Name" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="id_brand" class="block mb-2 text-sm font-normal text-white">Brand</label>
                        <select id="id_brand" name="id_brand" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" required>
                            <option selected disabled hidden>Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="id_category" class="block mb-2 text-sm font-normal text-white">Category</label>
                        <select id="id_category" name="id_category" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" required>
                            <option selected disabled hidden>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="unit_price" class="block mb-2 text-sm font-normal text-white">Unit Price</label>
                        <input type="text" name="unit_price" id="unit_price" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Unit Price" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="stock" class="block mb-2 text-sm font-normal text-white">Stock</label>
                        <input type="number" name="stock" id="stock" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Stock" required>
                    </div>
                    <div class="col-span-2">
                        <label for="desc_product" class="block mb-2 text-sm font-normal text-white">Description</label>
                        <textarea type="text" name="desc_product" id="desc_product" class="bg-[#3D4142] text-white text-sm h-30 resize-none focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Description Product" required></textarea>
                    </div>
                </div>
                <hr class="mb-7">
                <div class="col-span-2 mb-2 text-center">
                    <button type="button" class="text-white bg-transparent hover:bg-red-700 text-sm px-5 py-2.5 rounded-lg ms-auto inline-flex justify-center items-center" data-modal-toggle="add">
                        Cancel
                        <span class="sr-only">Close modal</span>
                    </button>
                    <button type="submit" class="text-white inline-flex justify-end items-center bg-[#EB2929] hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal add end -->



<!--modal edit-->

@foreach($products as $product)
  <div id="edit{{$product->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-[#272626] rounded-2xl shadow">
        <!-- Modal header -->
        <div class="flex items-center justify-center p-1 md:p-0 rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-white mt-5">Edit Product</h3>
        </div>
        <!-- Modal body -->
        <form class="p-2 md:p-5" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <hr class="mb-3">
          <div class="grid gap-4 mb-4 grid-cols-2">
              <div class="col-span-2">
                        <label for="dropzone-file-{{ $product->id }}" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div id="file-info" class="flex flex-col items-center justify-center">
                                <img id="preview-image-{{ $product->id }}" width="80" height="80" src="{{ asset($product->product_image) }}" alt="Brand Image" class="absolute opacity-40">
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 text-center relative"><span class="font-bold text-neutral-200 text-base z-10"><i class="fa-solid fa-pen fa-xl"></i></span></p>
                            </div>
                            <input id="dropzone-file-{{ $product->id }}" type="file" name="product_image" class="hidden" accept="image/*" />
                        </label>
                    </div>
            <div class="col-span-2 text-white font-semibold">
              <h2>Product Details</h2>
            </div>
            <div class="col-span-2">
              <label for="product_name" class="block mb-2 text-sm font-normal text-white">Product Name</label>
              <input type="text" name="product_name" id="product_name" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $product->product_name }}" required>
            </div>
            <div class="col-span-2 sm:col-span-1">
              <label for="id_brand" class="block mb-2 text-sm font-normal text-white">Brand</label>
              <select name="id_brand" id="id_brand" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5">
                @foreach ($brands as $brand)
                  <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-span-2 sm:col-span-1">
              <label for="id_category" class="block mb-2 text-sm font-normal text-white">Category</label>
              <select name="id_category" id="id_category" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5">
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-span-2 sm:col-span-1">
              <label for="unit_price" class="block mb-2 text-sm font-normal text-white">Unit Price</label>
              <input type="text" name="unit_price" id="unit_price" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $product->unit_price }}" required>
            </div>
            <div class="col-span-2 sm:col-span-1">
              <label for="stock" class="block mb-2 text-sm font-normal text-white">Stock</label>
              <input type="number" name="stock" id="stock" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $product->stock }}" required>
            </div>
            <div class="col-span-2">
              <label for="desc_product" class="block mb-2 text-sm font-normal text-white">Description</label>
              <textarea name="desc_product" id="desc_product" class="bg-[#3D4142] text-white text-sm h-30 resize-none focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Description Product" required>{{ $product->desc_product }}</textarea>
            </div>
          </div>
          <hr class="mb-7">
          <div class="col-span-2 mb-2 text-center">
            <button type="button" class="text-white bg-transparent hover:bg-red-700 text-sm px-5 py-2.5 rounded-lg ms-auto inline-flex justify-center items-center" data-modal-toggle="edit{{$product->id}}">
              Cancel
              <span class="sr-only">Close modal</span>
            </button>
            <button type="submit" class="text-white inline-flex justify-end items-center bg-[#EB2929] hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
  <!--modal edit end-->

  <script src="{{ asset('js/search.js') }}"></script>
  <script src="{{ asset('js/previewImage.js') }}"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

</script>
<script>
    document.getElementById('id_brand detail').disabled = true;
    document.getElementById('id_category detail').disabled = true;
</script>
@endsection