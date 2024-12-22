<?php
namespace App\View\Components;

use App\Models\Identifiant;
use Illuminate\View\Component;
use App\Models\Identification;

class CompanyFooter extends Component
{
    public $identification;

    public function __construct()
    {
        // Fetch the first identification record
        $this->identification = Identifiant::first();
    }

    public function render()
    {
        return view('components.company-footer');
    }
}
