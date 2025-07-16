<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Models\Category;
use Livewire\Component;

class DonationFilter extends Component
{
    public $categories;
    public $campaigns;

    public $selectedCategory = ''; // Inisialisasi sebagai string kosong
    public $selectedCampaign;
    public $date_from;
    public $date_to;

    public function mount()
    {
        $this->categories = Category::latest()->get();
        $this->campaigns = collect(); // Kosongkan pada awalnya
        $this->loadInitialValues();
    }

    public function updatedSelectedCategory($categoryId)
    {
        if (!empty($categoryId)) {
            // Jika kategori dipilih, ambil campaign yang sesuai
            $this->campaigns = Campaign::where('category_id', $categoryId)->get();
        } else {
            // Jika "Semua Kategori" dipilih, tampilkan semua campaign
            $this->campaigns = Campaign::latest()->get();
        }
        // Reset pilihan campaign saat kategori berubah
        $this->reset('selectedCampaign');
    }

    public function loadInitialValues()
    {
        // Fungsi ini untuk memuat campaign saat halaman pertama kali dibuka berdasarkan filter yang mungkin sudah ada
        $this->selectedCategory = request('category_id');
        $this->selectedCampaign = request('campaign_id');
        $this->date_from = request('date_from');
        $this->date_to = request('date_to');

        if ($this->selectedCategory) {
            $this->campaigns = Campaign::where('category_id', $this->selectedCategory)->get();
        } else {
            $this->campaigns = Campaign::latest()->get();
        }
    }

    public function render()
    {
        return view('livewire.donation-filter');
    }
}