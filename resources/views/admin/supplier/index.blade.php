@extends('layouts.master', ['title' => 'Supplier'])

@section('content')
<x-container>
    <div class="col-12 col-lg-8">
        <x-card title="DAFTAR SUPPLIER" class="card-body p-0">
            <x-table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Supplier</th>
                        <th>No Hp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $i => $supplier)
                        <tr>
                            <td>{{ $i + $suppliers->firstItem() }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->telp }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>
                                @can('update-supplier')
                                    <x-button-modal :id="$supplier->id" title="" icon="edit" style="" class="btn btn-info btn-sm" />
                                    <x-modal :id="$supplier->id" title="Edit - {{ $supplier->name }}">
                                        <form action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-input name="name" type="text" title="Nama Supplier" placeholder="Nama Supplier" :value="$supplier->name" />
                                            <x-input name="telp" type="text" title="Telp Supplier" placeholder="Telp Supplier" :value="$supplier->telp" />
                                            <x-input name="address" type="text" title="Alamat Supplier" placeholder="Alamat Supplier" :value="$supplier->address" />
                                            <x-button-save title="Simpan" icon="save" class="btn btn-primary mt-4" />
                                        </form>
                                    </x-modal>
                                @endcan
                                @can('delete-supplier')
                                    <x-button-delete :id="$supplier->id" :url="route('admin.supplier.destroy', $supplier->id)" title="" class="btn btn-danger btn-sm" />
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </x-card>
    </div>

    @can('create-supplier')
    <div class="col-12 col-lg-4">
        <x-card title="TAMBAH SUPPLIER" class="card-body">
            <form action="{{ route('admin.supplier.store') }}" method="POST">
                @csrf
                <x-input name="name" type="text" title="Nama Supplier" placeholder="Nama Supplier" :value="old('name')" />
                <x-input name="telp" type="text" title="Telp Supplier" placeholder="Telp Supplier" :value="old('telp')" />
                <x-input name="address" type="text" title="Alamat Supplier" placeholder="Alamat Supplier" :value="old('address')" />

                <!-- Dropdown Wilayah -->
                <label for="provinsi">Provinsi:</label>
                <select id="provinsi" name="province_id" class="form-control" onchange="getWilayah('regencies', this.value)">
                    <option value="">Pilih Provinsi</option>
                </select>

                <label for="kabupaten">Kabupaten:</label>
                <select id="kabupaten" name="regency_id" class="form-control" onchange="getWilayah('districts', this.value)">
                    <option value="">Pilih Kabupaten</option>
                </select>

                <label for="kecamatan">Kecamatan:</label>
                <select id="kecamatan" name="district_id" class="form-control" onchange="getWilayah('villages', this.value)">
                    <option value="">Pilih Kecamatan</option>
                </select>

                <label for="desa">Desa:</label>
                <select id="desa" name="village_id" class="form-control">
                    <option value="">Pilih Desa</option>
                </select>

                <x-button-save title="Simpan" icon="save" class="btn btn-primary mt-4" />
            </form>
        </x-card>
    </div>
    @endcan
</x-container>

<script>
const corsProxy = 'https://api.allorigins.win/raw?url=';
const apiBaseUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api';

async function getWilayah(level, parentId = '') {
    let url = '';

    switch (level) {
        case 'regencies':
            url = `/api/wilayah/regencies/${parentId}`;
            break;
        case 'districts':
            url = `/api/wilayah/districts/${parentId}`;
            break;
        case 'villages':
            url = `/api/wilayah/villages/${parentId}`;
            break;
        default:
            url = '/api/provinces';
    }

    const response = await fetch(url);
    const data = await response.json();
    console.log(data); // Menampilkan response di console

    const targetSelect = {
        'provinces': '#provinsi',
        'regencies': '#kabupaten',
        'districts': '#kecamatan',
        'villages': '#desa'
    };

    const selectElement = document.querySelector(targetSelect[level]);
    selectElement.innerHTML = '<option value="">Pilih</option>';

    data.forEach(item => {
        selectElement.innerHTML += `<option value="${item.id}">${item.name}</option>`;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    getWilayah('provinces');
});

</script>
@endsection
