<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SidebarController extends Controller
{
    public function getSidebar()
    {
        $userRole = auth()->user()->user_priv;

        if ($userRole === 'admin') {
            $sidebarData = $this->getAdminSidebar();
        } elseif ($userRole === 'petugas') {
            $sidebarData = $this->getPetugasSidebar();
        }

        return response()->json($sidebarData);
    }

    public function getAdminSidebar ()
    {
        $sidebarContent = View::make('layouts.sidebar.admin')->render();
        $responseData = [
            'content' => $sidebarContent,
            'status' => 'success', // Atau informasi lain yang ingin Anda sertakan
        ];
    
        return response()->json($responseData);
    }

    public function getPetugasSidebar ()
    {
        $sidebarContent = View::make('layouts.sidebar.petugas')->render();
        $responseData = [
            'content' => $sidebarContent,
            'status' => 'success', // Atau informasi lain yang ingin Anda sertakan
        ];
    
        return response()->json($responseData);
    }
}
