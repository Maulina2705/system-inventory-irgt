<?php

use App\Models\Asset;
use App\Models\Placement;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\AssetItem;
use App\Services\AssetService;
use Livewire\Component;

new class extends Component
{
    public $placements = [];
    public $locations = [];
    public $assetTypes = [];
    public $assetItems = [];

    public $placement_id;
    public $location_id;
    public $asset_type_id;
    public $asset_item_id;

    public $name = '';
    public $brand = '';
    public $model = '';
    public $serial_number = '';

    public $ownership = 'IRGT School';
    public $assigned_to = '';

    public $status = 'ACTIVE';
    public $condition = 'GOOD';

    public $purchase_date = '';
    public $vendor = '';
    public $warranty_expiry = '';

    public $ip_address = '';
    public $mac_address = '';

    public $notes = '';

    public function mount()
    {
        $this->placements = Placement::orderBy('code')->get();
        $this->locations = Location::orderBy('code')->get();
        $this->assetTypes = AssetType::orderBy('code')->get();
        $this->assetItems = AssetItem::orderBy('code')->get();
    }

    public function save()
    {
        $validated = $this->validate([
            'placement_id' => 'required|exists:placements,id',
            'location_id' => 'required|exists:locations,id',
            'asset_type_id' => 'required|exists:asset_types,id',
            'asset_item_id' => 'required|exists:asset_items,id',

            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number',

            'ownership' => 'required|string|max:255',
            'assigned_to' => 'nullable|string|max:255',

            'status' => 'required|in:ACTIVE,MAINTENANCE,DAMAGED,LOST,RETIRED',
            'condition' => 'required|in:GOOD,FAIR,POOR,DAMAGED',

            'purchase_date' => 'nullable|date',
            'vendor' => 'nullable|string|max:255',
            'warranty_expiry' => 'nullable|date',

            'ip_address' => 'nullable|ip',
            'mac_address' => 'nullable|string|max:255',

            'notes' => 'nullable|string',
        ]);

        $placement = Placement::findOrFail($this->placement_id);
        $location = Location::findOrFail($this->location_id);
        $assetType = AssetType::findOrFail($this->asset_type_id);
        $assetItem = AssetItem::findOrFail($this->asset_item_id);

        $asset = app(AssetService::class)->create(
            $placement,
            $location,
            $assetType,
            $assetItem,
            $this->name,
            now()->year,
            [
                'ownership' => $this->ownership,
                'assigned_to' => $this->assigned_to ?: null,

                'brand' => $this->brand ?: null,
                'model' => $this->model ?: null,
                'serial_number' => $this->serial_number ?: null,

                'status' => $this->status,
                'condition' => $this->condition,

                'purchase_date' => $this->purchase_date ?: null,
                'vendor' => $this->vendor ?: null,
                'warranty_expiry' => $this->warranty_expiry ?: null,

                'ip_address' => $this->ip_address ?: null,
                'mac_address' => $this->mac_address ?: null,

                'notes' => $this->notes ?: null,
            ]
        );

        session()->flash(
            'success',
            'Asset berhasil dibuat: ' . $asset->asset_code
        );

        $this->resetForm();
    }

    private function resetForm()
    {
        $this->placement_id = null;
        $this->location_id = null;
        $this->asset_type_id = null;
        $this->asset_item_id = null;

        $this->name = '';
        $this->brand = '';
        $this->model = '';
        $this->serial_number = '';

        $this->ownership = 'IRGT School';
        $this->assigned_to = '';

        $this->status = 'ACTIVE';
        $this->condition = 'GOOD';

        $this->purchase_date = '';
        $this->vendor = '';
        $this->warranty_expiry = '';

        $this->ip_address = '';
        $this->mac_address = '';

        $this->notes = '';
    }
};
?>

<div>
    <h1>Tambah Asset</h1>

    @if (session()->has('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save">

        <div>
            <label>Placement</label>

            <select wire:model="placement_id">
                <option value="">-- Pilih Placement --</option>

                @foreach ($placements as $placement)
                    <option value="{{ $placement->id }}">
                        {{ $placement->code }} - {{ $placement->name }}
                    </option>
                @endforeach
            </select>

            @error('placement_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Location</label>

            <select wire:model="location_id">
                <option value="">-- Pilih Location --</option>

                @foreach ($locations as $location)
                    <option value="{{ $location->id }}">
                        {{ $location->code }} - {{ $location->name }}
                    </option>
                @endforeach
            </select>

            @error('location_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Jenis Barang</label>

            <select wire:model="asset_type_id">
                <option value="">-- Pilih Jenis --</option>

                @foreach ($assetTypes as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->code }} - {{ $type->name }}
                    </option>
                @endforeach
            </select>

            @error('asset_type_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Kode Barang</label>

            <select wire:model="asset_item_id">
                <option value="">-- Pilih Barang --</option>

                @foreach ($assetItems as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->code }} - {{ $item->name }}
                    </option>
                @endforeach
            </select>

            @error('asset_item_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <hr>

        <div>
            <label>Nama Asset</label>
            <input type="text" wire:model="name">

            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Brand</label>
            <input type="text" wire:model="brand">
        </div>

        <div>
            <label>Model</label>
            <input type="text" wire:model="model">
        </div>

        <div>
            <label>Serial Number</label>
            <input type="text" wire:model="serial_number">

            @error('serial_number')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <hr>

        <div>
            <label>Ownership</label>
            <input type="text" wire:model="ownership">
        </div>

        <div>
            <label>Assigned To</label>
            <input type="text" wire:model="assigned_to">
        </div>

        <div>
            <label>Status</label>

            <select wire:model="status">
                <option value="ACTIVE">ACTIVE</option>
                <option value="MAINTENANCE">MAINTENANCE</option>
                <option value="DAMAGED">DAMAGED</option>
                <option value="LOST">LOST</option>
                <option value="RETIRED">RETIRED</option>
            </select>
        </div>

        <div>
            <label>Condition</label>

            <select wire:model="condition">
                <option value="GOOD">GOOD</option>
                <option value="FAIR">FAIR</option>
                <option value="POOR">POOR</option>
                <option value="DAMAGED">DAMAGED</option>
            </select>
        </div>

        <hr>

        <div>
            <label>Tanggal Pembelian</label>
            <input type="date" wire:model="purchase_date">
        </div>

        <div>
            <label>Vendor</label>
            <input type="text" wire:model="vendor">
        </div>

        <div>
            <label>Warranty Expiry</label>
            <input type="date" wire:model="warranty_expiry">
        </div>

        <hr>

        <div>
            <label>IP Address</label>
            <input type="text" wire:model="ip_address">

            @error('ip_address')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>MAC Address</label>
            <input type="text" wire:model="mac_address">
        </div>

        <div>
            <label>Catatan</label>
            <textarea wire:model="notes"></textarea>
        </div>

        <br>

        <button type="submit">
            Simpan Asset
        </button>

    </form>
</div>