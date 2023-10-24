<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    {{-- Nothing in the world is as soft and yielding as water. --}}
    @include('livewire.admin.brand.modal-form')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Brands List</h4>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addBrandModal" class="btn btn-primary btn-sm float-end">Add Brands</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($brands as $brand)
                            <tr>
                                <td>{{$brand->id}}</td>
                                <td>{{$brand->name}}</td>
                                <td>{{$brand->slug}}</td>
                                <td>{{$brand->status == '1' ? 'hidden' : 'visible'}}</td>
                                <td>
                                    <a href="#" wire:click="editBrand({{$brand->id}})" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#updateBrandModal">Edit</a>
                                    <a href="#"  wire:click="deleteBrand({{$brand->id}})"  data-bs-toggle="modal" data-bs-target="#deleteBrandModal" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5"> No Brands Found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div>{{$brands->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    @push('script')

        <script>
            window.addEventListener('close-modal', event => {
                $('#addBrandModal').modal('hide');
                $('#updateBrandModal').modal('hide');
                $('#deleteBrandModal').modal('hide');
            });
        </script>
    @endpush


</div>
